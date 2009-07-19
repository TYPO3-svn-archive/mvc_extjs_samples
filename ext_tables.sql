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
    filmed_in int(11) DEFAULT '0' NOT NULL,
    is_bad tinyint(3) DEFAULT '0' NOT NULL,
    
    PRIMARY KEY (uid),
    KEY parent (pid)
);