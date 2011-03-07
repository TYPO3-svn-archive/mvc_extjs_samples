Ext.namespace('Ext.ux.TYPO3.MvcExtjsSamples.Genre'); 
/**
 * A Store for the genre model using ExtDirect to communicate with the
 * server side extbase framework.
 */
Ext.ux.TYPO3.MvcExtjsSamples.Genre.Store = function() {
	
	genreStore = null;
	
	var initialize = function() {
		if (genreStore == null) {
			genreStore = new Ext.data.DirectStore({
				storeId: 'Tx_MvcExtjsSamples_Domain_Model_Genre',
				reader: new Ext.data.JsonReader({
					totalProperty:'total',
					successProperty:'success',
					idProperty:'__identity',
					root:'data',
					fields:[
					    {name: '__identity', type: 'int'},
					    {name: 'name', type: 'string'}
					]
				}),
				writer: new Ext.data.JsonWriter({
					encode:false,
					writeAllFields:false
				}),
				api: {
					read: Ext.ux.TYPO3.MvcExtjsSamples.Remote.GenreController.indexAction,
					update: Ext.ux.TYPO3.MvcExtjsSamples.Remote.GenreController.updateAction,
					destroy: Ext.ux.TYPO3.MvcExtjsSamples.Remote.GenreController.destroyAction,
					create: Ext.ux.TYPO3.MvcExtjsSamples.Remote.GenreController.createAction
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