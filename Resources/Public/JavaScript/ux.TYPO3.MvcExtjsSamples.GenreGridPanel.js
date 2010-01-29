Ext.namespace('MvcExtjsSamples.GenreGridPanel'); 

MvcExtjsSamples.GenreGridPanel = Ext.extend(Ext.grid.GridPanel, {
	constructor: function(config) {
		config = Ext.apply({
			title: 'Genre List',
			region: "west",
			store: new MvcExtjsSamples.ViewBasedModule.GenreStore,
			columns: MvcExtjsSamples.ViewBasedModule.GenreColumns,
		}, config);

		MvcExtjsSamples.GenreGridPanel.superclass.constructor.call(this, config);
	},
});
