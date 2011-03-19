Ext.ns('Ext.ux.TYPO3.MvcExtjsSamples');
/**
 * Launches the GUI
 * 
 * @class Ext.ux.TYPO3.MvcExtjsSamples.Module
 * @singleton
 */
Ext.ux.TYPO3.MvcExtjsSamples.Module = function() {
	viewport = null;
	
	var initApplication = function() {
		Ext.ux.TYPO3.MvcExtjs.UriBuilder.initialize('MvcExtjsSamples', 'user_MvcExtjsSamplesModule');
		Ext.ux.TYPO3.MvcExtjs.DirectFlashMessageDispatcher.initialize();
		
		Ext.ux.TYPO3.MvcExtjsSamples.FlashMessageOverlayContainer.initialize({
			minDelay: 3,
			maxDelay: 9,
			logLevel: -2
		});
		
		Ext.ux.TYPO3.MvcExtjsSamples.Movie.Store.initialize();
		Ext.ux.TYPO3.MvcExtjsSamples.Genre.Store.initialize();
		
		viewport = new Ext.Viewport({
	    	layout: 'border',
	    	renderTo: Ext.getBody(),
	    	items: [
	    	new Ext.ux.TYPO3.MvcExtjsSamples.Movie.GridPanel({
	    		store: Ext.StoreMgr.get('Tx_MvcExtjsSamples_Domain_Model_Movie'),
	    		region: 'center'
	    	}), new Ext.ux.TYPO3.MvcExtjsSamples.Genre.GridPanel({
	    		store: Ext.StoreMgr.get('Tx_MvcExtjsSamples_Domain_Model_Genre'),
	    		region: 'south',
	    		height: 300
	    	})]
	    });
	}
	
	return Ext.apply(new Ext.util.Observable, {
        initApplication: initApplication,
        getViewport: function() {
			return viewport;
		}
    })
}();