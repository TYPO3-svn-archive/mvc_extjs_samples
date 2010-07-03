Ext.ns('MvcExtjsSamples.ExtDirectModule');
/**
 * Launches the GUI
 * 
 * @class MvcExtjsSamples.ExtDirectModule.ChannelList
 * @singleton
 */
MvcExtjsSamples.ExtDirectModule.ChannelList = function(){
	
	var channelStore = false;
	
	var channelGrid = false;
	
	var initialized = false;
	
	var initialize = function() {
		channelStore =  new Ext.data.DirectStore({
			storeId: 'Tx_MvcExtjsSamples_Domain_Model_Channel',
			reader: new MvcExtjsSamples.ExtDirectModule.ChannelJsonReader,
			writer: new Ext.data.JsonWriter({
				encode: false
			}),
			api: {
				read: MvcExtjsSamples.ExtDirect.Remote.ChatController.receiveChannelsAction
			},
			autoLoad: true,
			restful: false,
			batch: false,
			remoteSort: false
		});
		channelToolbar = new Ext.Toolbar({
			items: [
				createChannelAction,
				receiveChannelsAction,
				joinChannelAction
			]
		})
		channelGrid = new Ext.grid.GridPanel({
			store: channelStore,
			columns: MvcExtjsSamples.ExtDirectModule.ChannelColumns,
			title: 'Channels',
			tbar: channelToolbar,
			id: 'chat',
			loadMask: true
			
		});
		initialized = true;
		return channelGrid;
	}
	
	var createChannelAction = new Ext.Action({
		text: 'create Default Channel',
		handler: function() {
			MvcExtjsSamples.ExtDirect.Remote.ChatController.createChannelAction('Default',chat,function(provider, response) {
				channelPanel = MvcExtjsSamples.ExtDirect.ChannelFactory.create(channel);
				tabPanel.add(channelPanel);
			});

		}
	});
	
	var receiveChannelsAction = new Ext.Action({
		text: 'refresh',
		handler: function() {	
			MvcExtjsSamples.ExtDirectModule.ChannelList.receiveChannels();
		}
	});
	
	var joinChannelAction = new Ext.Action({
		text: 'join',
		handler: function() {	
			if (channelGrid.getSelectionModel().hasSelection()) {
				selectedChannel = channelGrid.getSelectionModel().getSelected();
				Ext.getCmp('chatTabPanel').add(create(selectedChannel.data));
			} else {
				Ext.ux.TYPO3.MvcExtjs.FlashMessagesTabPanel.addMessage({
					message: 'Please select a channel!',
					type: 'error'
				});
			}
			
		}
	});
	
	
	
	var create = function(channel) {
		/*pollingProvider = Ext.Direct.addProvider({
			type:'polling',
			url: MvcExtjsSamples.ExtDirect.Remote.ChatController.queryAction()
		});*/
		out = new Ext.form.DisplayField({
	        cls: 'x-form-text'
	    });
		panel = new Ext.Panel({
			title: 'Channel: ' + channel.name,
			id: channel.name + '_' + channel.uid,
			layout: 'fit',
			border: false,
		});
		panel.add(out);
		return panel;
	};

    return Ext.apply(new Ext.util.Observable, {
    	initialize: initialize,
        create: create,
        getChannel: function(channel) {
        	panel = channels.get(channel.name + '_' + channel.uid);
        	if (panel) {
        		return panel;
        	} else {
        		return create(channel);
        	}
        },
    	receiveChannels: function() {
        	if (initialized) {
        		channelStore.load()
        	}
        }
    })
}();