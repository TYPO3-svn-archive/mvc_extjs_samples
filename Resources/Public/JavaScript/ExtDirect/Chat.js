Ext.ns('MvcExtjsSamples.ExtDirectModule');
/**
 * Launches the GUI
 * 
 * @class MvcExtjsSamples.ExtDirectModule.Chat
 * @singleton
 */
MvcExtjsSamples.ExtDirectModule.Chat = function(){
	
	var chat = false;
	
	var tabPanel = new Ext.TabPanel({
		region: 'center',
		id: 'chatTabPanel',
    	listeners: {
			add: function(tabPanel, addedComponent, index) {
				tabPanel.activate(addedComponent);
			}
		}
	});
	
	var messageInputField = new Ext.form.TextField({
		width: '500'
	});
	
	var sendAction = new Ext.Action({
		text: 'send',
		disabled: true,
		handler: function() {
			MvcExtjsSamples.ExtDirect.Remote.ChatController.sendMessageAction(messageInputField.getValue(),channel,chat,function(provider, response){
				console.log(response);
			});
		}
	});
	
	var connectAction = new Ext.Action({
		text: 'connect',
		handler: function() {
			MvcExtjsSamples.ExtDirect.Remote.ChatController.connectAction(function(provider, response){
				channelGrid = MvcExtjsSamples.ExtDirectModule.ChannelList.initialize();
				tabPanel.add(channelGrid);
				chat = {
					'uid': response.result.uid
				};
				connectAction.disable();
				disconnectAction.enable();
			});
		}
	});
	
	var disconnectAction = new Ext.Action({
		text: 'disconnect',
		disabled: true,
		handler: function() {
			MvcExtjsSamples.ExtDirect.Remote.ChatController.disconnectAction(chat,function(provider, response){
				tabPanel.remove(tabPanel.get('chat'));
				chat = null;
				disconnectAction.disable();
				connectAction.enable();
			});
		}
	});

	
	var messageBar = new Ext.Toolbar({
		items: [messageInputField,sendAction,connectAction,disconnectAction]
	});
	
	messageBarPanel = new Ext.Panel({
		tbar: messageBar,
		region: 'south',
		border: true,
	});
	
    return Ext.apply(new Ext.util.Observable, {
        initApplication: function() {
    		Ext.ux.TYPO3.MvcExtjs.DirectFlashMessageDispatcher.initialize();
    		Ext.ux.TYPO3.MvcExtjs.FlashMessagesTabPanel.initialize();
    		Ext.ux.TYPO3.MvcExtjs.UriBuilder.initialize('MvcExtjsSamples','MvcExtjsSamplesExtdirect');
    		
    		viewport = new Ext.Viewport({
    	    	layout: 'border',
    	    	renderTo: Ext.getBody(),
    	    	items: [
    	    	        Ext.ux.TYPO3.MvcExtjs.FlashMessagesTabPanel.getTabPanel(),
    	    	        messageBarPanel,
    	    	        tabPanel
    	    	]
    	    });
        }
    })
}();