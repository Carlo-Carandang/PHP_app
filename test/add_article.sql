DELIMITER $$
CREATE PROCEDURE ADD_ARTICLE(
	IN TITLE VARCHAR(200)
,	IN PAGES VARCHAR(30)
,	OUT ARTICLE_ID INT)
BEGIN
    START TRANSACTION; -- Begin a transaction
    INSERT INTO ARTICLE (TITLE, PAGES) VALUES (TITLE, PAGES);
    IF ROW_COUNT() > 0 THEN -- ROW_COUNT() returns the number of rows inserted
        COMMIT; -- Finalize the transaction
	SELECT LAST_INSERT_ID() INTO ARTICLE_ID;
    ELSE
        ROLLBACK; -- Revert all changes made before the transaction began
    END IF;
END$$
DELIMITER ;