DROP TABLE IF EXISTS admin CASCADE;
DROP TABLE IF EXISTS moderator CASCADE;
DROP TABLE IF EXISTS content_follow CASCADE;
DROP TABLE IF EXISTS tag_follow CASCADE;
DROP TABLE IF EXISTS user_rate CASCADE;
DROP TABLE IF EXISTS notification CASCADE;
DROP TABLE IF EXISTS content CASCADE;
DROP TABLE IF EXISTS bounty CASCADE;
DROP TABLE IF EXISTS answer CASCADE;
DROP TABLE IF EXISTS comment CASCADE;
DROP TABLE IF EXISTS bounty_tag CASCADE;
DROP TABLE IF EXISTS tag_management CASCADE;
DROP TABLE IF EXISTS comment_rating_notification CASCADE;
DROP TABLE IF EXISTS comment_reply_notification CASCADE;
DROP TABLE IF EXISTS bounty_rating_notification CASCADE;
DROP TABLE IF EXISTS bounty_answer_notification CASCADE;
DROP TABLE IF EXISTS answer_rating_notification CASCADE;
DROP TABLE IF EXISTS answer_reply_notification CASCADE;
DROP TABLE IF EXISTS tag CASCADE;
DROP TABLE IF EXISTS users CASCADE;

-- SQL Script -- 

CREATE TABLE users(
 id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
 username VARCHAR(40) UNIQUE NOT NULL,
 email VARCHAR(60) NOT NULL,
 password VARCHAR(50) NOT NULL,
 name VARCHAR(40) NOT NULL,
 profile_picture TEXT,
 points INT DEFAULT 100 CHECK (points >0)
);

CREATE TABLE admin(
 user_id INT PRIMARY KEY,
 FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE moderator(
 user_id INT PRIMARY KEY,
 FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
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
name VARCHAR(45) NOT NULL,
description VARCHAR(150) NOT NULL,
color CHAR(7) DEFAULT '#ffffff' CHECK (color ~ '^#[0-9A-Fa-f]{6}$')
);

CREATE TABLE bounty(
id_content INT PRIMARY KEY,
title VARCHAR(60) NOT NULL,
media TEXT,
reward INT DEFAULT 50 CHECK (reward>0),
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

CREATE TABLE tag_management(
admin_id INT NOT NULL REFERENCES admin(user_id) ON DELETE CASCADE,
tag_id INT NOT NULL REFERENCES tag(id) ON DELETE CASCADE,
PRIMARY KEY (admin_id,tag_id)
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