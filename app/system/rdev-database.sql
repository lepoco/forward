
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

-- Statistics visitors origins
CREATE TABLE IF NOT EXISTS forward_statistics_origins (
	origin_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	origin_name VARCHAR(32)
) CHARACTER SET utf8 COLLATE utf8_general_ci;
INSERT IGNORE INTO forward_statistics_origins (origin_name) VALUES
('direct'),
('www.google.com'),
('www.youtube.com'),
('m.youtube.com'),
('www.facebook.com'),
('m.facebook.com'),
('lm.facebook.com'),
('l.facebook.com');

-- Statistics visitors languages
CREATE TABLE IF NOT EXISTS forward_statistics_languages (
	language_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	language_name VARCHAR(32)
) CHARACTER SET utf8 COLLATE utf8_general_ci;
INSERT IGNORE INTO forward_statistics_languages (language_name) VALUES
('unknown'),
('en'),
('en-us'),
('en-gb');

-- Statistics visitors platforms
CREATE TABLE IF NOT EXISTS forward_statistics_platforms (
	platform_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	platform_name VARCHAR(32)
) CHARACTER SET utf8 COLLATE utf8_general_ci;
INSERT IGNORE INTO forward_statistics_platforms (platform_name) VALUES
('Unknown'),
('Windows 10'),
('Windows 8.1'),
('Windows 8'),
('Windows 7'),
('Windows Vista'),
('Windows Server 2003/XP x64'),
('Windows XP'),
('Windows XP'),
('Windows 2000'),
('Windows ME'),
('Windows 98'),
('Windows 95'),
('Windows 3.11'),
('Mac OS X'),
('Mac OS 9'),
('Linux'),
('Ubuntu'),
('iPhone'),
('iPod'),
('iPad'),
('Android'),
('BlackBerry'),
('Mobile');

-- Statistics visitors agents
CREATE TABLE IF NOT EXISTS forward_statistics_agents (
	agent_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	agent_name VARCHAR(32)
) CHARACTER SET utf8 COLLATE utf8_general_ci;
INSERT IGNORE INTO forward_statistics_agents (agent_name) VALUES
('Unknown'),
('Lynx'),
('Edge'),
('Chrome'),
('Safari'),
('IE'),
('Gecko'),
('Opera'),
('NS4'),
('iPhone');

-- Statistics visitors table
CREATE TABLE IF NOT EXISTS forward_statistics_visitors (
	visitor_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	record_id INT(6) UNSIGNED NOT NULL,
	CONSTRAINT fk_record_id FOREIGN KEY (record_id) REFERENCES forward_records(record_id),
	visitor_platform_id INT(6) UNSIGNED NOT NULL,
	CONSTRAINT fk_platform_id FOREIGN KEY (visitor_platform_id) REFERENCES forward_statistics_platforms(platform_id),
	visitor_agent_id INT(6) UNSIGNED NOT NULL,
	CONSTRAINT fk_agent_id FOREIGN KEY (visitor_agent_id) REFERENCES forward_statistics_agents(agent_id),
	visitor_language_id INT(6) UNSIGNED NOT NULL,
	CONSTRAINT fk_language_id FOREIGN KEY (visitor_language_id) REFERENCES forward_statistics_languages(language_id),
	visitor_origin_id INT(6) UNSIGNED NOT NULL,
	CONSTRAINT fk_origin_id FOREIGN KEY (visitor_origin_id) REFERENCES forward_statistics_origins(origin_id),
	visitor_ip VARCHAR(128),
	visitor_visits INT(20) DEFAULT 1,
	visitor_date DATETIME DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8 COLLATE utf8_general_ci;

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