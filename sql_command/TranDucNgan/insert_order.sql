-- Lệnh SQL để thêm sản phẩm vào chi tiết đơn hàng trực tuyến
INSERT INTO order_details_on (order_id, product_id, quantity, discount)
VALUES (:order_id, :product_id, :quantity, :discount);

-- Lệnh SQL để thêm sản phẩm vào chi tiết đơn hàng ngoại tuyến
INSERT INTO order_details_off (order_id, product_id, quantity, discount)
VALUES (:order_id, :product_id, :quantity, :discount);