CREATE OR REPLACE FUNCTION get_user_reputation(p_user_id INT)
RETURNS INT AS $$
DECLARE
    rep INT;
BEGIN
    SELECT u.points + COALESCE(COUNT(a.id_content) * 10, 0)
    INTO rep
    FROM users u
    LEFT JOIN answer a ON a.is_correct = TRUE AND a.id_content IN (
        SELECT id FROM content WHERE user_id = u.id
    )
    WHERE u.id = p_user_id
    GROUP BY u.id;
    RETURN COALESCE(rep, 0);
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION get_user_notifications(p_user_id INT)
RETURNS TABLE(id INT, title VARCHAR, description TEXT, date DATE) AS $$
BEGIN
    RETURN QUERY
    SELECT n.id, n.title, n.description, n.date
    FROM notification n
    WHERE n.user_id = p_user_id
    ORDER BY n.date DESC;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION get_content_activity(p_content_id INT)
RETURNS TABLE(answers_count INT, comments_count INT) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        (SELECT COUNT(*) FROM answer WHERE id_content = p_content_id) AS answers_count,
        (SELECT COUNT(*) FROM comment WHERE id_content = p_content_id) AS comments_count;
END;
$$ LANGUAGE plpgsql;


