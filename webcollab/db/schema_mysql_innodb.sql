
CREATE TABLE tasks (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	parent INT UNSIGNED NOT NULL,
	name VARCHAR(255) NOT NULL,
	text TEXT,
	created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	edited TIMESTAMP NOT NULL DEFAULT 0,
	owner INT UNSIGNED NOT NULL DEFAULT 0,
	creator INT UNSIGNED NOT NULL,
	finished_time TIMESTAMP NOT NULL DEFAULT 0,
	projectid INT UNSIGNED NOT NULL DEFAULT 0,
	deadline TIMESTAMP NOT NULL DEFAULT 0,
	priority TINYINT NOT NULL DEFAULT 2,
	status VARCHAR(20) NOT NULL DEFAULT 'created',
	taskgroupid INT UNSIGNED NOT NULL,
	lastforumpost TIMESTAMP NOT NULL DEFAULT 0,
	usergroupid INT UNSIGNED NOT NULL,
	globalaccess VARCHAR(5) NOT NULL DEFAULT 't',
	groupaccess VARCHAR(5) NOT NULL DEFAULT 'f',
	lastfileupload TIMESTAMP NOT NULL DEFAULT 0,
	completed TINYINT NOT NULL DEFAULT 0,
	completion_time TIMESTAMP NOT NULL DEFAULT 0,
	archive TINYINT NOT NULL DEFAULT 0,
	sequence INT UNSIGNED NOT NULL DEFAULT 0,
	INDEX (owner),
	INDEX (parent),
	INDEX (name(10)),
	INDEX (projectid),
	INDEX (taskgroupid),
	INDEX (deadline),
	INDEX (status, parent)
)
TYPE = InnoDB
CHARACTER SET = utf8;

CREATE TABLE users (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(200) NOT NULL,
	fullname VARCHAR(200) NOT NULL,
	password VARCHAR(200) NOT NULL,
	email VARCHAR(200) NOT NULL,
	admin VARCHAR(5) NOT NULL DEFAULT 'f',
	private TINYINT NOT NULL DEFAULT 0,
	guest TINYINT NOT NULL DEFAULT 0,
	deleted VARCHAR(5) NOT NULL DEFAULT 'f',
	locale VARCHAR(10) NOT NULL DEFAULT 'en',
  INDEX (fullname(10))
)
TYPE = InnoDB
CHARACTER SET = utf8;

CREATE TABLE usergroups (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100) NOT NULL,
	description VARCHAR(255),
	private TINYINT NOT NULL DEFAULT 0,
	INDEX (name(10))
)
TYPE = InnoDB
CHARACTER SET = utf8;

CREATE TABLE forum (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	parent INT UNSIGNED NOT NULL,
	taskid INT UNSIGNED NOT NULL,
	posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	edited TIMESTAMP NOT NULL DEFAULT 0,
	text TEXT,
	userid INT UNSIGNED NOT NULL,
	usergroupid INT UNSIGNED NOT NULL,
	sequence INT UNSIGNED NOT NULL DEFAULT 0,
	INDEX (taskid),
	INDEX (edited)
)
TYPE = InnoDB
CHARACTER SET = utf8;

CREATE TABLE logins (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user_id INT UNSIGNED NOT NULL,
	session_key VARCHAR(100) NOT NULL,
	ip VARCHAR(100) NOT NULL,
	lastaccess TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  token VARCHAR(100),
	INDEX (session_key(10), user_id ),
  INDEX (lastaccess)
)
TYPE = InnoDB
CHARACTER SET = utf8;

CREATE TABLE seen (
	taskid INT UNSIGNED NOT NULL,
	userid INT UNSIGNED NOT NULL,
	time TIMESTAMP NOT NULL DEFAULT 0,
	INDEX (taskid, userid)
)
TYPE = InnoDB
CHARACTER SET = utf8;

CREATE TABLE taskgroups (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100) NOT NULL,
	description VARCHAR(255),
	INDEX (name(10))
)
TYPE = InnoDB
CHARACTER SET = utf8;

CREATE TABLE contacts (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	firstname VARCHAR(100) NOT NULL,
	lastname VARCHAR(100) NOT NULL,
	company VARCHAR(100),
	tel_home VARCHAR(100),
	gsm VARCHAR(100),
	fax VARCHAR(100),
	tel_business VARCHAR(100),
	address VARCHAR(100),
	postal VARCHAR(100),
	city VARCHAR(100),
	notes TEXT,
	email VARCHAR(100),
	added_by INT UNSIGNED NOT NULL,
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	user_id INT UNSIGNED NOT NULL,
        taskid INT UNSIGNED NOT NULL DEFAULT 0
)
TYPE = InnoDB
CHARACTER SET = utf8;

CREATE TABLE contacts_tasks (
	contact_id INT,
	task_id INT
)
TYPE = InnoDB
CHARACTER SET = utf8;

CREATE TABLE files (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	fileid INT UNSIGNED NOT NULL DEFAULT 0,
	filename VARCHAR(255),
	size BIGINT NOT NULL DEFAULT 0,
	description TEXT,
	uploaded TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	uploader INT UNSIGNED NOT NULL,
	mime VARCHAR(200),
	taskid INT UNSIGNED NOT NULL,
	INDEX (taskid)
)
TYPE = InnoDB
CHARACTER SET = utf8;

CREATE TABLE usergroups_users (
	usergroupid INT UNSIGNED NOT NULL,
	userid INT UNSIGNED NOT NULL,
	INDEX (userid, usergroupid)
)
TYPE = InnoDB
CHARACTER SET = utf8;

CREATE TABLE maillist (
	email VARCHAR(200)
)
TYPE = InnoDB
CHARACTER SET = utf8;

CREATE TABLE config (
	email_admin VARCHAR(200),
	reply_to VARCHAR(200),
	email_from VARCHAR(200),
	globalaccess VARCHAR(50),
	groupaccess VARCHAR(50),
	owner VARCHAR(50),
	usergroup VARCHAR(50),
	project_order VARCHAR(200),
	task_order VARCHAR(200)
)
TYPE = InnoDB
CHARACTER SET = utf8;

CREATE TABLE login_attempt ( 
	name VARCHAR(100) NOT NULL,
	ip VARCHAR(100) NOT NULL,
	last_attempt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
TYPE = InnoDB
CHARACTER SET = utf8;

CREATE TABLE site_name (
	manager_name VARCHAR(100),
	abbr_manager_name VARCHAR(100)
)
TYPE = InnoDB
CHARACTER SET = utf8;

INSERT INTO users ( id, name, fullname, password, email, admin, deleted )
VALUES( 1, 'admin', 'Administrator', '0192023a7bbd73250516f069df18b500', 'please_edit@my_domain.com', 't', 'f' );

INSERT INTO config ( globalaccess, groupaccess, project_order, task_order )
VALUES( 'checked=\"checked\"', '', 'ORDER BY name', 'ORDER BY name' );

INSERT INTO site_name ( manager_name, abbr_manager_name )
VALUES( 'WebCollab Project Management', 'WebCollab' );
