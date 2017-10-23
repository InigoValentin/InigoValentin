-- Replace all instances of XXX with the external site db password (same one as in www/.htaccess).
-- Uncomment all entries.

--GRANT SELECT ON         iv.cv_category          TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         iv.cv_entry             TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         iv.lang                 TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         iv.license              TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         iv.text                 TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         iv.user                 TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         iv.post                 TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         iv.post_tag             TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         iv.post_image           TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT, INSERT ON iv.post_comment         TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         iv.project              TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         iv.project_type         TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         iv.project_tag          TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         iv.project_url          TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         iv.project_url_type     TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         iv.project_image        TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         iv.project_tag          TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         iv.project_version      TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         iv.project_version_type TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT, INSERT ON iv.project_comment      TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         iv.settings             TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT, INSERT ON iv.stat_view            TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT, INSERT ON iv.stat_visit           TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
--GRANT SELECT ON         iv.social               TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';





-- Replace YYY with the internal site db password (same one as in www-admin/.htaccess).
-- Uncomment entry.

--GRANT SELECT, INSERT, DELETE, UPDATE, SHOW VIEW ON iv.* TO 'ivint'@'localhost' IDENTIFIED BY 'YYY';
