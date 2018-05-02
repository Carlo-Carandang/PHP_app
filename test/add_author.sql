DELIMITER $$
CREATE PROCEDURE ADD_AUTHOR(
	IN lname VARCHAR(30)
,	IN fname VARCHAR(30)
,	IN email VARCHAR(50)
,	OUT AUTHOR_ID INT)
BEGIN
    START TRANSACTION; -- Begin a transaction
    INSERT INTO AUTHOR (lname, fname, email) VALUES (lname, fname, email);
    IF ROW_COUNT() > 0 THEN -- ROW_COUNT() returns the number of rows inserted
        COMMIT; -- Finalize the transaction
	SELECT LAST_INSERT_ID() INTO AUTHOR_ID;
    ELSE
        ROLLBACK; -- Revert all changes made before the transaction began
    END IF;
END$$
DELIMITER ;


