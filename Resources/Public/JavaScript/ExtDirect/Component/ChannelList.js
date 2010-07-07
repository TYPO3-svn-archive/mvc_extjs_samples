Ext.ns('MvcExtjsSamples.ExtDirectModule');
/**
 * ChannelList
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
			reader: new MvcExtjsSamples.Chat.ChannelJsonReader,
			writer: new Ext.data.JsonWriter({
				encode: false,
				writeAllFields: false
			}),
			api: {
				read: MvcExtjsSamples.ExtDirect.Remote.ChannelController.indexAction,
				create: MvcExtjsSamples.ExtDirect.Remote.ChannelController.createAction
			},
			autoLoad: true,
			autoSave: true,
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
			columns: MvcExtjsSamples.Chat.ChannelColumns,
			title: 'Channels',
			tbar: channelToolbar,
			id: 'chat',
			loadMask: true,
			listeners: {
				dblclick: function(event) {
					joinChannelAction.execute();
				}
			}
		});	
		channelGrid.relayEvents(channelStore, ['update','create','destroy']);
		initialized = true;
		return channelGrid;
	}
	
	var createChannelAction = new Ext.Action({
		text: 'Create',
		iconCls: 't3-icon-channel-add',
		handler: function() {
			defaultChannel = {messages:[], name:"Default Channel"};
			channel = new channelStore.recordType(defaultChannel);
			win = MvcExtjsSamples.ExtDirectModule.ChannelFormWindow.get(channel);
			MvcExtjsSamples.ExtDirectModule.ChannelFormWindow.getForm().on('create', function(panel, data) {
				rec = new channelStore.recordType(data);
				channelStore.add([rec]);
			});
		}
	});
	
	var receiveChannelsAction = new Ext.Action({
		text: 'Refresh',
		iconCls: 't3-icon-refresh',
		handler: function() {	
			if (initialized) {
	    		channelStore.load()
	    	}
		}
	});
	
	var joinChannelAction = new Ext.Action({
		text: 'Join',
		iconCls: 't3-icon-join',
		handler: function() {	
			if (channelGrid.getSelectionModel().hasSelection()) {
				selectedChannel = channelGrid.getSelectionModel().getSelected();
				MvcExtjsSamples.ExtDirect.Remote.ChatController.joinChannelAction({uid: selectedChannel.get('uid')},MvcExtjsSamples.ExtDirectModule.Chat.get(), function() {
					channelPanel = MvcExtjsSamples.ExtDirectModule.ChannelPanelRepository.find(selectedChannel);
					tabPanel = Ext.getCmp('chatTabPanel'); 
					tabPanel.add(channelPanel);
				});
			} else {
				Ext.ux.TYPO3.MvcExtjs.FlashMessagesTabPanel.addMessage({
					message: 'Please select a channel!',
					type: 'error'
				});
			}
			
		}
	});

    return Ext.apply(new Ext.util.Observable, {
    	initialize: initialize
    })
}();