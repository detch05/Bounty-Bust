CREATE OR REPLACE FUNCTION trg_notify_new_answer() 
RETURNS TRIGGER AS $$ 
DECLARE 
   question_author INT; 
BEGIN
   SELECT user_id INTO question_author 
   FROM content 
   WHERE id = NEW.id_content;   
   INSERT INTO notification (title, description, user_id)
   VALUES ('New answer received', 'Your question received a new answer.', question_author);

   RETURN NEW;
END; 
$$ LANGUAGE plpgsql;

CREATE TRIGGER notify_new_answer 
AFTER INSERT ON answer 
FOR EACH ROW
EXECUTE FUNCTION trg_notify_new_answer();


CREATE OR REPLACE FUNCTION trg_notify_new_comment() 
RETURNS TRIGGER AS $$ 
DECLARE
   recipient_id INT; 
BEGIN
   IF NEW.parent_id IS NOT NULL THEN
      SELECT c.user_id INTO recipient_id 
      FROM content c 
      JOIN comment cm ON c.id = cm.id_content 
      WHERE cm.id_content = NEW.parent_id; 
   ELSE 
      SELECT user_id INTO recipient_id 
      FROM content 
      WHERE id = NEW.id_content; 
   END IF;
   INSERT INTO notification (title, description, user_id)
   VALUES ('New comment', 'A new comment was posted related to your content.', recipient_id);

   RETURN NEW;
END; 
$$ LANGUAGE plpgsql;

CREATE TRIGGER notify_new_comment 
AFTER INSERT ON comment 
FOR EACH ROW 
EXECUTE FUNCTION trg_notify_new_comment();


CREATE OR REPLACE FUNCTION trg_prevent_comment_cycle() 
RETURNS TRIGGER AS $$ 
BEGIN 
   IF NEW.parent_id = NEW.id_content THEN 
      RAISE EXCEPTION 'A comment cannot reference itself as parent';
   END IF; 
   RETURN NEW; 
END; 
$$ LANGUAGE plpgsql;

CREATE TRIGGER prevent_comment_cycle 
BEFORE INSERT OR UPDATE ON comment 
FOR EACH ROW
 EXECUTE FUNCTION trg_prevent_comment_cycle();