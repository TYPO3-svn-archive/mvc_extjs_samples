
Ext.namespace('MvcExtjsSamples.Genre'); 

MvcExtjsSamples.Genre.GridPanel = Ext.extend(Ext.grid.GridPanel, {
	constructor: function(config) {
		
		var editor = new Ext.ux.grid.RowEditor({
			saveText: 'Update'
		});

		config = Ext.apply({
			title: 'Genre List',
			region: "center",
			store: new MvcExtjsSamples.ViewBasedModule.GenreStore,
			columns: MvcExtjsSamples.ViewBasedModule.GenreColumns,
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
	                var genre = new this.store.recordType({
	                    name: 'New Genre',
	                });
	                editor.stopEditing();
	                this.store.insert(0, genre);
	                this.getView().refresh();
	                this.getSelectionModel().selectRow(0);
	                editor.startEditing(0);
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

		MvcExtjsSamples.Genre.GridPanel.superclass.constructor.call(this, config);
	}
});