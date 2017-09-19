-- Replace all instances of  XXX with the external site db password
GRANT SELECT ON iv.lang TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
GRANT SELECT ON iv.text TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
GRANT SELECT ON iv.user TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
GRANT SELECT ON iv.post TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
GRANT SELECT ON iv.post_tag TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
GRANT SELECT ON iv.post_image TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
GRANT SELECT, INSERT ON iv.post_comment TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
GRANT SELECT ON iv.project TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
GRANT SELECT ON iv.project_url TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
GRANT SELECT ON iv.project_image TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
GRANT SELECT ON iv.project_tag TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
GRANT SELECT, INSERT ON iv.project_comment TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';
GRANT SELECT ON iv.settings TO 'ivext'@'localhost' IDENTIFIED BY 'XXX';

--Replace YYY with the internal site db password
GRANT SELECT, INSERT, DELETE, UPDATE, SHOW VIEW ON iv.* TO 'ivint'@'localhost' IDENTIFIED BY 'YYY';
