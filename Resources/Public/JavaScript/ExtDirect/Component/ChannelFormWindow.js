Ext.ns('MvcExtjsSamples.ExtDirectModule');
/**
 * ChannelList
 * 
 * @class MvcExtjsSamples.ExtDirectModule.ChannelList
 * @singleton
 */
MvcExtjsSamples.ExtDirectModule.ChannelFormWindow = function(){
	
	var channel;
	
	var showWindow = false;
	
	var getChannelWindow = function(ch) {
		channel = ch;
		form.getForm().loadRecord(channel);
		build();
	}
	
	var build = function() {
		showWindow = new Ext.Window({
			title: 'Enter Channel Name',
			items: [form]
		}).show();
	}
	
	var form = new Ext.form.FormPanel({
		xtype: 'form',
		labelWidth: 75, // label settings here cascade unless overridden
        frame:true,
        width: 350,
        defaults: {width: 230},
        defaultType: 'textfield',
        items: [{
            fieldLabel: 'Name',
            name: 'name',
            allowBlank:false
        }],
        buttons: [{
        	iconCls: 't3-icon-channel-add',
            text: 'Save',
            handler: function() {
        		if (channel.phantom == true) {
        			form.fireEvent('create', this, form.getForm().getFieldValues());
        			showWindow.close();
        			return true;
        		}
        		form.getForm().updateRecord(channel);
        		showWindow.close();
        		return true;
        	}
        }]
	});

    return Ext.apply(new Ext.util.Observable, {
    	get: getChannelWindow,
    	getForm : function() {
    		return form;
    	}
    })
}();