#
# Table structure for table 'tx_rkwwepstra_domain_model_wepstra'
#
CREATE TABLE tx_rkwwepstra_domain_model_wepstra (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	guided_mode int(11) DEFAULT '0' NOT NULL,
	guided_asked int(11) DEFAULT '0' NOT NULL,
	knowledge int(11) DEFAULT '0' NOT NULL,
	technical_development_percentage int(11) DEFAULT '0' NOT NULL,
	reason_why int(11) unsigned DEFAULT '0' NOT NULL,
	sales_trend int(11) unsigned DEFAULT '0' NOT NULL,
	geographical_sector int(11) unsigned DEFAULT '0' NOT NULL,
	product_sector int(11) unsigned DEFAULT '0' NOT NULL,
	performance int(11) unsigned DEFAULT '0' NOT NULL,
	technical_development int(11) unsigned DEFAULT '0' NOT NULL,
	productivity int(11) unsigned DEFAULT '0' NOT NULL,
	cost_saving int(11) unsigned DEFAULT '0' NOT NULL,
	participants int(11) unsigned DEFAULT '0' NOT NULL,
	job_family int(11) unsigned DEFAULT '0' NOT NULL,
	step_control int(11) unsigned DEFAULT '0' NOT NULL,
	frontend_user int(11) unsigned DEFAULT '0',
	anonymous_user int(11) unsigned DEFAULT '0',
	last_update int(11) unsigned DEFAULT '0' NOT NULL,
	disabled tinyint(4) unsigned DEFAULT '0' NOT NULL,
	target_date int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
    KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_reasonwhy'
#
CREATE TABLE tx_rkwwepstra_domain_model_reasonwhy (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	wepstra int(11) unsigned DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	value int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_salestrend'
#
CREATE TABLE tx_rkwwepstra_domain_model_salestrend (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	wepstra int(11) unsigned DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	value int(11) unsigned DEFAULT '0' NOT NULL,
	percentage varchar(255) DEFAULT '' NOT NULL,
	current_sales varchar(255) DEFAULT '' NOT NULL,
	future_sales varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_geographicalsector'
#
CREATE TABLE tx_rkwwepstra_domain_model_geographicalsector (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	wepstra int(11) unsigned DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	value int(11) unsigned DEFAULT '0' NOT NULL,
	percentage varchar(255) DEFAULT '' NOT NULL,
	current_sales varchar(255) DEFAULT '' NOT NULL,
	future_sales varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_productsector'
#
CREATE TABLE tx_rkwwepstra_domain_model_productsector (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	wepstra int(11) unsigned DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	value int(11) unsigned DEFAULT '0' NOT NULL,
	percentage varchar(255) DEFAULT '' NOT NULL,
	current_sales varchar(255) DEFAULT '' NOT NULL,
	future_sales varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_performance'
#
CREATE TABLE tx_rkwwepstra_domain_model_performance (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	wepstra int(11) unsigned DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	value int(11) unsigned DEFAULT '0' NOT NULL,
	influence varchar(255) DEFAULT '' NOT NULL,
	knowledge varchar(255) DEFAULT '' NOT NULL,
	type int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_technicaldevelopment'
#
CREATE TABLE tx_rkwwepstra_domain_model_technicaldevelopment (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	wepstra int(11) unsigned DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	value int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_productivity'
#
CREATE TABLE tx_rkwwepstra_domain_model_productivity (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	wepstra int(11) unsigned DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	value int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_costsaving'
#
CREATE TABLE tx_rkwwepstra_domain_model_costsaving (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	wepstra int(11) unsigned DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	value int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_jobfamily'
#
CREATE TABLE tx_rkwwepstra_domain_model_jobfamily (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	wepstra int(11) unsigned DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	strategic_relevance_market int(11) DEFAULT '0' NOT NULL,
	strategic_relevance_innovation int(11) DEFAULT '0' NOT NULL,
	strategic_relevance_productivity int(11) DEFAULT '0' NOT NULL,
	age_risk varchar(255) DEFAULT '' NOT NULL,
	capacity_risk varchar(255) DEFAULT '' NOT NULL,
	competence_risk varchar(255) DEFAULT '' NOT NULL,
	provision_risk varchar(255) DEFAULT '' NOT NULL,
	task_marketing text NOT NULL,
	task_sourcing text NOT NULL,
	task_integration text NOT NULL,
	task_loyalty text NOT NULL,
	task_trend text NOT NULL,
	task_ending_employment text NOT NULL,
	priority_average varchar(255) DEFAULT '' NOT NULL,
	selected tinyint(4) unsigned DEFAULT '0' NOT NULL,
	update_task int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_priority'
#
CREATE TABLE tx_rkwwepstra_domain_model_priority (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	value int(11) unsigned DEFAULT '0' NOT NULL,
	job_family int(11) unsigned DEFAULT '0',
	participant int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_participant'
#
CREATE TABLE tx_rkwwepstra_domain_model_participant (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	wepstra int(11) unsigned DEFAULT '0' NOT NULL,

	first_name varchar(255) DEFAULT '' NOT NULL,
	last_name varchar(255) DEFAULT '' NOT NULL,
	username varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_stepcontrol'
#
CREATE TABLE tx_rkwwepstra_domain_model_stepcontrol (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	wepstra int(11) unsigned DEFAULT '0' NOT NULL,

	step0 tinyint(4) unsigned DEFAULT '0' NOT NULL,
	step1 tinyint(4) unsigned DEFAULT '0' NOT NULL,
	step2 tinyint(4) unsigned DEFAULT '0' NOT NULL,
	step2sub2 tinyint(4) unsigned DEFAULT '0' NOT NULL,
	step3 tinyint(4) unsigned DEFAULT '0' NOT NULL,
	step3sub2 tinyint(4) unsigned DEFAULT '0' NOT NULL,
	step3sub3 tinyint(4) unsigned DEFAULT '0' NOT NULL,
	step3sub4 tinyint(4) unsigned DEFAULT '0' NOT NULL,
	step4 tinyint(4) unsigned DEFAULT '0' NOT NULL,
	step5 tinyint(4) unsigned DEFAULT '0' NOT NULL,
	step5sub2 tinyint(4) unsigned DEFAULT '0' NOT NULL,
	step5sub3 tinyint(4) unsigned DEFAULT '0' NOT NULL,
	step5sub4 tinyint(4) unsigned DEFAULT '0' NOT NULL,
	step5sub5 tinyint(4) unsigned DEFAULT '0' NOT NULL,
	step6 tinyint(4) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_participant'
#
CREATE TABLE tx_rkwwepstra_domain_model_participant (

	wepstra  int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_jobfamily'
#
CREATE TABLE tx_rkwwepstra_domain_model_jobfamily (

	wepstra  int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_reasonwhy'
#
CREATE TABLE tx_rkwwepstra_domain_model_reasonwhy (

	wepstra  int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_salestrend'
#
CREATE TABLE tx_rkwwepstra_domain_model_salestrend (

	wepstra  int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_geographicalsector'
#
CREATE TABLE tx_rkwwepstra_domain_model_geographicalsector (

	wepstra  int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_productsector'
#
CREATE TABLE tx_rkwwepstra_domain_model_productsector (

	wepstra  int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_performance'
#
CREATE TABLE tx_rkwwepstra_domain_model_performance (

	wepstra  int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_technicaldevelopment'
#
CREATE TABLE tx_rkwwepstra_domain_model_technicaldevelopment (

	wepstra  int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_productivity'
#
CREATE TABLE tx_rkwwepstra_domain_model_productivity (

	wepstra  int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_rkwwepstra_domain_model_costsaving'
#
CREATE TABLE tx_rkwwepstra_domain_model_productivity (

	wepstra  int(11) unsigned DEFAULT '0' NOT NULL,

);
