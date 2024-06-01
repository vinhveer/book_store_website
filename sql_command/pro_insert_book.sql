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
