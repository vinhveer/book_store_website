USE [BookStore]
GO
/****** Object:  UserDefinedFunction [dbo].[LoginUser]    Script Date: 02/06/2024 4:49:53 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER FUNCTION [dbo].[LoginUser] (
    @username VARCHAR(255),
    @password VARCHAR(255)
)
RETURNS @result TABLE (
    login_status BIT,
    login_note NVARCHAR(255),
    user_id BIGINT,
    full_name NVARCHAR(250)
)
AS
BEGIN
    DECLARE @user_id BIGINT;
    DECLARE @stored_password VARCHAR(255);
    DECLARE @full_name NVARCHAR(250);

    -- Kiểm tra xem username có tồn tại hay không
    SELECT 
        @user_id = ur.user_id,
        @stored_password = ua.password,
        @full_name = u.full_name
    FROM 
        user_accounts ua
        JOIN user_roles ur ON ua.user_role_id = ur.user_role_id
        JOIN users u ON ur.user_id = u.user_id
    WHERE 
        ua.username = @username;

    -- Nếu username không tồn tại
    IF @user_id IS NULL
    BEGIN
        INSERT INTO @result (login_status, login_note, user_id, full_name)
        VALUES (0, 'Wrong username!', NULL, NULL);
        RETURN;
    END

    -- Nếu username tồn tại, kiểm tra password
    IF @stored_password = @password
    BEGIN
        INSERT INTO @result (login_status, login_note, user_id, full_name)
        VALUES (1, 'Login successfully!', @user_id, @full_name);
    END
    ELSE
    BEGIN
        INSERT INTO @result (login_status, login_note, user_id, full_name)
        VALUES (0, 'Wrong password!', NULL, NULL);
    END

    RETURN;
END;
