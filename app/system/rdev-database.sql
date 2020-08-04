
-- Options table
CREATE TABLE IF NOT EXISTS forward_options (
	option_name VARCHAR(64) NOT NULL PRIMARY KEY,
	option_value LONGTEXT
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Sessions table
CREATE TABLE IF NOT EXISTS forward_sessions (
	session_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_id INT(6),
	session_key INT(20) NOT NULL,
	session_content LONGTEXT
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Records table
CREATE TABLE IF NOT EXISTS forward_records (
	record_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	record_name VARCHAR(256) NOT NULL,
	record_display_name VARCHAR(256) NOT NULL UNIQUE,
	record_description LONGTEXT,
	record_url LONGTEXT,
	record_author INT(6) DEFAULT 1,
	record_clicks INT(20) DEFAULT 0,
	record_active BOOLEAN DEFAULT true,
	record_updated DATETIME DEFAULT CURRENT_TIMESTAMP,
	record_created DATETIME DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Statistics visitors table
CREATE TABLE IF NOT EXISTS forward_statistics_visitors (
	visitor_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	record_id INT(6) UNSIGNED NOT NULL,
	CONSTRAINT fk_record_id FOREIGN KEY (record_id) REFERENCES forward_records(record_id),
	visitor_ip VARCHAR(128),
	visitor_origin LONGTEXT,
	visitor_language VARCHAR(128),
	visitor_agent VARCHAR(128),
	visitor_platform VARCHAR(128),
	visitor_visits INT(20) DEFAULT 1,
	visitor_date DATETIME DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Statistics master table
--

-- Users table
CREATE TABLE IF NOT EXISTS forward_users (
	user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_name VARCHAR(128) NOT NULL,
	user_display_name VARCHAR(128),
	user_email VARCHAR(256),
	user_password VARCHAR(1024) NOT NULL,
	user_token VARCHAR(256),
	user_role VARCHAR(256),
	user_status INT(2) NOT NULL DEFAULT 0,
	user_registered DATETIME DEFAULT CURRENT_TIMESTAMP,
	user_last_login DATETIME
) CHARACTER SET utf8 COLLATE utf8_general_ci;