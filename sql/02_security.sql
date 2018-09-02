-- Replace all instances of XXX with the external site db password (same one as in www/.htaccess).
-- Uncomment all entries.

--GRANT SELECT ON         web.cv_category          TO 'webext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         web.cv_entry             TO 'webext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         web.lang                 TO 'webext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         web.license              TO 'webext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         web.text                 TO 'webext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         web.user                 TO 'webext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         web.project              TO 'webext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         web.project_type         TO 'webext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         web.project_tag          TO 'webext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         web.project_url          TO 'webext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         web.project_url_type     TO 'webext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         web.project_image        TO 'webext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         web.project_tag          TO 'webext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         web.project_version      TO 'webext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         web.project_version_type TO 'webext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT, INSERT ON web.project_comment      TO 'webext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         web.settings             TO 'webext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         web.share                TO 'webext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT, INSERT ON web.stat_view            TO 'webext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT, INSERT ON web.stat_visit           TO 'webext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         web.social               TO 'webext'@'localhost' IDENTIFIED BY 'XXX';





-- Replace YYY with the internal site db password (same one as in www-admin/.htaccess).
-- Uncomment entry.

--GRANT SELECT, INSERT, DELETE, UPDATE, SHOW VIEW ON web.* TO 'webint'@'localhost' IDENTIFIED BY 'YYY';
