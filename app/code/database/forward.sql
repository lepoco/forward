-- Options table
CREATE TABLE IF NOT EXISTS forward_options (
	option_name VARCHAR (64) NOT NULL PRIMARY KEY,
	option_value LONGTEXT
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Sessions table
CREATE TABLE IF NOT EXISTS forward_sessions (
	session_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_id INT (6),
	session_key INT (20) NOT NULL,
	session_content LONGTEXT
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Records table
CREATE TABLE IF NOT EXISTS forward_records (
	record_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	record_name VARCHAR (256) NOT NULL,
	record_display_name VARCHAR (256) NOT NULL UNIQUE,
	record_description LONGTEXT,
	record_url LONGTEXT,
	record_author INT (6) DEFAULT 1,
	record_clicks INT (20) DEFAULT 0,
	record_active BOOLEAN DEFAULT true,
	record_updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	record_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Statistics visitors origins
CREATE TABLE IF NOT EXISTS forward_statistics_origins (
	origin_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	origin_name VARCHAR (32)
) CHARACTER SET utf8 COLLATE utf8_general_ci;
INSERT IGNORE INTO forward_statistics_origins (origin_name) VALUES ('direct') ON DUPLICATE KEY UPDATE origin_name=origin_name;

-- Statistics visitors languages
CREATE TABLE IF NOT EXISTS forward_statistics_languages (
	language_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	language_name VARCHAR (32)
) CHARACTER SET utf8 COLLATE utf8_general_ci;
INSERT IGNORE INTO forward_statistics_languages (language_name) VALUES ('unknown') ON DUPLICATE KEY UPDATE language_name=language_name;

-- Statistics visitors platforms
CREATE TABLE IF NOT EXISTS forward_statistics_platforms (
	platform_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	platform_name VARCHAR (32)
) CHARACTER SET utf8 COLLATE utf8_general_ci;
INSERT IGNORE INTO forward_statistics_platforms (platform_name) VALUES ('unknown') ON DUPLICATE KEY UPDATE platform_name=platform_name;

-- Statistics visitors agents
CREATE TABLE IF NOT EXISTS forward_statistics_agents (
	agent_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	agent_name VARCHAR (32)
) CHARACTER SET utf8 COLLATE utf8_general_ci;
INSERT IGNORE INTO forward_statistics_agents (agent_name) VALUES ('unknown') ON DUPLICATE KEY UPDATE agent_name=agent_name;

-- Statistics visitors table
CREATE TABLE IF NOT EXISTS forward_statistics_visitors (
	visitor_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	record_id INT (6) UNSIGNED NOT NULL,
	CONSTRAINT fk_record_id FOREIGN KEY (record_id) REFERENCES forward_records (record_id),
	visitor_platform_id INT (6) UNSIGNED NOT NULL,
	CONSTRAINT fk_platform_id FOREIGN KEY (visitor_platform_id) REFERENCES forward_statistics_platforms (platform_id),
	visitor_agent_id INT (6) UNSIGNED NOT NULL,
	CONSTRAINT fk_agent_id FOREIGN KEY (visitor_agent_id) REFERENCES forward_statistics_agents (agent_id),
	visitor_language_id INT (6) UNSIGNED NOT NULL,
	CONSTRAINT fk_language_id FOREIGN KEY (visitor_language_id) REFERENCES forward_statistics_languages (language_id),
	visitor_origin_id INT (6) UNSIGNED NOT NULL,
	CONSTRAINT fk_origin_id FOREIGN KEY (visitor_origin_id) REFERENCES forward_statistics_origins (origin_id),
	visitor_ip VARCHAR (39),
	visitor_visits INT (20) DEFAULT 1,
	visitor_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Users table
CREATE TABLE IF NOT EXISTS forward_users (
	user_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_name VARCHAR (128) NOT NULL,
	user_display_name VARCHAR (128),
	user_email VARCHAR (256),
	user_password VARCHAR (1024) NOT NULL,
	user_token VARCHAR (256),
	user_role VARCHAR (256),
	user_status INT (2) NOT NULL DEFAULT 0,
	user_registered DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	user_last_login DATETIME DEFAULT NULL
) CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Global statistics types
CREATE TABLE IF NOT EXISTS forward_global_statistics_types (
	type_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	type_name VARCHAR (32)
) CHARACTER SET utf8 COLLATE utf8_general_ci;
INSERT IGNORE INTO forward_global_statistics_types (type_name) VALUES ('unknown') ON DUPLICATE KEY UPDATE type_name=type_name;
INSERT IGNORE INTO forward_global_statistics_types (type_name) VALUES ('query') ON DUPLICATE KEY UPDATE type_name=type_name;
INSERT IGNORE INTO forward_global_statistics_types (type_name) VALUES ('page') ON DUPLICATE KEY UPDATE type_name=type_name;
INSERT IGNORE INTO forward_global_statistics_types (type_name) VALUES ('action') ON DUPLICATE KEY UPDATE type_name=type_name;

-- Global statistics types
CREATE TABLE IF NOT EXISTS forward_global_statistics_tags (
	tag_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	tag_name VARCHAR (32)
) CHARACTER SET utf8 COLLATE utf8_general_ci;
INSERT IGNORE INTO forward_global_statistics_tags (tag_name) VALUES ('unknown') ON DUPLICATE KEY UPDATE tag_name=tag_name;

-- Global statistics
CREATE TABLE IF NOT EXISTS forward_global_statistics (
	statistic_id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	statistic_type INT (6) UNSIGNED NOT NULL DEFAULT 1,
	CONSTRAINT fk_statistic_type FOREIGN KEY (statistic_type) REFERENCES forward_global_statistics_types (type_id),
	statistic_tag INT (6) UNSIGNED DEFAULT NULL,
	CONSTRAINT fk_statistic_tag FOREIGN KEY (statistic_tag) REFERENCES forward_global_statistics_tags (tag_id),
	statistic_user_id INT (6) UNSIGNED DEFAULT NULL,
	CONSTRAINT fk_statistic_user_id FOREIGN KEY (statistic_user_id) REFERENCES forward_users (user_id),
	statistic_user_logged_in BOOLEAN DEFAULT false,
	statistic_ip VARCHAR (39),
	statistic_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8 COLLATE utf8_general_ci;