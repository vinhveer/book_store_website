-- Hàm thêm sản phẩm vào giỏ hàng
CREATE PROCEDURE AddToCart
@userId BIGINT,
@productId BIGINT,
@quantity INT
AS
BEGIN
    -- Kiểm tra số lượng sản phẩm có đủ không
    IF (SELECT product_quantity FROM products WHERE product_id = @productId) >= @quantity
    BEGIN
        -- Thêm sản phẩm vào giỏ hàng hoặc cập nhật số lượng nếu đã tồn tại
        IF EXISTS (SELECT * FROM carts WHERE user_id = @userId AND product_id = @productId)
        BEGIN
            UPDATE carts
            SET quantity = quantity + @quantity
            WHERE user_id = @userId AND product_id = @productId
        END
        ELSE
        BEGIN
            INSERT INTO carts (user_id, product_id, quantity, created_at, status)
            VALUES (@userId, @productId, @quantity, GETDATE(), 1)
        END
    END
    ELSE
    BEGIN
        -- Nếu không đủ số lượng, trả về thông báo lỗi
        THROW 50000, 'Số lượng sản phẩm không đủ.', 1
    END
END
GO

-- Hàm tạo đơn hàng trực tuyến
CREATE PROCEDURE PlaceOrderOnline
@userId BIGINT
AS
BEGIN
    DECLARE @orderId BIGINT
    DECLARE @totalAmount DECIMAL(20, 3)

    -- Tính tổng số tiền của giỏ hàng
    SELECT @totalAmount = SUM(p.product_price * c.quantity)
    FROM carts c
    INNER JOIN products p ON c.product_id = p.product_id
    WHERE c.user_id = @userId AND c.status = 1

    -- Tạo đơn hàng mới
    INSERT INTO orders_online (customer_id, order_date_on, total_amount_on, status_on, note_on)
    VALUES ((SELECT customer_id FROM customers WHERE user_id = @userId), GETDATE(), @totalAmount, 'Pending', NULL)

    -- Lấy ID của đơn hàng vừa tạo
    SET @orderId = SCOPE_IDENTITY()

    -- Chuyển các sản phẩm từ giỏ hàng sang chi tiết đơn hàng
    INSERT INTO order_details_on (order_id, product_id, quantity, discount)
    SELECT @orderId, product_id, quantity, 0
    FROM carts
    WHERE user_id = @userId AND status = 1

    -- Cập nhật trạng thái giỏ hàng
    UPDATE carts
    SET status = 0
    WHERE user_id = @userId AND status = 1

    -- Trả về ID của đơn hàng
    SELECT @orderId AS OrderId
END
GO

-- Hàm thanh toán đơn hàng trực tuyến
CREATE PROCEDURE PayOrderOnline
@orderId BIGINT,
@paymentMethod NVARCHAR(50)
AS
BEGIN
    DECLARE @totalAmount DECIMAL(20, 3)

    -- Lấy tổng số tiền của đơn hàng
    SELECT @totalAmount = total_amount_on FROM orders_online WHERE order_id = @orderId

    -- Tạo bản ghi thanh toán mới
    INSERT INTO payments_on (order_id, payment_date, payment_method, amount, status_pay)
    VALUES (@orderId, GETDATE(), @paymentMethod, @totalAmount, 'Completed')

    -- Cập nhật trạng thái đơn hàng
    UPDATE orders_online
    SET status_on = 'Completed'
    WHERE order_id = @orderId
END
GO
