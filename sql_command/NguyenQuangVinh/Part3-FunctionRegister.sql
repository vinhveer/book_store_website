USE [BookStore]
GO
/****** Object:  StoredProcedure [dbo].[RegisterUser]    Script Date: 02/06/2024 4:48:50 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[RegisterUser]
    @FullName NVARCHAR(250),
    @DateOfBirth DATE,
    @Gender BIT,
    @Phone VARCHAR(15),
    @Address NVARCHAR(255),
    @Email VARCHAR(255),
    @Username VARCHAR(255),
    @Password VARCHAR(255)
AS
BEGIN
    DECLARE @ResponseTable TABLE (
        register_status NVARCHAR(10),
        message NVARCHAR(255)
    );

    -- Validate FullName
    IF @FullName = '' OR @FullName IS NULL
    BEGIN
        INSERT INTO @ResponseTable (register_status, message)
        VALUES ('Failed', 'FullName cannot be empty.');
        SELECT * FROM @ResponseTable;
        RETURN;
    END

    -- Validate DateOfBirth
    IF @DateOfBirth IS NULL
    BEGIN
        INSERT INTO @ResponseTable (register_status, message)
        VALUES ('Failed', 'DateOfBirth cannot be empty and must be a valid date.');
        SELECT * FROM @ResponseTable;
        RETURN;
    END

    -- Validate Gender
    IF @Gender IS NULL
    BEGIN
        INSERT INTO @ResponseTable (register_status, message)
        VALUES ('Failed', 'Gender cannot be empty.');
        SELECT * FROM @ResponseTable;
        RETURN;
    END

    -- Validate Phone
    IF @Phone = '' OR @Phone IS NULL OR NOT (@Phone LIKE '0%' OR @Phone LIKE '+%')
    BEGIN
        INSERT INTO @ResponseTable (register_status, message)
        VALUES ('Failed', 'Phone must start with 0 or + and cannot be empty.');
        SELECT * FROM @ResponseTable;
        RETURN;
    END

    -- Validate Address
    IF @Address = '' OR @Address IS NULL
    BEGIN
        INSERT INTO @ResponseTable (register_status, message)
        VALUES ('Failed', 'Address cannot be empty.');
        SELECT * FROM @ResponseTable;
        RETURN;
    END

    -- Validate Email
    IF @Email = '' OR @Email IS NULL OR NOT @Email LIKE '%_@__%.__%'
    BEGIN
        INSERT INTO @ResponseTable (register_status, message)
        VALUES ('Failed', 'Email cannot be empty and must be in a valid format.');
        SELECT * FROM @ResponseTable;
        RETURN;
    END

    -- Validate Username
    IF @Username = '' OR @Username IS NULL OR @Username LIKE '%[^a-zA-Z0-9]%' OR @Username LIKE '% %'
    BEGIN
        INSERT INTO @ResponseTable (register_status, message)
        VALUES ('Failed', 'Username cannot contain spaces or special characters.');
        SELECT * FROM @ResponseTable;
        RETURN;
    END

    -- Validate Password
    IF LEN(@Password) <= 8
    BEGIN
        INSERT INTO @ResponseTable (register_status, message)
        VALUES ('Failed', 'Password must be longer than 8 characters.');
        SELECT * FROM @ResponseTable;
        RETURN;
    END

    -- Insert user information into users table
    DECLARE @UserID BIGINT;
    INSERT INTO users (full_name, date_of_birth, gender, address, phone, email)
    VALUES (@FullName, @DateOfBirth, @Gender, @Address, @Phone, @Email);

    SET @UserID = SCOPE_IDENTITY();

    -- Insert default role for the user into user_roles table
    DECLARE @UserRoleID BIGINT;
    DECLARE @DefaultRoleID BIGINT = 1; -- Assuming 1 is the default role ID, change as needed

    INSERT INTO user_roles (user_id, role_id)
    VALUES (@UserID, @DefaultRoleID);

    SET @UserRoleID = SCOPE_IDENTITY();

    -- Insert user account into user_accounts table
    INSERT INTO user_accounts (username, password, user_role_id)
    VALUES (@Username, @Password, @UserRoleID);

    INSERT INTO @ResponseTable (register_status, message)
    VALUES ('Success', 'User registered successfully.');
    
    SELECT * FROM @ResponseTable;
END