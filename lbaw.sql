DROP SCHEMA IF EXISTS "BountyBust";

CREATE SCHEMA IF NOT EXISTS "BountyBust"
    AUTHORIZATION postgres;
SET search_path TO "BountyBust";

CREATE TABLE users(
 id SERIAL PRIMARY KEY,
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
 id SERIAL PRIMARY KEY,
 date DATE NOT NULL DEFAULT CURRENT_DATE,
 description TEXT NOT NULL,
 rating INT DEFAULT 0 CHECK (rating >=0 AND rating <=5),
 user_id INT NOT NULL DEFAULT 1 REFERENCES users(id) ON DELETE SET DEFAULT,
 version INT NOT NULL DEFAULT 1,
 edit_date DATE NOT NULL DEFAULT CURRENT_DATE CHECK (edit_date>= date)
);

CREATE TABLE notification(
id SERIAL PRIMARY KEY,
title VARCHAR(60) NOT NULL,
description TEXT NOT NULL,
date DATE NOT NULL DEFAULT CURRENT_DATE,
user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE tag(
id SERIAL PRIMARY KEY,
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
FOREIGN KEY (id_content) REFERENCES content(id) ON DELETE CASCADE
);

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


CREATE INDEX content_date_idx ON content USING btree (date);
CLUSTER content USING content_date_idx;

CREATE INDEX tag_name_idx ON tag USING hash(name);
CREATE INDEX answer_correct_idx ON answer USING btree (bounty_id, is_correct);
CREATE INDEX notification_date_idx ON notification USING btree (user_id, date DESC);

ALTER TABLE bounty
ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION bounty_search_update() RETURNS TRIGGER AS $$
BEGIN
  NEW.tsvectors = (
    setweight(to_tsvector('english',NEW.title), 'A') ||
    setweight(to_tsvector('english', (
      SELECT description FROM content WHERE id = NEW.id_content
    )), 'B')
  );
  RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE FUNCTION content_desc_search_update() RETURNS TRIGGER AS $$
BEGIN
  UPDATE bounty SET
  tsvectors = (
    setweight(to_tsvector('english',title), 'A') ||
    setweight(to_tsvector('english', NEW.description), 'B')
  )
  WHERE bounty.id_content = NEW.id;
  RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER bounty_search_update
BEFORE INSERT OR UPDATE ON bounty
FOR EACH ROW
EXECUTE PROCEDURE bounty_search_update();

CREATE TRIGGER content_desc_search_update
AFTER UPDATE OF description ON content
FOR EACH ROW
EXECUTE PROCEDURE content_desc_search_update();

CREATE INDEX bounty_search_idx ON bounty USING GIN (tsvectors);
