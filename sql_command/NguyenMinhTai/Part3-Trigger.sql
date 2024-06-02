CREATE TRIGGER insertusers
ON users
AFTER INSERT
AS
BEGIN
    DECLARE @UserID BIGINT;
    DECLARE @CurrentDateTime DATETIME;
    
    SELECT @UserID = user_id FROM inserted;
    SELECT @CurrentDateTime = GETDATE();
    
    INSERT INTO notiffication (notif_title, notif_content, notif_date)
    VALUES ('New User Added', CONCAT('User with ID ', @UserID, ' has been added.'), @CurrentDateTime);
END;
GO

CREATE TRIGGER insertproducts
ON books
AFTER INSERT
AS
BEGIN
    DECLARE @ProductID BIGINT;
    DECLARE @CurrentDateTime DATETIME;

    DECLARE insert_cursor CURSOR FOR
    SELECT product_id FROM inserted;
    OPEN insert_cursor;
    FETCH NEXT FROM insert_cursor INTO @ProductID;
    WHILE @@FETCH_STATUS = 0
    BEGIN
        SET @CurrentDateTime = GETDATE();
        INSERT INTO notiffication (notif_title, notif_content, notif_date)
        VALUES ('New Product Added', CONCAT('Product with ID ', @ProductID, ' has been added.'), @CurrentDateTime);
        FETCH NEXT FROM insert_cursor INTO @ProductID;
    END;
    CLOSE insert_cursor;
    DEALLOCATE insert_cursor;
END;
GO

CREATE TRIGGER insertothersproducts
ON others_products
AFTER INSERT
AS
BEGIN
    DECLARE @ProductID BIGINT;
    DECLARE @CurrentDateTime DATETIME;

    DECLARE insert_cursor CURSOR FOR
    SELECT product_id FROM inserted;
    OPEN insert_cursor;
    FETCH NEXT FROM insert_cursor INTO @ProductID;
    WHILE @@FETCH_STATUS = 0
    BEGIN
        SET @CurrentDateTime = GETDATE();
        INSERT INTO notiffication (notif_title, notif_content, notif_date)
        VALUES ('New Product Added', CONCAT('Product with ID ', @ProductID, ' has been added.'), @CurrentDateTime);
        FETCH NEXT FROM insert_cursor INTO @ProductID;
    END;
    CLOSE insert_cursor;
    DEALLOCATE insert_cursor;
END;
GO 

CREATE TRIGGER insertorderonl
ON orders_online
AFTER INSERT
AS
BEGIN
    DECLARE @OrderID BIGINT;
    DECLARE @CurrentDateTime DATETIME;

    DECLARE insert_cursor CURSOR FOR
    SELECT order_id FROM inserted;
    OPEN insert_cursor;
    FETCH NEXT FROM insert_cursor INTO @OrderID;
    WHILE @@FETCH_STATUS = 0
    BEGIN
        SET @CurrentDateTime = GETDATE();
        INSERT INTO notiffication (notif_title, notif_content, notif_date)
        VALUES ('New Order Added', CONCAT('Order with ID ', @OrderID, ' has been added.'), @CurrentDateTime);
        FETCH NEXT FROM insert_cursor INTO @OrderID;
    END;
    CLOSE insert_cursor;
    DEALLOCATE insert_cursor;
END;
GO 

CREATE TRIGGER insertorderoff
ON orders_online
AFTER INSERT
AS
BEGIN
    DECLARE @OrderID BIGINT;
    DECLARE @CurrentDateTime DATETIME;

    DECLARE insert_cursor CURSOR FOR
    SELECT order_id FROM inserted;
    OPEN insert_cursor;
    FETCH NEXT FROM insert_cursor INTO @OrderID;
    WHILE @@FETCH_STATUS = 0
    BEGIN
        SET @CurrentDateTime = GETDATE();
        INSERT INTO notiffication (notif_title, notif_content, notif_date)VALUES ('New Order Added', CONCAT('Order with ID ', @OrderID, ' has been added.'), @CurrentDateTime);
        FETCH NEXT FROM insert_cursor INTO @OrderID;
    END;
    CLOSE insert_cursor;
    DEALLOCATE insert_cursor;
END;
GO