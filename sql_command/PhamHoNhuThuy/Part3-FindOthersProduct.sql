USE [BookStore]
GO
/****** Object:  UserDefinedFunction [dbo].[FindOthersProduct]    Script Date: 02/06/2024 4:53:33 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER FUNCTION [dbo].[FindOthersProduct](@name NVARCHAR(50))
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