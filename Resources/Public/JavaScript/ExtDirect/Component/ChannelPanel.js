Ext.ns('MvcExtjsSamples.ExtDirectModule');
/**
 * ChannelPanel
 * 
 * @class MvcExtjsSamples.ExtDirectModule.ChannelPanel
 */
MvcExtjsSamples.ExtDirectModule.ChannelPanel = Ext.extend(Ext.Panel,{
	
	channel: false,
	
	messageBox: false,
	
	dateFormat: 'j. F Y H:i:s',
	
	constructor: function(config) {
		this.channel = config.channel.data;
		this.messageBox = new Ext.form.DisplayField({
	        cls: 'x-form-text',
	        region: 'center'
	    });
			
		// (this.lastMessage,this.channel,MvcExtjsSamples.ExtDirectModule.Chat.get())
		MvcExtjsSamples.ExtDirectModule.ChannelPanel.superclass.constructor.call(this, config);
		
		this.add(this.messageBox);
		
		this.on('afterrender', function() {
			this.addMessage({text: 'Channel betreten.'});
			var messages = config.channel.data.messages;
			Ext.each(messages, function(message, index, length) {
				this.addMessage(message);
			},this);
		});
	},
	
	formatName: function(user) {
		return user.username;
	},
	
	addMessage: function(message) {
		if (message.creationDate) {
			var time = Date.parseDate(message.creationDate,'U');
		} else {
			var time = new Date();
		}
		if (message.backendUser) {
			this.renderUserMessage(time,message);
		} else {
			this.renderChannelMessage(time,message);
		}
		if (this.messageBox.rendered == true) { 
			this.messageBox.el.scroll('b', 100000, true);
		}
	},
	
	addMessages: function(messages) {
		Ext.each(messages, function(message, index, length){
			this.addMessage(message);
		},this)
	},
	
	renderUserMessage: function(date, message) {
		username = this.formatName(message.backendUser);
		this.messageBox.append(String.format('<p>({0}) <b>{1}</b>:<i>{2}</i></p>', date.format(this.dateFormat) ,username, message.text));
	},
	
	renderChannelMessage: function(date, message) {
		this.messageBox.append(String.format('<p>({0}):<b>{1}</b></p>', date.format(this.dateFormat), message.text));
	}
		
});
/**
 * ChannelPanelFactory
 * 
 * @class MvcExtjsSamples.ExtDirectModule.ChannelPanelRepository
 * @singleton
 */
MvcExtjsSamples.ExtDirectModule.ChannelPanelRepository = function(){
	
	var create = function(channel) {
		config = {
			title: 'Channel: ' + channel.data.name,
			id: channel.data.name + '_' + channel.data.uid,
			layout: 'border',
			border: false,
			closable: true,
			id: 'ChannelPanel' + channel.data.uid,
			channel: channel  
		};
		panel = new MvcExtjsSamples.ExtDirectModule.ChannelPanel(config);
		return panel;
	};
	
	var find = function(channel) {
		panel = Ext.getCmp('ChannelPanel' + channel.uid);
		if (!panel) {
			panel = create(channel);
		}
		return panel;
	}
	
    return Ext.apply(new Ext.util.Observable, {
    	find: find
    })
}();