USE [BookStore]
GO
/****** Object:  UserDefinedFunction [dbo].[FindBooks]    Script Date: 02/06/2024 4:53:15 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER FUNCTION [dbo].[FindBooks](@name NVARCHAR(50))
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