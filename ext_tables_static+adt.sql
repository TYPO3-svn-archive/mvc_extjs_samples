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

INSERT INTO tx_mvcextjssamples_domain_model_movie VALUES (1, 0, 1248190708, 1248023516, 1, 0, 'Good Will Hunting', 'Gus Van Sant', 884300400, 0, 0, 2, 'Some people can never believe in themselves, until someone believes in them.');
INSERT INTO tx_mvcextjssamples_domain_model_movie VALUES (2, 0, 1248190623, 1248023581, 1, 0, 'Empire of the Sun', 'Steven Spielberg', 567385200, 0, 0, 2, 'To survive in a world at war, he must find a strength greater than all the events that surround him.');
INSERT INTO tx_mvcextjssamples_domain_model_movie VALUES (3, 0, 1248190601, 1248023696, 1, 0, 'The Omega Code', 'Robert Marcarelli', 935704800, 0, 1, 4, 'Revelation foretold it, Nostradamus predicted it...');
INSERT INTO tx_mvcextjssamples_domain_model_movie VALUES (4, 0, 1248157249, 1248157075, 1, 0, 'Office Space', 'Mike Judge', 919378800, 0, 0, 1, 'Work Sucks');
INSERT INTO tx_mvcextjssamples_domain_model_movie VALUES (5, 0, 1248157305, 1248157305, 1, 0, 'Super Troopers', 'Jay Chandrasekhar', 1013727600, 0, 0, 1, 'Altered State Police');
INSERT INTO tx_mvcextjssamples_domain_model_movie VALUES (6, 0, 1248157376, 1248157376, 1, 0, 'The Big Lebowski', 'Joel Coen', 896824800, 0, 0, 1, 'The "Dude"');
INSERT INTO tx_mvcextjssamples_domain_model_movie VALUES (7, 0, 1248157420, 1248157420, 1, 0, 'Fight Club', 'David Fincher', 939938400, 0, 0, 3, 'How much can you know about yourself...');
INSERT INTO tx_mvcextjssamples_domain_model_movie VALUES (8, 0, 1248190903, 1248190903, 1, 0, 'American Beauty', 'Sam Mendes', 938728800, 0, 0, 2, '... Look Closer');



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

INSERT INTO tx_mvcextjssamples_domain_model_genre VALUES (1, 0, 1248110701, 1248110701, 1, 'Comedy');
INSERT INTO tx_mvcextjssamples_domain_model_genre VALUES (2, 0, 1248110711, 1248110711, 1, 'Drama');
INSERT INTO tx_mvcextjssamples_domain_model_genre VALUES (3, 0, 1248110717, 1248110717, 1, 'Action');
INSERT INTO tx_mvcextjssamples_domain_model_genre VALUES (4, 0, 1248110722, 1248110722, 1, 'Mystery');
