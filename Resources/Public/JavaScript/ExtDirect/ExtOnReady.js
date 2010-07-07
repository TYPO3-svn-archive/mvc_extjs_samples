MvcExtjsSamples.ExtDirectModule.Chat.initApplication();
/**
 * This override patches extjs DirectProxy class.
 * The code is taken from extjs 3.2.1.
 * DirectStore writes are not successful without this patch.
 * It took hours to figure this out...
 */
Ext.override(Ext.data.DirectProxy,{
	/**
     * Callback for write actions
     * @param {String} action [{@link Ext.data.Api#actions create|read|update|destroy}]
     * @param {Object} trans The request transaction object
     * @param {Object} result Data object picked out of the server-response.
     * @param {Object} res The server response
     * @param {Ext.data.Record/[Ext.data.Record]} rs The Store resultset associated with the action.
     * @protected
     */
    onWrite : function(action, trans, result, res, rs) {
        var data = trans.reader.extractData(trans.reader.getRoot(result), false);
        var success = trans.reader.getSuccess(result);
        success = (success !== false);
        if (success){
            this.fireEvent("write", this, action, data, res, rs, trans.request.arg);
        }else{
            this.fireEvent('exception', this, 'remote', action, trans, result, rs);
        }
        trans.request.callback.call(trans.request.scope, data, res, success);
    }
	
})