
-- SQL Script -- 
-- Drop tables were removed as we are going to drop the whole schema seperately -- 

CREATE TABLE roles( -- role is also a taken postgreSQL, issues found with this
    role_id INT PRIMARY KEY,
    name VARCHAR(30) UNIQUE NOT NULL
);

CREATE TABLE users(
 id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
 username VARCHAR(40) UNIQUE NOT NULL,
 email VARCHAR(60) UNIQUE NOT NULL,
 password VARCHAR(255) NOT NULL, -- Increase this because of hashing
 bio TEXT NOT NULL,
 location VARCHAR(50) NOT NULL,
 name VARCHAR(60) NOT NULL,
 profile_picture TEXT,
 points INT DEFAULT 100 CHECK (points >0),
 create_at TEXT DEFAULT (DATE('now')),
 user_role INT NOT NULL DEFAULT 1,
 FOREIGN KEY (user_role) REFERENCES roles(role_id)
);


CREATE TABLE content(
 id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
 date DATE NOT NULL DEFAULT CURRENT_DATE,
 description TEXT NOT NULL,
 rating INT DEFAULT 0 CHECK (rating >=0 AND rating <=5),
 user_id INT NOT NULL DEFAULT 1 REFERENCES users(id) ON DELETE SET DEFAULT,
 version INT NOT NULL DEFAULT 1,
 edit_date DATE NOT NULL DEFAULT CURRENT_DATE CHECK (edit_date>= date)
);

CREATE TABLE notification(
id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
title VARCHAR(60) NOT NULL,
description TEXT NOT NULL,
date DATE NOT NULL DEFAULT CURRENT_DATE,
user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE tag(
id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
name VARCHAR(45) UNIQUE NOT NULL,
description VARCHAR(150) NOT NULL,
color CHAR(7) DEFAULT '#ffffff' CHECK (color ~ '^#[0-9A-Fa-f]{6}$')
);

CREATE TABLE bounty(
id_content INT PRIMARY KEY,
title VARCHAR(60) NOT NULL,
reward INT DEFAULT 50 CHECK (reward>0),
media TEXT,
FOREIGN KEY (id_content) REFERENCES content(id) ON DELETE CASCADE
);

CREATE TABLE answer(
id_content INT PRIMARY KEY,
title VARCHAR(60),
media TEXT,
is_correct BOOLEAN NOT NULL DEFAULT FALSE,
bounty_id INT NOT NULL REFERENCES bounty(id_content) ON DELETE CASCADE,
FOREIGN KEY (id_content) REFERENCES content(id) ON DELETE CASCADE
);

CREATE TABLE comment(
id_content INT PRIMARY KEY,
bounty_id INT NOT NULL REFERENCES bounty(id_content) ON DELETE CASCADE,
answer_id INT REFERENCES answer(id_content) ON DELETE CASCADE,
parent_id INT REFERENCES comment(id_content) ON DELETE CASCADE,
FOREIGN KEY (id_content) REFERENCES content(id) ON DELETE CASCADE);


CREATE TABLE bounty_tag(
bounty_id INT NOT NULL REFERENCES bounty(id_content) ON DELETE CASCADE,
tag_id INT NOT NULL REFERENCES tag(id) ON DELETE CASCADE,
PRIMARY KEY (bounty_id, tag_id)
);

CREATE TABLE content_follow(
user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
content_id INT NOT NULL REFERENCES content(id) ON DELETE CASCADE,
PRIMARY KEY (user_id,content_id)
);

CREATE TABLE tag_follow(
user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
tag_id INT NOT NULL REFERENCES tag(id) ON DELETE CASCADE,
PRIMARY KEY (user_id,tag_id)
);

CREATE TABLE tag_management(   -- The check on id will be handled in the backend--
    admin_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    tag_id INT NOT NULL REFERENCES tag(id) ON DELETE CASCADE,
    PRIMARY KEY (admin_id, tag_id)
);


CREATE TABLE user_rate(
user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
content_id INT NOT NULL REFERENCES content(id) ON DELETE CASCADE,
PRIMARY KEY (user_id,content_id)
);

CREATE TABLE comment_rating_notification(
notification_id INT PRIMARY KEY REFERENCES notification(id) ON DELETE CASCADE,
comment_id INT REFERENCES comment(id_content) ON DELETE CASCADE

);

CREATE TABLE comment_reply_notification(
notification_id INT PRIMARY KEY REFERENCES notification(id) ON DELETE CASCADE,
comment_id INT REFERENCES comment(id_content) ON DELETE CASCADE
);

CREATE TABLE bounty_rating_notification(
notification_id INT PRIMARY KEY REFERENCES notification(id) ON DELETE CASCADE,
bounty_id INT REFERENCES bounty(id_content) ON DELETE CASCADE
);



CREATE TABLE bounty_answer_notification(
notification_id INT PRIMARY KEY REFERENCES notification(id) ON DELETE CASCADE,
bounty_id INT REFERENCES bounty(id_content) ON DELETE CASCADE
);

CREATE TABLE answer_rating_notification(
notification_id INT PRIMARY KEY REFERENCES notification(id) ON DELETE CASCADE,
answer_id INT REFERENCES answer(id_content) ON DELETE CASCADE
);

CREATE TABLE answer_reply_notification(
notification_id INT PRIMARY KEY REFERENCES notification(id) ON DELETE CASCADE,
answer_id INT REFERENCES answer(id_content) ON DELETE CASCADE
);