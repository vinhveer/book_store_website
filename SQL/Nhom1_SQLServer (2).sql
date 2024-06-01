CREATE DATABASE BookStore;
GO

USE BookStore;
GO


CREATE TABLE users (
    user_id BIGINT IDENTITY(1,1) PRIMARY KEY, -- ID duy nhất cho mỗi người dùng
    full_name NVARCHAR(250) NOT NULL,
    date_of_birth DATE NOT NULL, -- Ngày sinh
    gender BIT NOT NULL, -- Giới tính (0: Nữ, 1: Nam)
    address NVARCHAR(255) NOT NULL, -- Địa chỉ
    phone VARCHAR(15) NOT NULL, -- Số điện thoại
    email VARCHAR(255) NOT NULL, -- Địa chỉ email
    image_user NVARCHAR(MAX) -- Tên name ảnh đại diện
);
GO

CREATE TABLE roles (
    role_id BIGINT IDENTITY(1,1) PRIMARY KEY, -- ID duy nhất cho mỗi vai trò
    role_name NVARCHAR(255) NOT NULL -- Tên của vai trò
);
GO

CREATE TABLE user_roles (
    user_role_id BIGINT IDENTITY(1,1) PRIMARY KEY, -- ID duy nhất cho mỗi quyền của người dùng
    user_id BIGINT NOT NULL, -- ID của người dùng
    role_id BIGINT NOT NULL, -- ID của vai trò
    FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles (role_id) ON DELETE CASCADE ON UPDATE CASCADE
);
GO

CREATE TABLE user_accounts (
    account_id BIGINT IDENTITY(1,1) PRIMARY KEY, -- ID duy nhất cho mỗi tài khoản người dùng
    username VARCHAR(255) NOT NULL, -- Tên đăng nhập
    password VARCHAR(255) NOT NULL, -- Mật khẩu
    user_role_id BIGINT NOT NULL, -- ID của quyền người dùng
    FOREIGN KEY (user_role_id) REFERENCES user_roles (user_role_id) ON DELETE CASCADE ON UPDATE CASCADE
);
GO


CREATE TABLE product_categories (
    category_id BIGINT IDENTITY(1,1) PRIMARY KEY, -- ID duy nhất cho mỗi danh mục sản phẩm
    category_name NVARCHAR(255) NOT NULL -- Tên của danh mục sản phẩm
);
GO


CREATE TABLE suppliers (
    supplier_id BIGINT IDENTITY(1,1) PRIMARY KEY, -- ID duy nhất cho mỗi nhà cung cấp
    supplier_name NVARCHAR(MAX) NOT NULL, -- Tên nhà cung cấp
    supplier_origin NVARCHAR(255) NOT NULL -- Nguồn gốc của nhà cung cấp
);
GO


CREATE TABLE products (
    product_id BIGINT IDENTITY(1,1) PRIMARY KEY, -- ID duy nhất cho mỗi sản phẩm
    category_id BIGINT NOT NULL, -- ID của danh mục sản phẩm
    product_price DECIMAL(20, 3) NOT NULL, -- Giá của sản phẩm
    product_image NVARCHAR(MAX) NOT NULL, -- Đường dẫn ảnh của sản phẩm
    product_quantity INT NOT NULL, -- Số lượng tồn kho của sản phẩm
    supplier_id BIGINT NOT NULL, -- ID của nhà cung cấp
    product_status NVARCHAR(200) NOT NULL,
    FOREIGN KEY (category_id) REFERENCES product_categories (category_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (supplier_id) REFERENCES suppliers (supplier_id) ON DELETE CASCADE ON UPDATE CASCADE
);
GO


CREATE TABLE book_categories (
    book_category_id BIGINT IDENTITY(1,1) PRIMARY KEY, -- ID duy nhất cho mỗi danh mục sách
    book_category_name NVARCHAR(MAX) NOT NULL, -- Tên của danh mục sách
    image_category NVARCHAR(MAX)
);
GO


CREATE TABLE book_publishers (
    book_publisher_id BIGINT IDENTITY(1,1) PRIMARY KEY, -- ID duy nhất cho mỗi nhà xuất bản
    book_publisher_name NVARCHAR(MAX) NOT NULL -- Tên nhà xuất bản
);
GO


CREATE TABLE book_languages (
    book_language_id BIGINT IDENTITY(1,1) PRIMARY KEY, -- ID duy nhất cho mỗi ngôn ngữ sách
    book_language NVARCHAR(MAX) NOT NULL -- Ngôn ngữ của sách
);
GO


CREATE TABLE author (
    author_id BIGINT IDENTITY(1,1) PRIMARY KEY,
    author_name NVARCHAR (255) NOT NULL
);
GO


CREATE TABLE books (
    product_id BIGINT PRIMARY KEY, -- ID duy nhất cho mỗi sách
    book_name NVARCHAR(MAX) NOT NULL, -- Tên sách
    book_category_id BIGINT NOT NULL, -- ID của danh mục sách
    book_description NVARCHAR(MAX) NULL, -- Mô tả sách
    book_language_id BIGINT NOT NULL, -- ID của ngôn ngữ sách
    book_publication_year SMALLINT NOT NULL, -- Năm xuất bản
    book_packaging_size VARCHAR(50) NOT NULL, -- Kích thước đóng gói sách
    book_format VARCHAR(50) NOT NULL, -- Định dạng sách
    book_ISBN VARCHAR(50) NOT NULL,
    book_publisher_id BIGINT NOT NULL, -- ID của nhà xuất bản
    FOREIGN KEY (book_category_id) REFERENCES book_categories (book_category_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (book_language_id) REFERENCES book_languages (book_language_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (book_publisher_id) REFERENCES book_publishers (book_publisher_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products (product_id) ON DELETE CASCADE ON UPDATE CASCADE
);
GO


CREATE TABLE book_author (
    author_id BIGINT NOT NULL,
    product_id BIGINT NOT NULL,
    PRIMARY KEY (author_id,product_id),
    FOREIGN KEY (author_id) REFERENCES author(author_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (product_id) REFERENCES books(product_id) ON DELETE CASCADE ON UPDATE CASCADE,
);
GO


CREATE TABLE brands (
    brand_id BIGINT IDENTITY(1,1) PRIMARY KEY, -- ID duy nhất cho mỗi thương hiệu
    brand_name NVARCHAR(MAX) NOT NULL, -- Tên thương hiệu
    brand_origin NVARCHAR(MAX) NOT NULL, -- Xuất xứ thương hiệu
    brand_image NVARCHAR(MAX) NOT NULL,
);
GO


CREATE TABLE others_products (
    product_id BIGINT PRIMARY KEY, -- ID duy nhất cho mỗi sản phẩm khác
    others_product_name NVARCHAR(MAX) NOT NULL, -- Tên sản phẩm khác
    others_product_description NVARCHAR(MAX) NULL, -- Mô tả sản phẩm khác
    others_product_brand_id BIGINT NOT NULL, -- ID của thương hiệu sản phẩm khác
    others_product_color NVARCHAR(50) NOT NULL, -- Màu sắc sản phẩm khác
    others_product_material NVARCHAR(MAX) NOT NULL, -- Chất liệu sản phẩm khác
    others_product_weight DECIMAL(20,2) NOT NULL, -- Trọng lượng sản phẩm khác
    others_product_size VARCHAR(200) NOT NULL,
    FOREIGN KEY (others_product_brand_id) REFERENCES brands (brand_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products (product_id) ON DELETE CASCADE ON UPDATE CASCADE
);
GO


CREATE TABLE orders_offline (
    order_id BIGINT IDENTITY(1,1) PRIMARY KEY, -- ID duy nhất cho mỗi đơn đặt hàng
    order_date_off DATE NOT NULL, -- Ngày đặt hàng
    employee_id BIGINT,
    total_amount_off DECIMAL(20, 3) NOT NULL, -- Tổng số tiền
    note_off NVARCHAR(255),
    FOREIGN KEY (employee_id) REFERENCES employees (employee_id)
);
GO


CREATE TABLE customers (
    customer_id BIGINT IDENTITY(1,1) PRIMARY KEY, -- ID duy nhất cho mỗi khách hàng
    user_id BIGINT NOT NULL, -- ID của người dùng
    FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE ON UPDATE CASCADE
);
GO


CREATE TABLE orders_online (
    order_id BIGINT IDENTITY(1,1) PRIMARY KEY, -- ID duy nhất cho mỗi đơn đặt hàng
    customer_id BIGINT NOT NULL, -- ID của người dùng đặt hàng
    order_date_on DATE NOT NULL, -- Ngày đặt hàng
    total_amount_on DECIMAL(20, 3) NOT NULL, -- Tổng số tiền
    status_on NVARCHAR(20) CHECK (status_on IN ('Pending','Confirmed', 'Completed','Deleted')), -- Trạng thái đơn đặt hàng
    note_on NVARCHAR(255),
    FOREIGN KEY (customer_id) REFERENCES customers (customer_id) ON DELETE CASCADE ON UPDATE CASCADE
);
GO


CREATE TABLE shipper(
    order_id BIGINT PRIMARY KEY,
    employee_id BIGINT,
    delivery_status NVARCHAR(20) CHECK (delivery_status IN ('Failed', 'Delivered', 'In Transit', 'Scheduled')),
    FOREIGN KEY (employee_id) REFERENCES employees (employee_id),
    FOREIGN KEY (order_id) REFERENCES orders_online ( order_id) ON DELETE CASCADE ON UPDATE CASCADE
);
GO


CREATE TABLE order_details_off (
    order_id BIGINT NOT NULL, -- ID duy nhất cho mỗi chi tiết đơn đặt hàng
    product_id BIGINT NOT NULL, -- ID của sản phẩm
    quantity INT NOT NULL, -- Số lượng sản phẩm
    discount DECIMAL(20, 3), -- Giảm giá
    FOREIGN KEY (order_id) REFERENCES orders_offline (order_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products (product_id) ON DELETE CASCADE ON UPDATE CASCADE
);
GO


CREATE TABLE order_details_on (
    order_id BIGINT NOT NULL, -- ID duy nhất cho mỗi chi tiết đơn đặt hàng
    product_id BIGINT NOT NULL, -- ID của sản phẩm
    quantity INT NOT NULL, -- Số lượng sản phẩm
    discount DECIMAL(20, 3), -- Giảm giá
    FOREIGN KEY (order_id) REFERENCES orders_online (order_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products (product_id) ON DELETE CASCADE ON UPDATE CASCADE
);
GO


CREATE TABLE payments_off(
    payment_id BIGINT IDENTITY(1,1) PRIMARY KEY, -- ID duy nhất cho mỗi thanh toán
    order_id BIGINT NOT NULL,
    payment_date DATE NOT NULL, -- Ngày thanh toán
    payment_method NVARCHAR(50) NOT NULL, -- Phương thức thanh toán
    amount DECIMAL(20, 3) NOT NULL, -- Số tiền thanh toán
    status_pay NVARCHAR(20) NOT NULL, -- Trạng thái thanh toán
    FOREIGN KEY (order_id) REFERENCES orders_offline (order_id) ON DELETE CASCADE ON UPDATE CASCADE
);
GO


CREATE TABLE payments_on(
    payment_id BIGINT IDENTITY(1,1) PRIMARY KEY, -- ID duy nhất cho mỗi thanh toán
    order_id BIGINT NOT NULL,
    payment_date DATE NOT NULL, -- Ngày thanh toán
    payment_method NVARCHAR(50) NOT NULL, -- Phương thức thanh toán
    amount DECIMAL(20, 3) NOT NULL, -- Số tiền thanh toán
    status_pay NVARCHAR(20) NOT NULL, -- Trạng thái thanh toán
    FOREIGN KEY (order_id) REFERENCES orders_online (order_id) ON DELETE CASCADE ON UPDATE CASCADE
);
GO


CREATE TABLE carts
(
	user_id BIGINT NOT NULL,
	product_id BIGINT NOT NULL,
	quantity INT NOT NULL,
	created_at DATETIME NOT NULL,
	status BIT,
    PRIMARY KEY (user_id,product_id),
	FOREIGN KEY (product_id) REFERENCES products (product_id),
	FOREIGN KEY (user_id) REFERENCES users(user_id)
);
Go
