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
		width: '500',
		id: 'messageInputField'
	});
	
	messageInputField.on('specialkey', function(t, e){
        if(e.getKey() == e.ENTER){
        	sendAction.execute();
        }
    });

	
	var sendAction = new Ext.Action({
		text: 'send',
		iconCls: 't3-icon-tick',
		handler: function() {
			var message = messageInputField.getValue();
			if (message === '') {
				return;
			}
			var activeTab = tabPanel.getActiveTab();
			if (activeTab === null) {
				Ext.ux.TYPO3.MvcExtjs.FlashMessagesTabPanel.addMessage({
					message: 'You have to connect to the server first!',
					type: 'error'
				});
				return
			}
			if (activeTab.channel) {
				MvcExtjsSamples.ExtDirect.Remote.ChannelController.sendMessageAction(message,activeTab.channel.data,chat,function(provider, response){
					messageInputField.setValue('');
					message = response.result;
					activeTab.addMessage(message);
				});
			} else {
				Ext.ux.TYPO3.MvcExtjs.FlashMessagesTabPanel.addMessage({
					message: 'You have to be in a channel tab to send a message!',
					type: 'error'
				});
			}
		}
	});
	
	var connectAction = new Ext.Action({
		text: 'connect',
		iconCls: 't3-icon-connect',
		handler: function() {
			MvcExtjsSamples.ExtDirect.Remote.ChatController.connectAction(function(provider, response){
				chat = {
					'uid': response.result.uid
				};
				channelGrid = MvcExtjsSamples.ExtDirectModule.ChannelList.initialize();
				tabPanel.add(channelGrid);
				connectAction.disable();
				disconnectAction.enable();
				var pollprovider = new Ext.direct.PollingProvider({
		            url: dispatchUpdate,
		            baseParams: chat
		        });
				Ext.Direct.addProvider(pollprovider);
			});
		}
	});
	
	
	var dispatchUpdate = function(chat) {
		MvcExtjsSamples.ExtDirect.Remote.ChatController.queryAction(chat, function(response, provider) {
			if (Ext.isArray(response)) {
				Ext.each(response, function(message,index,length){
					channel = message.channel;
					channelPanel = MvcExtjsSamples.ExtDirectModule.ChannelPanelRepository.find(channel);
					channelPanel.addMessage(message);
				});
			}
		});
	}
	
	var disconnectAction = new Ext.Action({
		text: 'disconnect',
		iconCls: 't3-icon-disconnect',
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
        },
        get: function() {
        	return chat;
        }
    })
}();