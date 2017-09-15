CREATE DATABASE iv CHARACTER SET utf8 COLLATE utf8_bin;

SET NAMES utf8;

CONNECT iv;

CREATE TABLE lang (
    code        VARCHAR(2)      PRIMARY KEY,
    name        VARCAHR(16)     NOT NULL,
    enabled     BOOLEAN         DEFAULT 0
);

CREATE TABLE text (
    id      VARCHAR(32),
    lang    VARCHAR(2)      REFERENCES lang.code,
    section VARCHAR(32),
    text    VARCHAR(5000)   NOT NULL
    PRIMARY KEY(id, lang)
);
CREATE INDEX i_text ON text(id, lang);

CREATE TABLE user (
    id          INT             AUTO_INCREMENT  PRIMARY KEY,
    username    VARCHAR(64)     NOT NULL,
    email       VARCHAR(128)    NOT NULL,
    password    CHAR(128)       NOT NULL,
    salt        CHAR(128)       NOT NULL,
    fname       VARCHAR(64),
    lname       VARCHAR(64),
    picture     VARCHAR(100),
    phone       VARCHAR(16),
    cp          VARCHAR(6),
    admin       BOOLEAN         NOT NULL        DEFAULT 0,
    active      BOOLEAN         NOT NULL        DEFAULT 0
);

CREATE TABLE login_attempts (
    user    INT         NOT NULL    REFERENCES user.id,
    dtime   VARCHAR(30) NOT NULL,
    success BOOLEAN     NOT NULL    DEFAULT 0,
);

CREATE TABLE permissions(
    user        INT         PRIMARY KEY     REFERENCES user.id,
    permission  VARCHAR(32) NOT NULL
    RIMARY KEY(user, permission)
);

CREATE TABLE post (
    id          INT             AUTO_INCREMENT  PRIMARY KEY,
    permalink   VARCHAR(300)    NOT NULL,
    title       VARCHAR(32)     NOT NULL        REFERENCES text.id,
    text        VARCHAR(32)     NOT NULL        REFERENCES text.id,
    user        INT             NOT NULL        REFERENCES user.id,
    dtime       TIMESTAMP       NOT NULL        DEFAULT now(),
    visible     BOOLEAN         NOT NULL        DEFAULT 1,
    comments    BOOLEAN         NOT NULL        DEFAULT 1
);

CREATE TABLE post_tag (
    post    INT            NOT NULL     REFERENCES post.id,
    tag     VARCHAR(32)    NOT NULL     REFERENCES text.id,,
    PRIMARY KEY (post, tag)
);

CREATE TABLE post_image (
    id      INT             NOT NULL    PRIMARY KEY,
    post    INT             NOT NULL    REFERENCES post.id,
    image   VARCHAR(200)    NOT NULL,
    PRIMARY KEY(id, post)
);

CREATE TABLE post_comment (
    id        INT             AUTO_INCREMENT              PRIMARY KEY,
    post      INT             NOT NULL                    REFERENCES post(id),
    text      VARCHAR(5000)   NOT NULL,
    dtime     TIMESTAMP       NOT NULL                    DEFAULT now(),
    user      INT             REFERENCES user.id,
    username  VARCHAR(200),
    lang      VARCHAR(10),
    approved  BOOLEAN         NOT NULL                    DEFAULT 1,
    visit     INT             REFERENCES stat_visit.id,
);

CREATE TABLE project (
    id          INT             AUTO_INCREMENT  PRIMARY KEY,
    permalink   VARCHAR(300)    NOT NULL,
    title       VARCHAR(32)     NOT NULL        REFERENCES text.id,
    text        VARCHAR(32)     NOT NULL        REFERENCES text.id,
    user        INT             NOT NULL        REFERENCES user.id,
    visible     BOOLEAN         NOT NULL        DEFAULT 1,
    comments    BOOLEAN         NOT NULL        DEFAULT 1
);

CREATE TABLE project_url (
    project     INT,
    type        VARCAHR(32),
    url         VARCHAR(1024),
    PRIMARY KEY (project, type)
);

CREATE TABLE project_image (){
    id          INT             NOT NULL,
    project     INT             NOT NULL    REFERENCES project.id,
    image       VARCHAR(200)    NOT NULL,
    PRIMARY KEY(id, project)
}

CREATE TABLE project_tag (
    project     INT            NOT NULL     REFERENCES project.id,
    tag         VARCHAR(32)    NOT NULL     REFERENCES text.id,,
    PRIMARY KEY (project, tag)
);

CREATE TABLE project_comment (
    id        INT             AUTO_INCREMENT              PRIMARY KEY,
    project   INT             NOT NULL                    REFERENCES project(id),
    text      VARCHAR(5000)   NOT NULL,
    dtime     TIMESTAMP       NOT NULL                    DEFAULT now(),
    user      INT             REFERENCES user.id,
    username  VARCHAR(200),
    lang      VARCHAR(10),
    approved  BOOLEAN         NOT NULL                    DEFAULT 1,
    visit     INT             REFERENCES stat_visit.id,
);

CREATE TABLE settings (
    name        VARCHAR(64)     PRIMARY KEY,
    value       VARCHAR(64)     NOT NULL,
    user        INT             REFERENCES user.id,
    changed     TIMESTAMP       NOT NULL                DEFAULT now()
);

CREATE TABLE stat_visit (
    id          INT              AUTO_INCREMENT    PRIMARY KEY,
    ip          VARCHAR(50),
    uagent      VARCHAR(400),
    os          VARCHAR(150),
    browser     VARCHAR(150)
);

CREATE TABLE stat_view (
    id          INT             NOT NULL    AUTO_INCREMENT    PRIMARY KEY,
    visit       INT             NOT NULL    REFERENCES stat_visit.id,
    section     VARCHAR(80)     NOT NULL,
    entry       VARCHAR(100)    NOT NULL,
    dtime       TIMESTAMP       NOT NULL    DEFAULT now()
);
CREATE INDEX i_visit ON stat_view(visit, dtime);


