DROP DATABASE IF EXISTS web;
CREATE DATABASE web CHARACTER SET utf8 COLLATE utf8_bin;

SET NAMES utf8;

CONNECT web;

CREATE TABLE lang (
    code    VARCHAR(2)   PRIMARY KEY,
    name    VARCHAR(16)  NOT NULL,
    active  BOOLEAN      DEFAULT 0
);

CREATE TABLE text (
    id       VARCHAR(32),
    lang     VARCHAR(2)     REFERENCES lang.code,
    section  VARCHAR(32),
    text     VARCHAR(5000),
    file     VARCHAR(32),
    PRIMARY KEY(id, lang)
);
CREATE INDEX i_text ON text(id, lang);

CREATE TABLE share(
    id       INT           AUTO_INCREMENT      PRIMARY KEY,
    idx      INT           NOT NULL            UNIQUE,
    visible  BOOLEAN       NOT NULL            DEFAULT 1,
    title    VARCHAR(32)   NOT NULL            UNIQUE       REFERENCES text.id,
    text     VARCHAR(32)   REFERENCES text.id,
    icon     VARCHAR(16)   NOT NULL,
    url      VARCHAR(256)  NOT NULL
);

CREATE TABLE license (
    id       VARCHAR(32)  PRIMARY KEY,
    summary  VARCHAR(32)  NOT NULL     REFERENCES text.id,
    legal    VARCHAR(32)  NOT NULL     REFERENCES text.id,
    logo     VARCHAR(32),
    icon     VARCHAR(32)
);

CREATE TABLE project_type (
    id       VARCHAR(1)   NOT NULL  PRIMARY KEY,
    title    VARCHAR(32)  NOT NULL  REFERENCES text.id,
    summary  VARCHAR(32)  NOT NULL  REFERENCES text.id
);

CREATE TABLE project (
    id         INT           AUTO_INCREMENT         PRIMARY KEY,
    permalink  VARCHAR(300)  NOT NULL,
    type       VARCHAR(1)    NOT NULL               REFERENCES project_type.id,
    title      VARCHAR(32)   NOT NULL               REFERENCES text.id,
    logo       VARCHAR(32),
    header     VARCHAR(32)   REFERENCES text.id,
    text       VARCHAR(32)   REFERENCES text.id,
    license    VARCHAR(32)   REFERENCES license.id,
    user       INT           NOT NULL               REFERENCES user.id,
    visible    BOOLEAN       NOT NULL               DEFAULT 1,
    comments   BOOLEAN       NOT NULL               DEFAULT 1
);

CREATE TABLE project_url_type (
    id       VARCHAR(1)   NOT NULL            PRIMARY KEY,
    title    VARCHAR(32)  REFERENCES text.id,
    summary  VARCHAR(32)  REFERENCES text.id,
    logo     VARCHAR(32)
);

CREATE TABLE project_url (
    id       INT            AUTO_INCREMENT  PRIMARY KEY,
    project  INT            NOT NULL        REFERENCES project.id,
    type     VARCHAR(1)     NOT NULL        REFERENCES project_url_type,
    url      VARCHAR(1024)  NOT NULL
);

CREATE TABLE project_image (
    id       INT           AUTO_INCREMENT  PRIMARY KEY,
    project  INT           NOT NULL        REFERENCES project.id,
    idx      INT           NOT NULL,
    image    VARCHAR(200)  NOT NULL
);

CREATE TABLE project_tag (
    project  INT          NOT NULL  REFERENCES project.id,
    tag      VARCHAR(32)  NOT NULL  REFERENCES text.id,
    PRIMARY KEY (project, tag)
);

CREATE TABLE project_comment (
    id        INT            AUTO_INCREMENT            PRIMARY KEY,
    project   INT            NOT NULL                  REFERENCES project(id),
    text      VARCHAR(5000)  NOT NULL,
    dtime     TIMESTAMP      NOT NULL                  DEFAULT now(),
    user      INT            REFERENCES user.id,
    username  VARCHAR(200),
    lang      VARCHAR(10),
    approved  BOOLEAN        NOT NULL                  DEFAULT 1,
    visit     INT            REFERENCES stat_visit.id
);

CREATE TABLE cv_section (
    id        INT          AUTO_INCREMENT      PRIMARY KEY,
    title     VARCHAR(32)  REFERENCES text.id,
    summary   VARCHAR(32)  REFERENCES text.id,
    visible   BOOLEAN      NOT NULL            DEFAULT 1,
    priority  INT          NOT NULL            UNIQUE
);

CREATE TABLE cv (
    id               INT          AUTO_INCREMENT  PRIMARY KEY,
    category         INT          NOT NULL        REFERENCES cv_category.id,
    role             VARCHAR(32)  NOT NULL        REFERENCES text.id,
    company          VARCHAR(64)  NOT NULL,
    city             VARCHAR(32)  NOT NULL        REFERENCES text.id,
    start            DATETIME     NOT NULL,
    end              DATETIME,
    date_precission  VARCHAR(1)   NOT NULL        DEFAULT 'M',
    summary          VARCHAR(32)  NOT NULL        REFERENCES text.id,
    visible          BOOLEAN      NOT NULL        DEFAULT 1
);

CREATE TABLE settings (
    name     VARCHAR(64)  PRIMARY KEY,
    value    VARCHAR(64)  NOT NULL,
    changed  TIMESTAMP    NOT NULL DEFAULT now()
);

CREATE TABLE stat_visit (
    id       INT           AUTO_INCREMENT  PRIMARY KEY,
    ip       VARCHAR(50),
    uagent   VARCHAR(400),
    os       VARCHAR(150),
    browser  VARCHAR(150),
    dtime    TIMESTAMP     NOT NULL  DEFAULT now()
);

CREATE TABLE stat_view (
    id       INT           NOT NULL  AUTO_INCREMENT            PRIMARY KEY,
    visit    INT           NOT NULL  REFERENCES stat_visit.id,
    section  VARCHAR(80)   NOT NULL,
    entry    VARCHAR(100)  NOT NULL,
    dtime    TIMESTAMP     NOT NULL  DEFAULT now()
);
CREATE INDEX i_visit ON stat_view(visit, dtime);

