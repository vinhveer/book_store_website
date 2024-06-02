CREATE PROCEDURE [dbo].[sp_EditOtherProduct]
    @product_id BIGINT,
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
    -- Kiểm tra xem sản phẩm tồn tại không
    IF EXISTS (SELECT 1 FROM products WHERE product_id = @product_id)
    BEGIN
        -- Cập nhật thông tin sản phẩm trong bảng products
        UPDATE products
        SET category_id = @category_id,
            product_price = @product_price,
            product_image = @product_image,
            product_quantity = @product_quantity,
            supplier_id = @supplier_id,
            product_status = @product_status
        WHERE product_id = @product_id;

        -- Cập nhật thông tin sản phẩm khác trong bảng others_products
        UPDATE others_products
        SET others_product_name = @others_product_name,
            others_product_description = @others_product_description,
            others_product_brand_id = @others_product_brand_id,
            others_product_color = @others_product_color,
            others_product_material = @others_product_material,
            others_product_weight = @others_product_weight,
            others_product_size = @others_product_size
        WHERE product_id = @product_id;

        -- Trả về kết quả thành công
        SELECT 'Other Product updated successfully.' AS Result;
    END
    ELSE
    BEGIN
        -- Trả về thông báo lỗi nếu sản phẩm không tồn tại
        SELECT 'Product not found.' AS Result;
    END
END
