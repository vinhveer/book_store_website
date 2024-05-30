CREATE PROCEDURE [dbo].[UpdateProductAndBook]
    @product_id BIGINT,
    @book_name NVARCHAR(MAX),
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

    -- Update product information
    UPDATE products
    SET
        category_id = @category_id,
        product_price = @product_price,
        product_image = @product_image,
        product_quantity = @product_quantity,
        supplier_id = @supplier_id,
        product_status = @product_status
    WHERE product_id = @product_id;

    -- Update book information
    UPDATE books
    SET
        book_name = @book_name,
        book_category_id = @book_category_id,
        book_description = @book_description,
        book_language_id = @book_language_id,
        book_publication_year = @book_publication_year,
        book_packaging_size = @book_packaging_size,
        book_format = @book_format,
        book_ISBN = @book_ISBN,
        book_publisher_id = @book_publisher_id
    WHERE product_id = @product_id;

    -- Check if author exists, if not insert new author
    IF NOT EXISTS (SELECT 1 FROM author WHERE author_name = @author_name)
    BEGIN
		DELETE FROM book_author
        WHERE product_id = @product_id;

        INSERT INTO author (author_name) VALUES (@author_name);
    END

    -- Get the author ID
    DECLARE @author_id BIGINT = (SELECT author_id FROM author WHERE author_name = @author_name);

    -- Update book_author relationship
    IF NOT EXISTS (SELECT 1 FROM book_author WHERE author_id = @author_id AND product_id = @product_id)
    BEGIN
        INSERT INTO book_author (author_id, product_id) VALUES (@author_id, @product_id);
    END
    ELSE
    BEGIN
        UPDATE book_author
        SET author_id = @author_id
        WHERE product_id = @product_id;
    END

    COMMIT TRANSACTION;
END
