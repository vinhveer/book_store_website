USE [BookStore]
GO
/****** Object:  UserDefinedFunction [dbo].[GetProductDetails]    Script Date: 02/06/2024 4:53:53 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER FUNCTION [dbo].[GetProductDetails] (@ProductID BIGINT)
RETURNS TABLE
AS
RETURN
(
    SELECT 
        CASE 
            WHEN b.product_id IS NOT NULL THEN b.book_name
            WHEN o.product_id IS NOT NULL THEN o.others_product_name
        END AS [Product Name],
        p.product_price AS [Product Price],
        p.product_image AS [Product Image]
    FROM 
        products p
    LEFT JOIN 
        books b ON p.product_id = b.product_id
    LEFT JOIN 
        others_products o ON p.product_id = o.product_id
    WHERE 
        p.product_id = @ProductID
);