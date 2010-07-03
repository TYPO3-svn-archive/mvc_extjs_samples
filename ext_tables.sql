# TYPO3 SVN ID: $Id$

#
# Table structure for table 'tx_mvcextjssamples_domain_model_movie'
#
CREATE TABLE tx_mvcextjssamples_domain_model_movie (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    hidden tinyint(4) DEFAULT '0' NOT NULL,
    title tinytext,
    director tinytext,
    release_date int(11) DEFAULT '0' NOT NULL,
    tagline tinytext,
    filmed_in int(11) DEFAULT '0' NOT NULL,
    is_bad tinyint(3) DEFAULT '0' NOT NULL,
    genre int(11) DEFAULT '0' NOT NULL,
    
    PRIMARY KEY (uid),
    KEY parent (pid)
);



#
# Table structure for table 'tx_mvcextjssamples_domain_model_genre'
#
CREATE TABLE tx_mvcextjssamples_domain_model_genre (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    name tinytext,
    
    PRIMARY KEY (uid),
    KEY parent (pid)
);

#############################################################
# Tables for the Chat Module.
# Model
##############################################################
CREATE TABLE tx_mvcextjssamples_domain_model_chat (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    backendUser int(11) DEFAULT '0' NOT NULL,
    channels int(11) DEFAULT '0' NOT NULL,
    
    PRIMARY KEY (uid),
    KEY parent (pid)
);

CREATE TABLE tx_mvcextjssamples_domain_model_channel (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    name tinytext,
    messages int(11) DEFAULT '0' NOT NULL,
    
    PRIMARY KEY (uid),
    KEY parent (pid)
);

CREATE TABLE tx_mvcextjssamples_domain_model_message (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    backendUser int(11) DEFAULT '0' NOT NULL,
    text tinytext,
    
    PRIMARY KEY (uid),
    KEY parent (pid)
);
#############################################################
# Tables for the Chat Module.
# Relation
##############################################################
CREATE TABLE tx_mvcextjssamples_chat_channel_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

CREATE TABLE tx_mvcextjssamples_backenduser_message_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

CREATE TABLE tx_mvcextjssamples_channel_message_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

CREATE TABLE tx_mvcextjssamples_backenduser_message_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);