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
