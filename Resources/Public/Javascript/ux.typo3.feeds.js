/***************************************************************
 * 
 * Copyright notice
 *
 * (c) 2009 Steffen Kamper <info@sk-typo3.de>
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
Ext.namespace('Ext.ux.TYPO3');  

Ext.ux.TYPO3.Feeds = Ext.extend(Ext.util.Observable, {
	width: 400,
	height: 300,
	interval: 0,
	resultsPerPage: 15,
	url: '',
	title: 'RSS Feed',
	cropMsg: 50,
	
	constructor: function(elId, config) {
		config = config || {};
		Ext.apply(this, config);

		Ext.ux.TYPO3.Feeds.superclass.constructor.call(this, config);

		this.addEvents(
			'afterLoad'
		);

		this.el = Ext.get(elId);

		if (this.width < 250) {
			this.width = 250;
		}
		if (this.height < 250) {
			this.height = 250;
		}
		this.msgWidth = this.width - 8; 
		
		if (!this.url) {
		    alert('You must specify an url!');
		} else {
			this.initComponents();
			this.loadComponents();
		}
	},
	
	initComponents: function() {
		// create the Data Store
		this.store = new Ext.data.Store({

			proxy: new Ext.data.HttpProxy({
				url: this.url
			}),
			reader: new Ext.data.XmlReader(
				{record: 'item'},
				['title', 'author', {name:'pubDate', type:'date'}, 'link', 'description']
			)
		});
		if (this.mode === 1) {
			this.store.root = 'results';
		}
		// create the grid
		this.grid = new Ext.grid.GridPanel({
			store: this.store,
			columns: [
				{ header: this.title, width: this.msgWidth, dataIndex: 'description', sortable: false, renderer: this.theMessage, scope: this }
			],
			viewConfig: {
				forceFit: true,
				getRowClass: function(record, index) {
				    return (index % 2 == 0 ? 'odd' : 'even');
				}
			},
			enableColumnHide: false,
			enableColumnMove: false,
			enableColumnResize: false,
			enableHdMenu : false,

			renderTo: this.el,
			width: this.width,
			height: this.height,
			loadMask: true
		});
	},
	
	loadComponents: function() {
		this.loadingTask = {
			run: function(){
				this.store.reload();
			},
			interval: this.interval * 1000,
			scope: this
		};
		// start the Data store load
		
		if (this.interval > 0) {
			Ext.TaskMgr.start(this.loadingTask);
		} else {
			this.store.load();
		}
	
	},
	
	theMessage: function(val, p, record) {
		var txt = String.format('<h2>{0}</h2>', record.data.title);
		var msg = this.cropMsg ? Ext.util.Format.ellipsis(val, this.cropMsg) : val;
		txt += String.format('<p class="author">{0} ({1})</p>', record.data.author, Ext.util.Format.date(record.data.pubDate, 'd.m.y H:i'));	
		txt += String.format('<p class="message">{0}</p>', msg);	
		txt += String.format('<p class="link"><a href="{0}" target="_blank">link</a></p>', record.data.link);	
		return txt;
	}
	

});

