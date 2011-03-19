Ext.namespace('Ext.ux.TYPO3.MvcExtjsSamples.Genre'); 
/**
 * A GridPanel to display Genre records.
 */
Ext.ux.TYPO3.MvcExtjsSamples.Genre.GridRenderer = function(genre) {
	var returnValue = '';
	if (genre != null) {
		returnValue = genre.name;
	}
    return returnValue;
};