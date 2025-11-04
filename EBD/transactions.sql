-- TRAN01

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ; 


-- === 1. Insert new content === 

-- A new post made by a user who wants to create a bounty 

INSERT INTO content (description, user_id) 

VALUES ($description, $user_id); 


-- === 2. Create bounty linked to the content === 

-- The bounty shares the same ID as the inserted content 

INSERT INTO bounty (id_content, title, media, reward) 

VALUES (currval(pg_get_serial_sequence('content', 'id')), $title, $media, $reward); 

 
-- === 3. Associate bounty with tags === 

-- Each selected tag will be linked to the new bounty 

-- Example for multiple tags: $tag_ids is a list like [2, 4, 5] 

INSERT INTO bounty_tag (bounty_id, tag_id) 

VALUES (currval(pg_get_serial_sequence('content', 'id')), $tag_id); 

 
END TRANSACTION;



-- TRAN02

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;

-- === 1. Insert new content ===
-- A new post made by a user who wants to create a bounty
INSERT INTO content (description, user_id)
VALUES ($description, $user_id);

-- === 2. Create bounty linked to the content ===
-- The bounty shares the same ID as the inserted content
INSERT INTO bounty (id_content, title, media, reward)
VALUES (currval(pg_get_serial_sequence('content', 'id')), $title, $media, $reward);

-- === 3. Associate bounty with tags ===
-- Each selected tag will be linked to the new bounty
-- Example for multiple tags: $tag_ids is a list like [2, 4, 5]
INSERT INTO bounty_tag (bounty_id, tag_id)
VALUES (currval(pg_get_serial_sequence('content', 'id')), $tag_id);

END TRANSACTION;



-- TRAN03

BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;

-- === 1. Delete any explicit relationships (if not handled by cascade) ===
DELETE FROM user_rate WHERE user_id = $user_id;
DELETE FROM tag_follow WHERE user_id = $user_id;
DELETE FROM content_follow WHERE user_id = $user_id;
DELETE FROM moderator WHERE user_id = $user_id;
DELETE FROM admin WHERE user_id = $user_id;

-- === 2. Delete notifications related to the user ===
DELETE FROM notification WHERE user_id = $user_id;

-- === 3. Delete all content authored by this user
-- (this will cascade to bounties, answers, comments, etc. due to FK constraints)
DELETE FROM content WHERE user_id = $user_id;

-- === 4. Finally, delete the user record itself ===
DELETE FROM users WHERE id = $user_id;

END TRANSACTION;