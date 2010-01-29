Ext.namespace('MvcExtjsSamples.HelloWorldPanel'); 

MvcExtjsSamples.HelloWorldPanel = Ext.extend(Ext.Panel, {
	constructor: function(config) {
		config = Ext.apply({
			title: 'Hello World',
			region: "center",
			html: 'just a hello world panel...'
		}, config);

		MvcExtjsSamples.HelloWorldPanel.superclass.constructor.call(this, config);
	},
});
