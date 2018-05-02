DELIMITER $$
CREATE PROCEDURE ADD_ITEM_TO_ORDER(
	IN TRANSACTIONID INT
,	IN ITEMID INT)
BEGIN
    DECLARE TOTALCOST FLOAT DEFAULT 0;
    
    START TRANSACTION; -- Begin a transaction
    INSERT INTO TRANSACTIONS_ITEM (TRANSACTION_ID, ITEM_ID) VALUES (TRANSACTIONID, ITEMID);
    IF ROW_COUNT() > 0 THEN -- ROW_COUNT() returns the number of rows inserted
        COMMIT; -- Finalize the transaction
	SELECT SUM(PRICE) INTO TOTALCOST FROM ITEM I, TRANSACTIONS T, TRANSACTIONS_ITEM TI 
    WHERE I._ID = TI.ITEM_ID AND T.TRANSACTIONS_ID = TI.TRANSACTION_ID AND TI.TRANSACTION_ID = TRANSACTIONID GROUP BY TRANSACTION_ID;
    UPDATE TRANSACTIONS SET TOTAL_PRICE = TOTALCOST WHERE TRANSACTIONS_ID = TRANSACTIONID;
    ELSE
        ROLLBACK; -- Revert all changes made before the transaction began
    END IF;
END$$
DELIMITER ;