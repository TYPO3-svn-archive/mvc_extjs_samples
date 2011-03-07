Ext.namespace('Ext.ux.TYPO3.MvcExtjsSamples.Genre'); 
/**
 * A GridPanel to display Genre records.
 */
Ext.ux.TYPO3.MvcExtjsSamples.Genre.GridPanel = Ext.extend(Ext.grid.GridPanel, {
	constructor: function(config) {
		
		var editor = new Ext.ux.grid.RowEditor({
			saveText: 'Update'
		});

		config = Ext.apply({
			title: 'Genre List',
			columns: [{
				dataIndex: 'name',
				header: 'Name',
				editor: new Ext.form.TextField()
			}],
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
	                	name: 'New Genre'
	                });
	                editor.stopEditing();
	                this.store.insert(0, genre);
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

		Ext.ux.TYPO3.MvcExtjsSamples.Genre.GridPanel.superclass.constructor.call(this, config);
	}
});