Ext.namespace('Ext.ux.TYPO3.MvcExtjsSamples.Movie'); 
/**
 * A Store for the movie model using ExtDirect to communicate with the
 * server side extbase framework.
 */
Ext.ux.TYPO3.MvcExtjsSamples.Movie.Store = function() {
	
	movieStore = null;
	
	var initialize = function() {
		if (movieStore == null) {
			movieStore = new Ext.data.DirectStore({
				storeId: 'Tx_MvcExtjsSamples_Domain_Model_Movie',
				reader: new Ext.data.JsonReader({
					totalProperty:'total',
					successProperty:'success',
					idProperty:'__identity',
					root:'data',
					fields:[
					    {name: '__identity', type: 'int'},
					    {name: 'title', type: 'string'},
					    {name: 'director', type: 'string'},
					    {name: 'releaseDate', type: 'date'},
					    {name: 'genre', type: 'object'}
					]
				}),
				writer: new Ext.data.JsonWriter({
					encode:false,
					writeAllFields:false
				}),
				api: {
					read: Ext.ux.TYPO3.MvcExtjsSamples.Remote.MovieController.indexAction,
					update: Ext.ux.TYPO3.MvcExtjsSamples.Remote.MovieController.updateAction,
					destroy: Ext.ux.TYPO3.MvcExtjsSamples.Remote.MovieController.destroyAction,
					create: Ext.ux.TYPO3.MvcExtjsSamples.Remote.MovieController.createAction
				},
				paramOrder: {
					read: [],
					update: ['data'],
					create: ['data'],
					destroy: ['data']
				},
				autoLoad: true,
				restful: false,
				batch: false,
				remoteSort: false
			});
		}
	}
	/**
	 * Public API of this singleton.
	 */
	return {
		initialize: initialize
	}
}();