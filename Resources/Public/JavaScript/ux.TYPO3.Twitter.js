/***************************************************************
 * 
 * Copyright notice
 *
 * (c) 2009 Steffen Kamper <info@sk-typo3.de>
 * 
 ***************************************************************/
Ext.ns('Ext.ux.TYPO3');  

// override only needed for non array response :(
Ext.override(Ext.data.JsonReader, {
	readRecords : function(o){
		this.jsonData = o;
		if(o.metaData){
			delete this.ef;
			this.meta = o.metaData;
			this.recordType = Ext.data.Record.create(o.metaData.fields);
			this.onMetaChange(this.meta, this.recordType, o);
		}
		var s = this.meta, Record = this.recordType,
			f = Record.prototype.fields, fi = f.items, fl = f.length;
		if (!this.ef) {
			if(s.totalProperty) {
				this.getTotal = this.getJsonAccessor(s.totalProperty);
			}
			if(s.successProperty) {
				this.getSuccess = this.getJsonAccessor(s.successProperty);
			}
			this.getRoot = s.root ? this.getJsonAccessor(s.root) : function(p){return p;};
			if (s.id) {
				var g = this.getJsonAccessor(s.id);
				this.getId = function(rec) {
					var r = g(rec);
					return (r === undefined || r === "") ? null : r;
				};
			} else {
				this.getId = function(){return null;};
			}
			this.ef = [];
			for(var i = 0; i < fl; i++){
				f = fi[i];
				var map = (f.mapping !== undefined && f.mapping !== null) ? f.mapping : f.name;
				this.ef[i] = this.getJsonAccessor(map);
			}
		}
		var root = this.getRoot(o);
		if(!Ext.isArray(root)){
			root = [root];
		}
		var c = root.length, totalRecords = c, success = true;
		if(s.totalProperty){
			var v = parseInt(this.getTotal(o), 10);
			if(!isNaN(v)){
				totalRecords = v;
			}
		}
		if(s.successProperty){
			var v = this.getSuccess(o);
			if(v === false || v === 'false'){
				success = false;
			}
		}
		var records = [];
		for(var i = 0; i < c; i++){
			var n = root[i];
			var values = {};
			var id = this.getId(n);
			for(var j = 0; j < fl; j++){
				f = fi[j];
				var v = this.ef[j](n);
				values[f.name] = f.convert((v !== undefined) ? v : f.defaultValue, n);
			}
			var record = new Record(values, id);
			record.json = n;
			records[i] = record;
		}
		return {
			success : success,
			records : records,
			totalRecords : totalRecords
		};
	}
});



Ext.ux.TYPO3.Twitter = Ext.extend(Ext.util.Observable, {
	width: 400,
	height: 300,
	imageWidth: 70,
	interval: 0,
	columnHeader: ['User', 'Tweets'],
	lang: 'en',
	resultsPerPage: 15,
	dateTimeFormat: 'd.m.y H:i',
	fuzzyTime: false,
	labels: ['ID:', 'Followers:', 'Friends:', 'Favourites:', 'Timezone:'],
	fuzzyLabels: ['less than a minute ago', 'about a minute ago', '# minutes ago', 'about an hour ago', 'about # hours ago', '1 day ago', '# days ago'],
	 
	constructor: function(elId, config) {
		config = config || {};
		Ext.apply(this, config);
		Ext.ux.TYPO3.Twitter.superclass.constructor.call(this, config);

		this.storeId = 'TwitterStore_' + elId;
		this.el = Ext.get(elId);

		if (this.width < 250) {
			this.width = 250;
		}
		if (this.height < 50) {
			this.height = 50;
		}
		this.msgWidth = this.width - this.imageWidth - 26;
		
		if (this.interval > 0  && this.interval < 30) {
			//make sure you don't get blocked by twitter.com'
			this.interval = 30;
		}
		if (this.keyword) {
			this.url = "http://search.twitter.com/search.json?q=" + this.keyword.replace('#', '%26') + "&rpp=" + this.resultsPerPage;
			this.mode = 1;
		} else if (this.username) {
			this.url = "http://twitter.com/users/show.json?screen_name=" + this.username;
			this.mode = 2;
		} else {
			this.url = "http://twitter.com/statuses/public_timeline.json";
			this.mode = 0;
		}
		
		this.initComponents();
		this.loadComponents();
	},
	
	initComponents: function() {
		// create the Data Store
		this.store = new Ext.data.JsonStore({
			storeId: this.storeId,
			idProperty: 'id',
			fields: this.getFields(),
            root: this.mode === 1 ? 'results' : undefined,
            
			proxy: new Ext.data.ScriptTagProxy({
				url: this.url
			})
		});
		
		// create the grid
		this.grid = new Ext.grid.GridPanel({
			store: this.store,
			columns: this.getColumns(),
			enableColumnHide: false,
			enableColumnMove: false,
			enableColumnResize: false,
			enableHdMenu : false,

			renderTo: this.el,
			width: this.width,
			height: this.height,
			loadMask: true
		});
	},
	
	loadComponents: function() {
		this.loadingTask = {
			run: function(){
				this.store.reload();
			},
			interval: this.interval * 1000,
			scope: this
		};
		// start the Data store load
		if (this.interval > 0) {
			Ext.TaskMgr.start(this.loadingTask);
		} else {
			this.store.load();
		}
		
	},
	
	/* getters */	
	getMessage: function(val, p, record) {
		var txt = val + " ";
		txt =  this.replaceLinks(txt);
		txt =  this.replaceHashes(txt);
		txt =  this.replaceUser(txt);
		if (this.mode === 0) {
			return String.format('<p class="user-from"><a href="http:\/\/www.twitter.com\/{0}" target=\"_blank\">{0}<\/a></p><p class="getMessage">{1}</p><p class="tweetwhen">{2}</p>', record.data.user.name, txt, 'posted ' + this.getTime(record.data.created_at) + ' with ' + Ext.util.Format.htmlDecode(record.data.source));
		} else if (this.mode === 1) {
			return String.format('<p class="user-from"><a href="http:\/\/www.twitter.com\/{0}" target=\"_blank\">{0}<\/a></p><p class="getMessage">{1}</p><p class="tweetwhen">{2}</p>', record.data.from_user, txt, 'posted ' + this.getTime(record.data.created_at) + ' with ' + Ext.util.Format.htmlDecode(record.data.source));
		}
	},
	
	getProfile: function(val, p, record) {
		var tmpl = '<div class="user-from">{0}</div>' + 
		'<div class="user-info">' + this.labels[0] + ' {1}</div>' +
		'<div class="user-info">' + this.labels[1] + ' {2}</div>' +
		'<div class="user-info">' + this.labels[2] + ' {3}</div>' +
		'<div class="user-info">' + this.labels[3] + ' {4}</div>' +
		'<div class="user-info">' + this.labels[4] + ' {5}</div>' +
		'<div class="user-msg">{6}<br /><span>{7}</span></div>';
		var at = this.getTime(record.data.status.created_at);
		var txt = record.data.status.text + " ";
		txt =  this.replaceLinks(txt);
		txt =  this.replaceHashes(txt);
		txt =  this.replaceUser(txt);
		return String.format(tmpl, 
			record.data.screen_name, record.data.id, record.data.followers_count, record.data.friends_count, 
			record.data.favourites_count, record.data.time_zone, at, txt);
		
	},
	
	getUserPicture: function(val, p, record) {
		if (this.mode === 0) {  
			return String.format('<img src="{0}" width="{1}" height="{1}" />', record.data.user.profile_image_url, this.imageWidth);
		} else {
			return String.format('<img src="{0}" width="{1}" height="{1}" />', val, this.imageWidth);
		}
	},
	
	getfuzzyTime: function(time_value) {
		var values = time_value.split(" ");
		time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
		var parsed_date = Date.parse(time_value);
		var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
		var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
		delta = delta + (relative_to.getTimezoneOffset() * 60);

		if (delta < 60) {
			return this.fuzzyLabels[0];
		} else if(delta < 120) {
			return this.fuzzyLabels[1];
		} else if(delta < (60*60)) {
			return this.fuzzyLabels[2].replace('#',(parseInt(delta / 60)).toString());
		} else if(delta < (120*60)) {
			return this.fuzzyLabels[3];
		} else if(delta < (24*60*60)) {
			return this.fuzzyLabels[4].replace('#', (parseInt(delta / 3600)).toString());
		} else if(delta < (48*60*60)) {
			return this.fuzzyLabels[5] ;
		} else {
			return this.fuzzyLabels[6].replace('#', (parseInt(delta / 86400)).toString());
		}
	},
	
	getTime: function(time_value) {
		if (this.fuzzyTime) {
			return this.getfuzzyTime(time_value);
		} else {
			return 'at ' + Ext.util.Format.date(time_value, this.dateTimeFormat);
		}
	},
	
	getColumns: function() {
		if (this.mode === 0) {
			return [
				{ header: this.columnHeader[0], width: this.imageWidth + 4, dataIndex: 'user', sortable: false, renderer: this.getUserPicture, scope: this},
				{ header: this.columnHeader[1], width: this.msgWidth, dataIndex: 'text', sortable: false, renderer: this.getMessage, scope: this}
			];
		} else if (this.mode === 1) {
			return [
				{ header: this.columnHeader[0], width: this.imageWidth + 4, dataIndex: 'profile_image_url', sortable: false, renderer: this.getUserPicture, scope: this},
				{ header: this.columnHeader[1], width: this.msgWidth, dataIndex: 'text', sortable: false, renderer: this.getMessage, scope: this}
			];
		} else if (this.mode === 2) {
			return [
				{ header: this.columnHeader[0], width: this.imageWidth + 4, dataIndex: 'profile_image_url', sortable: false, renderer: this.getUserPicture, scope: this},
				{ header: this.columnHeader[1], width: this.msgWidth, dataIndex: 'id', sortable: false, renderer: this.getProfile, scope: this}
			];
		}
	},
	
	getFields: function() {
		if (this.mode === 0) {
			return ['id', 'text', 'user', 'source', 'in_reply_to_screen_name', 'in_reply_to_status_id', 'in_reply_to_user_id', 'created_at'];
		} else if (this.mode === 1) {
			return ['id', 'text', 'from_user', 'from_user_id', 'source', 'iso_language_code', 'to_user_id', 'profile_image_url', 'created_at' ];
		} else if (this.mode === 2) {
			return ['id', 'profile_sidebar_fill_color', 'time_zone', 'screen_name', 'profile_image_url', 'profile_background_image_url', 'statuses_count', 'followers_count', 'favourites_count', 'friends_count', 'profile_background_color', 'status'];
		}
	},
	
	/* Helper functions */
	replaceUser: function(str) {
		return str.replace(/[<=\^|\s]+[@]+([\w]+)/g, function(u) {
			var username = u.trim().replace("@", "");
			return ' <a href="http:\/\/www.twitter.com\/' + username + '" target=\"_blank\">@' + username + '<\/a>';
		});

	},
	
	replaceHashes: function(str) {
		return str.replace(/[<=\^|\s]+[#]+([\w]+)/g, function(h) {
			var hashtag = h.trim().replace("#", "");
			return ' <a href="http:\/\/www.hashtags.org\/tag\/' + hashtag + '" target=\"_blank\">' + h + '<\/a>';
		});
	},
	
	replaceLinks: function(str) {
		return str.replace(/http:\/\/(.+?)[ ]/g, function(h) {
			h = h.trim();
			return ' <a href="' + h + '" target=\"_blank\">' + h + '<\/a>';
		});
	}
	
});

