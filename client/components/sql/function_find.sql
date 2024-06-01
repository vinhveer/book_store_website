CREATE FUNCTION dbo.FindBooks(@name NVARCHAR(50))
RETURNS TABLE 
AS
RETURN(
    SELECT b.book_name,
           p.product_price,
           p.product_image
    FROM books b
    JOIN products p ON b.product_id = p.product_id
    WHERE LEFT(b.book_name, LEN(@name)) = @name
);

SELECT * FROM dbo.FindBooks('The');

CREATE FUNCTION dbo.FindOthersProduct(@name NVARCHAR(50))
RETURNS TABLE 
AS
RETURN(
    SELECT op.others_product_name, 
	       p.product_price,
	       p.product_image
    FROM others_products op
    INNER JOIN products p ON op.product_id = p.product_id
    WHERE LEFT(op.others_product_name, LEN(@name)) = @name
)