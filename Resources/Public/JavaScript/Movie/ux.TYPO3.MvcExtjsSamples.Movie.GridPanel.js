Ext.namespace('Ext.ux.TYPO3.MvcExtjsSamples.Movie'); 
/**
 * A GridPanel that displays movies using the ExtDirect Store.
 */
Ext.ux.TYPO3.MvcExtjsSamples.Movie.GridPanel = Ext.extend(Ext.grid.GridPanel, {
	constructor: function(config) {
		
		var editor = new Ext.ux.grid.RowEditor({
			saveText: 'Update'
		});

		config = Ext.apply({
			title: 'Movie List',
			columns: [{
				dataIndex: 'title',
				header: 'Title',
				editor: new Ext.form.TextField()
			},{
				dataIndex: 'director',
				header: 'Director',
				editor: new Ext.form.TextField()
			},{
				dataIndex: 'releaseDate',
				header: 'Release Date',
				xtype: 'datecolumn',
				format: 'd.m.Y',
				editor: new Ext.form.DateField()
			},{
				dataIndex: 'genre',
				header: 'Genre',
				renderer: Ext.ux.TYPO3.MvcExtjsSamples.Genre.GridRenderer,
				editor: new Ext.form.ComboBox({
				    typeAhead: true,
				    triggerAction: 'all',
				    lazyRender:true,
				    mode: 'local',
				    store: Ext.StoreMgr.get('Tx_MvcExtjsSamples_Domain_Model_Genre'),
				    valueField: '__identity',
				    displayField: 'name',
				    /**
				     * Override this funtion to return objects instead of int
				     */
				    getValue : function(){
				        if(this.valueField){
				            return Ext.isDefined(this.value) ? this.prepareValue(this.value) : '';
				        }else{
				            return Ext.form.ComboBox.superclass.getValue.call(this);
				        }
				    },
				    /**
				     * Override this funtion to support object been setted from the outside
				     */
				    setValue : function(v){
				    	if (Ext.isObject(v)) v = v.__identity;
				        var text = v;
				        if(this.valueField){
				            var r = this.findRecord(this.valueField, v);
				            if(r){
				                text = r.data[this.displayField];
				            }else if(Ext.isDefined(this.valueNotFoundText)){
				                text = this.valueNotFoundText;
				            }
				        }
				        this.lastSelectionText = text;
				        if(this.hiddenField){
				            this.hiddenField.value = Ext.value(v, '');
				        }
				        Ext.form.ComboBox.superclass.setValue.call(this, text);
				        this.value = v;
				        return this;
				    },
				    /**
				     * Helper method that creates a object of the the valueField and displayField
				     */
				    prepareValue: function(v) {
				    	var object = {};
				    	object[this.valueField] = v;
				    	var r = this.findRecord(this.valueField, v);
				    	if (r) {
				    		object[this.displayField] = r.data[this.displayField];
				    	}
				    	return object;
				    }
				})
			}],
			viewConfig: {
				forceFit: true,
				autoFill: true
			},
			sm: new Ext.grid.RowSelectionModel({
				singleSelect:true
			}),
			loadMask: {
				msg: 'loading ...',
			},
			plugins: [editor],
			tbar: [{
				icon: '../typo3/sysext/t3skin/icons/gfx/new_el.gif',
                cls: 'x-btn-text-icon',
	            text: 'New',
	            scope: this,
	            handler: function(){
	                var movie = new this.store.recordType({
	                	title: 'New Movie'
	                });
	                editor.stopEditing();
	                this.store.insert(0, movie);
	                this.store.on('write', function(store, action, result, transaction, record) {
	                	if (action == 'create') {
	                		this.getView().refresh();
	                		this.getSelectionModel().selectRow(0);
	                		editor.startEditing(0);
	                	}
	                },this,{
	                	single: true
	                })
	            }
	        },{
                icon: '../typo3/sysext/t3skin/icons/gfx/garbage.gif',
                cls: 'x-btn-text-icon',
	            text: 'Delete',
	            scope: this,
	            handler: function(){
	                editor.stopEditing();
	                var s = this.getSelectionModel().getSelections();
	                for(var i = 0, r; r = s[i]; i++){
	                    this.store.remove(r);
	                }
	            }
	        },{
                icon: '../typo3/sysext/t3skin/icons/gfx/refresh_n.gif',
                cls: 'x-btn-text-icon',
	            text: 'Refresh',
	            scope: this,
	            handler: function(){
	        		this.getStore().load();
	            }
	        }]
		}, config);
		Ext.ux.TYPO3.MvcExtjsSamples.Movie.GridPanel.superclass.constructor.call(this, config);
	}
});