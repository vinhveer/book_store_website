CREATE PROCEDURE [dbo].[InsertNewUser_customer]
    @full_name NVARCHAR(250),
    @date_of_birth DATE,
    @gender BIT,
    @email VARCHAR(255),
    @address NVARCHAR(255),
    @phone VARCHAR(15),
    @image_user NVARCHAR(MAX),
    @username VARCHAR(255),
    @password VARCHAR(255)
AS
BEGIN
    DECLARE @user_id BIGINT;

    -- Thêm người dùng vào bảng users
    INSERT INTO users (full_name, date_of_birth, gender, address, phone, email, image_user)
    VALUES (@full_name, @date_of_birth, @gender, @address, @phone, @email, @image_user);

    -- Lấy ID của người dùng vừa được thêm
    SET @user_id = SCOPE_IDENTITY();

    -- Thêm quyền cho người dùng vào bảng user_roles
    INSERT INTO user_roles (user_id, role_id)
    VALUES (@user_id, 1);

    DECLARE @user_role_id BIGINT;

    -- Lấy ID của quyền người dùng vừa được thêm
    SET @user_role_id = SCOPE_IDENTITY();

    -- Thêm tài khoản người dùng vào bảng user_accounts
    INSERT INTO user_accounts (username, password, user_role_id)
    VALUES (@username, @password, @user_role_id);
END;
