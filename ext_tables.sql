#
# Table structure for table 'tx_batchmailer_domain_model_mail'
#
CREATE TABLE tx_batchmailer_domain_model_mail (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	recipients varchar(255) DEFAULT '' NOT NULL,
	copies varchar(255) DEFAULT '' NOT NULL,
	blind_copies varchar(255) DEFAULT '' NOT NULL,
	sender varchar(255) DEFAULT '' NOT NULL,
	subject varchar(255) DEFAULT '' NOT NULL,
	body text NOT NULL,
	attachments text NOT NULL,
	mail mediumblob,

	sent tinyint(4) unsigned DEFAULT '0' NOT NULL,
	sent_status tinyint(4) unsigned DEFAULT '0' NOT NULL,
	sent_error_message text,
	sent_date int(11) unsigned DEFAULT '0' NOT NULL,
	sent_tries int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)

);