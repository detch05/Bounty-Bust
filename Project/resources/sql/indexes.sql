-- INDEXES -- 

CREATE INDEX content_time_idx ON content USING btree (created_at DESC);
CLUSTER content USING content_time_idx;

CREATE INDEX tag_name_idx ON tag USING hash(name);

CREATE INDEX answer_correct_idx ON answer USING btree (bounty_id, is_correct);

CREATE INDEX notification_date_idx ON notification USING btree (user_id, date DESC);

-- Full Text Search --

ALTER TABLE bounty
ADD COLUMN tsvectors TSVECTOR;

DROP FUNCTION IF EXISTS bounty_search_update();
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

DROP FUNCTION IF EXISTS content_desc_search_update();
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