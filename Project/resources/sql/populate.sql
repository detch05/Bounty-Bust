-- === INSERTS PARA POPULAÇÃO MASSIVA (BASE DE DADOS REVISADA) ===

-- 0. DADOS INICIAIS (Ajustados para incluir 'bio' e 'location')
INSERT INTO users (username, email, password, name, bio, location, points) VALUES
('alice', 'alice@example.com', '$2a$10$hashed_pw_1_secure', 'Alice Martins', 'Senior Developer focused on Databases and Performance.', 'Lisbon, Portugal', 150),
('bruno', 'bruno@example.com', '$2a$10$hashed_pw_2_secure', 'Bruno Silva', 'Python enthusiast and machine learning amateur.', 'Porto, Portugal', 120),
('carla', 'carla@example.com', '$2a$10$hashed_pw_3_secure', 'Carla Gomes', 'UX/UI specialist and WebDev advocate.', 'Coimbra, Portugal', 100),
('daniel', 'daniel@example.com', '$2a$10$hashed_pw_4_secure', 'Daniel Sousa', 'Full-stack JS developer and open-source contributor.', 'Faro, Portugal', 200),
('eva', 'eva@example.com', '$2a$10$hashed_pw_5_secure', 'Eva Costa', 'AI Researcher with a focus on Deep Learning.', 'Madrid, Spain', 180);

INSERT INTO admin (user_id) VALUES (1);
INSERT INTO moderator (user_id) VALUES (2);

INSERT INTO tag (name, description, color) VALUES
('SQL', 'Questions about SQL syntax and optimization', '#e1e1e1'),
('Python', 'Questions about Python programming', '#f7df1e'),
('WebDev', 'Web development topics (HTML, CSS, JS)', '#4caf50'),
('Databases', 'Design and performance of databases', '#2196f3'),
('AI', 'Artificial intelligence and machine learning', '#9c27b0');

INSERT INTO content (description, user_id, date) VALUES
('How can I join two tables efficiently in PostgreSQL?', 1, '2025-10-01'), -- ID 1 (Bounty 1)
('What is the difference between a list and a tuple in Python?', 2, '2025-10-02'), -- ID 2 (Bounty 2)
('Best practices for designing relational databases?', 3, '2025-10-03'), -- ID 3 (Bounty 3)
('How to center a div in CSS?', 4, '2025-10-04'), -- ID 4 (Bounty 4)
('What is backpropagation in neural networks?', 5, '2025-10-05'); -- ID 5 (Bounty 5)

-- Transformando todos os 5 conteúdos iniciais em Bounties
INSERT INTO bounty (id_content, title, media, reward) VALUES
(1, 'Optimize SQL Join Performance', NULL, 100),
(2, 'Python List vs Tuple Distinction', NULL, 60),
(3, 'Database Design Challenge', NULL, 75),
(4, 'Centering a Div in CSS', NULL, 50),
(5, 'Explaining Backpropagation', NULL, 80);

INSERT INTO bounty_tag (bounty_id, tag_id) VALUES
(1, 1), (1, 4),
(2, 2),
(3, 4),
(4, 3),
(5, 5);

---
## 1. Novos Usuários e Tags

-- 1. NOVOS USERS (5 novos usuários com dados completos)
INSERT INTO users (username, email, password, name, bio, location, points) VALUES
('filipe', 'filipe@example.com', '$2a$10$hashed_pw_6_secure', 'Filipe Nuno', 'Enjoys frontend frameworks like React and Vue.', 'Berlin, Germany', 110),
('goncalo', 'goncalo@example.com', '$2a$10$hashed_pw_7_secure', 'Gonçalo Pires', 'Backend specialist focusing on Java and scalable systems.', 'London, UK', 130),
('helena', 'helena@example.com', '$2a$10$hashed_pw_8_secure', 'Helena Marques', 'DevOps engineer and cloud architecture consultant.', 'Paris, France', 160),
('ivan', 'ivan@example.com', '$2a$10$hashed_pw_9_secure', 'Ivan Rocha', 'Cybersecurity analyst and ethical hacker.', 'Boston, USA', 190),
('joana', 'joana@example.com', '$2a$10$hashed_pw_10_secure', 'Joana Lopes', 'Data Scientist, expert in Python and data visualization.', 'São Paulo, Brazil', 140);

-- 2. NOVOS TAGS
INSERT INTO tag (name, description, color) VALUES
('JavaScript', 'Questions about the JavaScript programming language', '#f0db4f'),
('Java', 'Questions about the Java programming language', '#007396'),
('Security', 'Software and web security topics', '#ff0000'),
('Linux', 'Administration and usage of Linux systems', '#333333');

---
## 2. 15 Novas Bounties (IDs 6 a 20)

-- Content para Bounties (IDs 6 a 20)
INSERT INTO content (description, user_id, date) VALUES
('Troubleshooting a deployment issue for a Node.js application on Heroku.', 3, '2025-10-06'), -- ID 6
('What is the best way to manage state in React using Redux or Context API?', 5, '2025-10-07'), -- ID 7
('How to optimize query latency in a MySQL database with millions of records?', 4, '2025-10-08'), -- ID 8
('Detailed differences between `INNER JOIN` and `LEFT JOIN` with practical examples.', 1, '2025-10-09'), -- ID 9
('How to implement a pure JavaScript debounce function?', 2, '2025-10-10'), -- ID 10
('What are the best security practices for designing RESTful APIs?', 6, '2025-10-11'), -- ID 11
('How to handle dependency injection in Java projects (Spring/CDI)?', 7, '2025-10-12'), -- ID 12
('What is the role of Containers (Docker/Kubernetes) in modern development?', 8, '2025-10-13'), -- ID 13
('Basic Iptables firewall configuration for a simple web server.', 9, '2025-10-14'), -- ID 14
('How does the Garbage Collector work in Python?', 10, '2025-10-15'), -- ID 15
('Concurrency issues and how to resolve them in Python multi-threading.', 3, '2025-10-16'), -- ID 16
('Strategies for backup and recovery of PostgreSQL databases.', 5, '2025-10-17'), -- ID 17
('How to create a responsive dashboard using Bootstrap 5 and Chart.js?', 4, '2025-10-18'), -- ID 18
('Explain the concept of Generative Adversarial Networks (GANs).', 1, '2025-10-19'), -- ID 19
('How to write effective unit tests in Java with JUnit?', 2, '2025-10-20'); -- ID 20

-- Bounties (ID_content de 6 a 20)
INSERT INTO bounty (id_content, title, media, reward) VALUES
(6, 'Node.js Deployment on Heroku', NULL, 60),
(7, 'React State Management: Redux vs Context', NULL, 120),
(8, 'Optimizing MySQL Query Latency', NULL, 150),
(9, 'Understanding SQL Joins', NULL, 80),
(10, 'Implementing JS Debounce Function', NULL, 70),
(11, 'RESTful API Security Best Practices', NULL, 110),
(12, 'Dependency Injection in Java', NULL, 90),
(13, 'Containers Role in Modern Dev (Docker/K8s)', NULL, 130),
(14, 'Basic Iptables Setup', NULL, 75),
(15, 'Python Garbage Collector Mechanism', NULL, 85),
(16, 'Resolving Python Concurrency Issues', NULL, 105),
(17, 'PostgreSQL Backup and Recovery', NULL, 140),
(18, 'Responsive Dashboard with Bootstrap 5', NULL, 65),
(19, 'Explain GANs (Generative Adversarial Networks)', NULL, 125),
(20, 'Effective JUnit Unit Testing in Java', NULL, 95);

---
## 3. Respostas Adicionais (3 para cada Bounty Inicial)

-- Content para as 15 novas respostas (IDs 21 a 35)
INSERT INTO content (description, user_id, date) VALUES
-- Respostas para Bounty 1: 'How can I join two tables efficiently in PostgreSQL?'
('Consider partial denormalization for read-heavy query performance.', 3, '2025-10-21'), -- ID 21
('Check the use of CTEs or correlated subqueries for better execution plans.', 4, '2025-10-22'), -- ID 22
('Ensure join columns have the same data type and appropriate indexes are present.', 5, '2025-10-23'), -- ID 23
-- Respostas para Bounty 2: 'What is the difference between a list and a tuple in Python?'
('Lists are mutable and used for sequences that might change. Tuples are immutable and faster.', 6, '2025-10-24'), -- ID 24
('Tuples are often used as dictionary keys because of their immutability.', 7, '2025-10-25'), -- ID 25
('The memory consumption of a tuple is generally smaller than a list for the same number of elements.', 8, '2025-10-26'), -- ID 26
-- Respostas para Bounty 3: 'Best practices for designing relational databases?'
('Use 3rd Normal Form (3NF) as a starting point, but optimize for the specific usage scenario.', 9, '2025-10-27'), -- ID 27
('The choice of storage engine (e.g., InnoDB vs MyISAM) can greatly affect performance.', 10, '2025-10-28'), -- ID 28
('Correctly define Primary and Foreign keys to ensure referential integrity.', 1, '2025-10-29'), -- ID 29
-- Respostas para Bounty 4: 'How to center a div in CSS?'
('Use Flexbox with `display: flex; justify-content: center; align-items: center;` on the parent.', 2, '2025-10-30'), -- ID 30
('Alternatively, use CSS Grid for a robust two-dimensional centering solution.', 3, '2025-10-31'), -- ID 31
('The old school way: `margin: auto;` with fixed width and `position: absolute;` with translation.', 4, '2025-11-01'), -- ID 32
-- Respostas para Bounty 5: 'What is backpropagation in neural networks?'
('Backpropagation is an algorithm used to train neural networks by minimizing the error.', 5, '2025-11-02'), -- ID 33
('It calculates the gradient of the loss function with respect to the weights by the chain rule.', 6, '2025-11-03'), -- ID 34
('This process flows backwards from the output layer to the input layer.', 7, '2025-11-04'); -- ID 35

-- ANSWERS (Associação das novas respostas às bounties iniciais)
INSERT INTO answer (id_content, title, media, is_correct, bounty_id) VALUES
(21, 'Partial Denormalization for Speed', NULL, FALSE, 1),
(22, 'Using CTEs and Subqueries', NULL, FALSE, 1),
(23, 'Join Indexing Best Practices', NULL, TRUE, 1), -- Correta para Bounty 1
(24, 'Mutability and Speed Difference', NULL, TRUE, 2), -- Correta para Bounty 2
(25, 'Tuple use as Dictionary Keys', NULL, FALSE, 2),
(26, 'Tuple Memory Efficiency', NULL, FALSE, 2),
(27, 'Normalization and Usage Trade-offs', NULL, FALSE, 3),
(28, 'Storage Engine Selection Impact', NULL, FALSE, 3),
(29, 'Referential Integrity Checks', NULL, TRUE, 3), -- Correta para Bounty 3
(30, 'Flexbox Centering Method', NULL, FALSE, 4),
(31, 'CSS Grid Centering', NULL, TRUE, 4), -- Correta para Bounty 4
(32, 'Absolute Position and Margin: Auto', NULL, FALSE, 4),
(33, 'Error Minimization Algorithm', NULL, FALSE, 5),
(34, 'Gradient Calculation via Chain Rule', NULL, TRUE, 5), -- Correta para Bounty 5
(35, 'Flow from Output to Input', NULL, FALSE, 5);

---
## 4. Comentários e Interações

-- Content para Comentários (IDs 36 a 41)
INSERT INTO content (description, user_id, date) VALUES
('Great explanation of the storage engine impact. Did you consider sharding?', 9, '2025-11-05'), -- ID 36 (Comentário ao content 28 - Answer 3)
('Why are you recommending 3NF over BCNF for this specific case?', 10, '2025-11-06'), -- ID 37 (Comentário ao content 27 - Answer 3)
('The memory efficiency point is often overlooked in Python performance discussions.', 6, '2025-11-07'), -- ID 38 (Comentário ao content 26 - Answer 2)
('Does the absolute position method work on all browsers?', 7, '2025-11-08'), -- ID 39 (Comentário ao content 32 - Answer 4)
('Which libraries are commonly used for implementing backpropagation (e.g., TensorFlow or PyTorch)?', 8, '2025-11-09'), -- ID 40 (Comentário ao content 33 - Answer 5)
('Reply to comment 37: BCNF is great, but 3NF offers a better balance when focusing on data update costs.', 1, '2025-11-10'); -- ID 41 (Resposta ao comentário 37)

-- Inserir comentários
INSERT INTO comment (id_content, bounty_id, answer_id, parent_id) VALUES
(36, 3, 28, NULL),
(37, 3, 27, NULL),
(38, 2, 26, NULL),
(39, 4, 32, NULL),
(40, 5, 33, NULL),
(41, 3, 27, 37); -- Resposta ao comentário 37 (Parent ID = 37)

---
## 5. Relacionamentos e Notificações

-- BOUNTY_TAG (Associação das novas bounties a tags)
-- (Incluindo novos IDs para as novas tags: JavaScript(6), Java(7), Security(8), Linux(9))
INSERT INTO bounty_tag (bounty_id, tag_id) VALUES
(6, 6), (6, 3), (7, 6), (7, 3), (8, 4), (9, 1), (10, 6),
(11, 8), (12, 7), (13, 3), (13, 9), (14, 9), (15, 2), (16, 2),
(17, 4), (18, 3), (19, 5), (20, 7);

-- TAG_FOLLOW
INSERT INTO tag_follow (user_id, tag_id) VALUES
(6, 6), (7, 7), (8, 3), (9, 9), (10, 2),
(1, 2), (5, 3), (2, 7); -- Interações adicionais

-- CONTENT_FOLLOW (Seguindo os novos Bounties)
INSERT INTO content_follow (user_id, content_id) VALUES
(6, 7), (7, 12), (8, 18), (9, 14), (10, 15),
(1, 4), (2, 5), (3, 10); -- Seguir conteúdo anterior/novo

-- USER_RATE (Ratings para os novos Bounties/Answers/Comments)
INSERT INTO user_rate (user_id, content_id) VALUES
(1, 6), (1, 7), (2, 8), (2, 9), (3, 10), (3, 11),
(4, 21), (4, 24), (5, 26), (5, 27), (6, 30), (7, 33),
(8, 36), (9, 39), (10, 41), (1, 40); -- Avaliar respostas e comentários

-- NOTIFICATIONS (Exemplos de notificação, trigger cria algumas automaticamente)
INSERT INTO notification (title, description, user_id, date) VALUES
('Correct Answer Selected', 'Your answer to "Join Indexing Best Practices" was marked as correct!', 5, '2025-11-11'), -- ID 1 (Resposta 23, User 5)
('Bounty Rating Up!', 'Your bounty "Node.js Deployment on Heroku" received a new rating.', 3, '2025-11-11'), -- ID 2 (Bounty 6, User 3)
('New Reply to your Comment', 'Someone replied to your comment about BCNF.', 10, '2025-11-12'), -- ID 3 (Comentário 37, User 10)
('New Answer on your bounty', 'Your "Python List vs Tuple Distinction" bounty got a new answer.', 2, '2025-11-13'), -- ID 4 (Bounty 2, User 2)
('Comment Rating Up', 'Your comment on "Storage Engine Impact" was rated positively.', 9, '2025-11-14'); -- ID 5 (Comentário 36, User 9)


-- NOTIFICAÇÕES ESPECÍFICAS
INSERT INTO answer_rating_notification (notification_id, answer_id) VALUES
(1, 23); -- Notificação de rating/correção para a resposta 23

INSERT INTO bounty_rating_notification (notification_id, bounty_id) VALUES
(2, 6); -- Notificação de rating para o bounty 6

INSERT INTO comment_reply_notification (notification_id, comment_id) VALUES
(3, 37); -- Notificação de resposta ao comentário 37

INSERT INTO bounty_answer_notification (notification_id, bounty_id) VALUES
(4, 2); -- Notificação de nova resposta para o bounty 2

INSERT INTO comment_rating_notification (notification_id, comment_id) VALUES
(5, 36); -- Notificação de rating para o comentário 36