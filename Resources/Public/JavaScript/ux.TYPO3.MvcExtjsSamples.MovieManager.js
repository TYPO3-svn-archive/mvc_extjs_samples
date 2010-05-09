Ext.namespace('MvcExtjsSamples'); 

MvcExtjsSamples.MovieManager = Ext.extend(Ext.TabPanel, {
	constructor: function(config) {
		config = Ext.apply({
			title: 'MovieManager',
			region: "center",
			forceLayout: true,
			activeTab: 0,
			items: [new MvcExtjsSamples.Movie.GridPanel,new MvcExtjsSamples.Genre.GridPanel]
		}, config);

		MvcExtjsSamples.MovieManager.superclass.constructor.call(this, config);
	},
});
