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
    END;

    USE [BookStore]
GO
/****** Object:  UserDefinedFunction [dbo].[LoginUser]    Script Date: 6/1/2024 12:52:31 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER FUNCTION [dbo].[LoginUser] (
    @username NVARCHAR(255),
    @password NVARCHAR(255)
)
RETURNS @result TABLE (
    login_status BIT,
    login_note NVARCHAR(255),
    user_id BIGINT,
    full_name NVARCHAR(250),
    role_name NVARCHAR(255),
    image_user NVARCHAR(MAX)
)
AS
BEGIN
    DECLARE @user_id BIGINT;
    DECLARE @stored_password NVARCHAR(255);
    DECLARE @full_name NVARCHAR(250);
    DECLARE @role_name NVARCHAR(255);
    DECLARE @image_user NVARCHAR(MAX);

    -- Kiểm tra xem username có tồn tại hay không
    SELECT 
        @user_id = ur.user_id,
        @stored_password = ua.password,
        @full_name = u.full_name,
        @role_name = r.role_name,
        @image_user = u.image_user
    FROM 
        user_accounts ua
        JOIN user_roles ur ON ua.user_role_id = ur.user_role_id
        JOIN users u ON ur.user_id = u.user_id
        JOIN roles r ON ur.role_id = r.role_id
    WHERE 
        ua.username = @username;

    -- Nếu username không tồn tại
    IF @user_id IS NULL
    BEGIN
        INSERT INTO @result (login_status, login_note, user_id, full_name, role_name, image_user)
        VALUES (0, N'Wrong username!', NULL, NULL, NULL, NULL);
        RETURN;
    END

    -- Nếu username tồn tại, kiểm tra password
    IF @stored_password = @password -- Lưu ý: nếu mật khẩu được mã hóa, bạn phải hash mật khẩu đầu vào trước khi so sánh
    BEGIN
        INSERT INTO @result (login_status, login_note, user_id, full_name, role_name, image_user)
        VALUES (1, N'success', @user_id, @full_name, @role_name, @image_user);
    END
    ELSE
    BEGIN
        INSERT INTO @result (login_status, login_note, user_id, full_name, role_name, image_user)
        VALUES (0, N'Wrong password!', NULL, NULL, NULL, NULL);
    END

    RETURN;
END;

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

CREATE PROCEDURE [dbo].[sp_InsertProductAndBook]
    @product_name NVARCHAR(MAX),
    @category_id BIGINT,
    @product_price DECIMAL(20, 3),
    @product_image NVARCHAR(MAX),
    @product_quantity INT,
    @supplier_id BIGINT,
    @product_status NVARCHAR(200),
    @book_category_id BIGINT,
    @book_description NVARCHAR(MAX),
    @book_language_id BIGINT,
    @book_publication_year INT,
    @book_packaging_size VARCHAR(50),
    @book_format VARCHAR(50),
    @book_ISBN VARCHAR(50),
    @book_publisher_id BIGINT,
    @author_name NVARCHAR(255)
AS
BEGIN
    BEGIN TRANSACTION;

    -- Insert product
    INSERT INTO products (category_id, product_price, product_image, product_quantity, supplier_id, product_status)
    VALUES (@category_id, @product_price, @product_image, @product_quantity, @supplier_id, @product_status);

    -- Get the inserted product ID
    DECLARE @product_id BIGINT = SCOPE_IDENTITY();

    -- Insert book
    INSERT INTO books (product_id, book_name, book_category_id, book_description, book_language_id, book_publication_year, book_packaging_size, book_format, book_ISBN, book_publisher_id)
    VALUES (@product_id, @product_name, @book_category_id, @book_description, @book_language_id, @book_publication_year, @book_packaging_size, @book_format, @book_ISBN, @book_publisher_id);

    -- Insert author if not exists
    IF NOT EXISTS (SELECT 1 FROM author WHERE author_name = @author_name)
    BEGIN
        INSERT INTO author (author_name) VALUES (@author_name);
    END

    -- Get the inserted author ID
    DECLARE @author_id BIGINT = (SELECT author_id FROM author WHERE author_name = @author_name);

    -- Insert book_author
    INSERT INTO book_author (author_id, product_id) VALUES (@author_id, @product_id);

    COMMIT TRANSACTION;

    -- Return the new product ID
    SELECT @product_id AS product_id;
END

CREATE PROCEDURE [dbo].[sp_InsertProductAndOtherProduct]
    @category_id BIGINT,
    @product_price DECIMAL(20, 3),
    @product_image NVARCHAR(MAX),
    @product_quantity INT,
    @supplier_id BIGINT,
    @product_status NVARCHAR(200),
    @others_product_name NVARCHAR(MAX),
    @others_product_description NVARCHAR(MAX),
    @others_product_brand_id BIGINT,
    @others_product_color NVARCHAR(50),
    @others_product_material NVARCHAR(MAX),
    @others_product_weight DECIMAL(20, 2),
    @others_product_size NVARCHAR(200)
AS
BEGIN
        -- Insert into the products table
        INSERT INTO products (category_id, product_price, product_image, product_quantity, supplier_id, product_status)
        VALUES (@category_id, @product_price, @product_image, @product_quantity, @supplier_id, @product_status);

        -- Get the newly inserted product_id
        DECLARE @product_id BIGINT;
        SET @product_id = SCOPE_IDENTITY();

        -- Insert into the others_products table
        INSERT INTO others_products (product_id, others_product_name, others_product_description, others_product_brand_id, others_product_color, others_product_material, others_product_weight, others_product_size)
        VALUES (@product_id, @others_product_name, @others_product_description, @others_product_brand_id, @others_product_color, @others_product_material, @others_product_weight, @others_product_size);

END
