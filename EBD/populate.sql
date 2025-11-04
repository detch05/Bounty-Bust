-- TRUNCATE all data
TRUNCATE TABLE 
  comment_rating_notification,
  comment_reply_notification,
  bounty_rating_notification,
  bounty_answer_notification,
  answer_rating_notification,
  answer_reply_notification,
  user_rate,
  tag_management,
  tag_follow,
  content_follow,
  bounty_tag,
  comment,
  answer,
  bounty,
  content,
  tag,
  moderator,
  admin,
  notification,
  users
RESTART IDENTITY CASCADE;


-- === USERS === 

INSERT INTO users (username, email, password, name, profile_picture, points) VALUES 

('alice', 'alice@example.com', 'hashed_pw_1', 'Alice Martins', NULL, 150), 

('bruno', 'bruno@example.com', 'hashed_pw_2', 'Bruno Silva', NULL, 120), 

('carla', 'carla@example.com', 'hashed_pw_3', 'Carla Gomes', NULL, 100), 

('daniel', 'daniel@example.com', 'hashed_pw_4', 'Daniel Sousa', NULL, 200), 

('eva', 'eva@example.com', 'hashed_pw_5', 'Eva Costa', NULL, 180); 

 

-- === ADMIN & MODERATOR === 

INSERT INTO admin (user_id) VALUES (1); 

INSERT INTO moderator (user_id) VALUES (2); 

 

-- === TAGS === 

INSERT INTO tag (name, description, color) VALUES 

('SQL', 'Questions about SQL syntax and optimization', '#e1e1e1'), 

('Python', 'Questions about Python programming', '#f7df1e'), 

('WebDev', 'Web development topics (HTML, CSS, JS)', '#4caf50'), 

('Databases', 'Design and performance of databases', '#2196f3'), 

('AI', 'Artificial intelligence and machine learning', '#9c27b0'); 

 

-- === CONTENT (questions/posts) === 

INSERT INTO content (description, user_id) VALUES 

('How can I join two tables efficiently in PostgreSQL?', 1), 

('What is the difference between a list and a tuple in Python?', 2), 

('Best practices for designing relational databases?', 3), 

('How to center a div in CSS?', 4), 

('What is backpropagation in neural networks?', 5);

 

-- === BOUNTIES === 

INSERT INTO bounty (id_content, title, media, reward) VALUES 

(1, 'Optimize SQL join performance', NULL, 100), 

(3, 'Database design challenge', NULL, 75); 

 

-- === ANSWERS === 

INSERT INTO answer (id_content, title, media, is_correct, bounty_id) VALUES 

(1, 'Use indexes and EXPLAIN ANALYZE', NULL, TRUE, 1), 

(3, 'Normalize tables and plan for indexes', NULL, FALSE, 3); 

 

-- === COMMENTS === 

INSERT INTO comment (id_content, bounty_id, answer_id, parent_id) VALUES 

(1, 1, 1, NULL), 

(3, 3, 3, NULL); 

 

-- === BOUNTY_TAG (link between bounties and tags) === 

INSERT INTO bounty_tag (bounty_id, tag_id) VALUES 

(1, 1), 

(1, 4), 

(3, 4), 

(3, 5); 

 

-- === CONTENT_FOLLOW === 

INSERT INTO content_follow (user_id, content_id) VALUES 

(2, 1), 

(3, 3), 

(4, 2), 

(5, 1); 

 

-- === TAG_FOLLOW === 

INSERT INTO tag_follow (user_id, tag_id) VALUES 

(1, 1), 

(2, 2), 

(3, 4), 

(4, 3), 

(5, 5); 

 

-- === TAG_MANAGEMENT === 

INSERT INTO tag_management (admin_id, tag_id) VALUES 

(1, 1), 

(1, 4); 

 

-- === NOTIFICATIONS === 

INSERT INTO notification (title, description, user_id) VALUES 

('New answer received', 'Your question on SQL joins got an answer.', 1), 

('New comment', 'Someone commented on your answer.', 2), 

('New bounty available', 'A new bounty has been posted in Databases.', 3); 

 

-- === SIMPLE RATING / FOLLOW DATA === 

INSERT INTO user_rate (user_id, content_id) VALUES 

(1, 2), 

(2, 1), 

(3, 4), 

(4, 5); 