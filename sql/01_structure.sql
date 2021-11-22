DROP DATABASE IF EXISTS webpre;
CREATE DATABASE web CHARACTER SET utf8 COLLATE utf8_bin;

SET NAMES utf8;

CONNECT web;

CREATE TABLE lang (
    code    VARCHAR(2)   PRIMARY KEY,
    name    VARCHAR(16)  NOT NULL,
    active  BOOLEAN      DEFAULT 0
);

CREATE TABLE text (
    id       VARCHAR(32)    NOT NULL,
    lang     VARCHAR(2)     NOT NULL,
    section  VARCHAR(32),
    text     VARCHAR(5000),
    file     VARCHAR(32),
    PRIMARY KEY(id, lang),
    FOREIGN KEY (lang) REFERENCES lang(code)
);

CREATE TABLE user (
    id          INT             AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(32)     NOT NULL UNIQUE,
    mail        VARCHAR(128)    NOT NULL UNIQUE,
    first_name  VARCHAR(64),
    lat_name    VARCHAR(64),
    passord     VARCHAR(256),
    salt        VARCHAR(256)
);

CREATE INDEX i_text ON text(id, lang);

CREATE TABLE share(
    id       INT           AUTO_INCREMENT PRIMARY KEY,
    idx      INT           NOT NULL UNIQUE,
    visible  BOOLEAN       NOT NULL DEFAULT 1,
    title    VARCHAR(32)   NOT NULL UNIQUE,
    text     VARCHAR(32),
    icon     VARCHAR(16)   NOT NULL,
    url      VARCHAR(256)  NOT NULL,
    FOREIGN KEY (title) REFERENCES text(id),
    FOREIGN KEY (text)  REFERENCES text(id)
);

CREATE TABLE license (
    id       VARCHAR(32)  PRIMARY KEY,
    summary  VARCHAR(32)  NOT NULL,
    legal    VARCHAR(32)  NOT NULL,
    logo     VARCHAR(32),
    icon     VARCHAR(32),
    FOREIGN KEY (summary)   REFERENCES text(id),
    FOREIGN KEY (legal)     REFERENCES text(id)
);

CREATE TABLE project_type (
    id       VARCHAR(1)   NOT NULL PRIMARY KEY,
    title    VARCHAR(32)  NOT NULL,
    summary  VARCHAR(32)  NOT NULL,
    FOREIGN KEY (title)     REFERENCES text(id),
    FOREIGN KEY (summary)   REFERENCES text(id)
);

CREATE TABLE project (
    id         INT           AUTO_INCREMENT PRIMARY KEY,
    permalink  VARCHAR(300)  NOT NULL,
    idx        INT           NOT NULL UNIQUE,
    type       VARCHAR(1)    NOT NULL,
    title      VARCHAR(32)   NOT NULL,
    logo       VARCHAR(32),
    header     VARCHAR(32),
    text       VARCHAR(32),
    license    VARCHAR(32),
    user       INT           NOT NULL,
    visible    BOOLEAN       NOT NULL DEFAULT 1,
    FOREIGN KEY (type)      REFERENCES project_type(id),
    FOREIGN KEY (title)     REFERENCES text(id),
    FOREIGN KEY (header)    REFERENCES text(id),
    FOREIGN KEY (text)      REFERENCES text(id),
    FOREIGN KEY (license)   REFERENCES license(id),
    FOREIGN KEY (user)      REFERENCES user(id)
);

CREATE TABLE project_url_type (
    id       VARCHAR(1)   NOT NULL PRIMARY KEY,
    title    VARCHAR(32),
    summary  VARCHAR(32),
    logo     VARCHAR(32),
    FOREIGN KEY (title) REFERENCES text(id),
    FOREIGN KEY (summary) REFERENCES text(id)
);

CREATE TABLE project_url (
    id       INT            AUTO_INCREMENT PRIMARY KEY,
    project  INT            NOT NULL,
    type     VARCHAR(1)     NOT NULL,
    url      VARCHAR(1024)  NOT NULL,
    FOREIGN KEY (project) REFERENCES project(id),
    FOREIGN KEY (type) REFERENCES project_url_type(id)
);

CREATE TABLE project_image (
    id       INT           AUTO_INCREMENT PRIMARY KEY,
    project  INT           NOT NULL,
    idx      INT           NOT NULL,
    image    VARCHAR(200)  NOT NULL,
    FOREIGN KEY (project) REFERENCES project(id)
);

CREATE TABLE project_tag (
    project  INT          NOT NULL,
    tag      VARCHAR(32)  NOT NULL,
    PRIMARY KEY (project, tag),
    FOREIGN KEY (project)   REFERENCES project(id),
    FOREIGN KEY (tag)       REFERENCES text(id)
);

CREATE TABLE cv (
    id         INT           AUTO_INCREMENT PRIMARY KEY,
    lang       VARCHAR(2)    NOT NULL,
    file       VARCHAR(300)  NOT NULL,
    visible    BOOLEAN       NOT NULL DEFAULT 1,
    FOREIGN KEY (lang) REFERENCES lang(code)
);

CREATE TABLE settings (
    name     VARCHAR(64)  PRIMARY KEY,
    value    VARCHAR(64)  NOT NULL,
    changed  TIMESTAMP    NOT NULL DEFAULT now()
);

CREATE TABLE stat_visit (
    id       INT           AUTO_INCREMENT PRIMARY KEY,
    ip       VARCHAR(50),
    uagent   VARCHAR(400),
    os       VARCHAR(150),
    browser  VARCHAR(150),
    dtime    TIMESTAMP     NOT NULL DEFAULT now()
);

CREATE TABLE stat_view (
    id       INT           NOT NULL AUTO_INCREMENT PRIMARY KEY,
    visit    INT           NOT NULL,
    section  VARCHAR(80)   NOT NULL,
    entry    VARCHAR(100)  NOT NULL,
    dtime    TIMESTAMP     NOT NULL DEFAULT now(),
    FOREIGN KEY (visit) REFERENCES stat_visit(id)
);
CREATE INDEX i_visit ON stat_view(visit, dtime);

