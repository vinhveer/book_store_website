USE [BookStore]
GO
/****** Object:  UserDefinedFunction [dbo].[LoginUser]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE FUNCTION [dbo].[LoginUser] (
    @username NVARCHAR(255),
    @password NVARCHAR(255)
)
RETURNS @result TABLE (
    login_status BIT,
    login_note NVARCHAR(255),
    user_id BIGINT,
    full_name NVARCHAR(250),
    role_name NVARCHAR(255),
    image_user NVARCHAR(MAX)
)
AS
BEGIN
    DECLARE @user_id BIGINT;
    DECLARE @stored_password NVARCHAR(255);
    DECLARE @full_name NVARCHAR(250);
    DECLARE @role_name NVARCHAR(255);
    DECLARE @image_user NVARCHAR(MAX);

    -- Kiểm tra xem username có tồn tại hay không
    SELECT
        @user_id = ur.user_id,
        @stored_password = ua.password,
        @full_name = u.full_name,
        @role_name = r.role_name,
        @image_user = u.image_user
    FROM
        user_accounts ua
        JOIN user_roles ur ON ua.user_role_id = ur.user_role_id
        JOIN users u ON ur.user_id = u.user_id
        JOIN roles r ON ur.role_id = r.role_id
    WHERE
        ua.username = @username;

    -- Nếu username không tồn tại
    IF @user_id IS NULL
    BEGIN
        INSERT INTO @result (login_status, login_note, user_id, full_name, role_name, image_user)
        VALUES (0, N'Wrong username!', NULL, NULL, NULL, NULL);
        RETURN;
    END

    -- Nếu username tồn tại, kiểm tra password
    IF @stored_password = @password -- Lưu ý: nếu mật khẩu được mã hóa, bạn phải hash mật khẩu đầu vào trước khi so sánh
    BEGIN
        INSERT INTO @result (login_status, login_note, user_id, full_name, role_name, image_user)
        VALUES (1, N'success', @user_id, @full_name, @role_name, @image_user);
    END
    ELSE
    BEGIN
        INSERT INTO @result (login_status, login_note, user_id, full_name, role_name, image_user)
        VALUES (0, N'Wrong password!', NULL, NULL, NULL, NULL);
    END

    RETURN;
END;
GO
/****** Object:  Table [dbo].[author]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[author](
	[author_id] [bigint] IDENTITY(1,1) NOT NULL,
	[author_name] [nvarchar](255) NOT NULL,
PRIMARY KEY CLUSTERED
(
	[author_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[book_author]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[book_author](
	[author_id] [bigint] NOT NULL,
	[product_id] [bigint] NOT NULL,
PRIMARY KEY CLUSTERED
(
	[author_id] ASC,
	[product_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[book_categories]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[book_categories](
	[book_category_id] [bigint] IDENTITY(1,1) NOT NULL,
	[book_category_name] [nvarchar](max) NOT NULL,
	[image_category] [nvarchar](max) NULL,
PRIMARY KEY CLUSTERED
(
	[book_category_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[book_languages]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[book_languages](
	[book_language_id] [bigint] IDENTITY(1,1) NOT NULL,
	[book_language] [nvarchar](max) NOT NULL,
PRIMARY KEY CLUSTERED
(
	[book_language_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[book_publishers]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[book_publishers](
	[book_publisher_id] [bigint] IDENTITY(1,1) NOT NULL,
	[book_publisher_name] [nvarchar](max) NOT NULL,
PRIMARY KEY CLUSTERED
(
	[book_publisher_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[books]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[books](
	[product_id] [bigint] NOT NULL,
	[book_name] [nvarchar](max) NOT NULL,
	[book_category_id] [bigint] NOT NULL,
	[book_description] [nvarchar](max) NULL,
	[book_language_id] [bigint] NOT NULL,
	[book_publication_year] [smallint] NOT NULL,
	[book_packaging_size] [varchar](50) NOT NULL,
	[book_format] [varchar](50) NOT NULL,
	[book_ISBN] [varchar](50) NOT NULL,
	[book_publisher_id] [bigint] NOT NULL,
PRIMARY KEY CLUSTERED
(
	[product_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[brands]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[brands](
	[brand_id] [bigint] IDENTITY(1,1) NOT NULL,
	[brand_name] [nvarchar](max) NOT NULL,
	[brand_origin] [nvarchar](max) NOT NULL,
	[brand_image] [nvarchar](max) NOT NULL,
PRIMARY KEY CLUSTERED
(
	[brand_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[carts]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[carts](
	[user_id] [bigint] NOT NULL,
	[product_id] [bigint] NOT NULL,
	[quantity] [int] NOT NULL,
	[created_at] [datetime] NOT NULL,
	[status] [bit] NULL,
PRIMARY KEY CLUSTERED
(
	[user_id] ASC,
	[product_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[customers]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[customers](
	[customer_id] [bigint] IDENTITY(1,1) NOT NULL,
	[user_id] [bigint] NOT NULL,
PRIMARY KEY CLUSTERED
(
	[customer_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[education_level]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[education_level](
	[education_level_id] [int] IDENTITY(1,1) NOT NULL,
	[education_level_name] [nvarchar](50) NOT NULL,
PRIMARY KEY CLUSTERED
(
	[education_level_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[employee_attendance]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[employee_attendance](
	[employee_attendance_id] [bigint] IDENTITY(1,1) NOT NULL,
	[employee_id] [bigint] NOT NULL,
	[attendance_date] [date] NOT NULL,
PRIMARY KEY CLUSTERED
(
	[employee_attendance_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[employee_salary]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[employee_salary](
	[employee_salary_id] [bigint] IDENTITY(1,1) NOT NULL,
	[employee_id] [bigint] NOT NULL,
	[salary_base] [decimal](20, 3) NOT NULL,
	[salary_coefficient_id] [bigint] NOT NULL,
	[salary_date] [date] NOT NULL,
PRIMARY KEY CLUSTERED
(
	[employee_salary_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[employees]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[employees](
	[employee_id] [bigint] IDENTITY(1,1) NOT NULL,
	[user_id] [bigint] NOT NULL,
	[education_level_id] [int] NOT NULL,
	[work_date] [date] NOT NULL,
PRIMARY KEY CLUSTERED
(
	[employee_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[list_item]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[list_item](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[title] [varchar](255) NOT NULL,
	[type_item] [varchar](1) NOT NULL,
	[cmd_top5] [text] NOT NULL,
	[cmd_top30] [text] NOT NULL,
PRIMARY KEY CLUSTERED
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[notiffication]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[notiffication](
	[notif_id] [bigint] IDENTITY(1,1) NOT NULL,
	[notif_title] [nvarchar](max) NOT NULL,
	[notif_content] [nvarchar](max) NOT NULL,
	[notif_date] [datetime] NOT NULL,
PRIMARY KEY CLUSTERED
(
	[notif_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[order_details_off]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[order_details_off](
	[order_id] [bigint] NOT NULL,
	[product_id] [bigint] NOT NULL,
	[quantity] [int] NOT NULL,
	[discount] [decimal](20, 3) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[order_details_on]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[order_details_on](
	[order_id] [bigint] NOT NULL,
	[product_id] [bigint] NOT NULL,
	[quantity] [int] NOT NULL,
	[discount] [decimal](20, 3) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[orders_offline]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[orders_offline](
	[order_id] [bigint] IDENTITY(1,1) NOT NULL,
	[order_date_off] [date] NOT NULL,
	[employee_id] [bigint] NULL,
	[total_amount_off] [decimal](20, 3) NOT NULL,
	[note_off] [nvarchar](255) NULL,
PRIMARY KEY CLUSTERED
(
	[order_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[orders_online]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[orders_online](
	[order_id] [bigint] IDENTITY(1,1) NOT NULL,
	[customer_id] [bigint] NOT NULL,
	[order_date_on] [date] NOT NULL,
	[total_amount_on] [decimal](20, 3) NOT NULL,
	[status_on] [nvarchar](20) NULL,
	[note_on] [nvarchar](255) NULL,
PRIMARY KEY CLUSTERED
(
	[order_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[others_products]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[others_products](
	[product_id] [bigint] NOT NULL,
	[others_product_name] [nvarchar](max) NOT NULL,
	[others_product_description] [nvarchar](max) NULL,
	[others_product_brand_id] [bigint] NOT NULL,
	[others_product_color] [nvarchar](50) NOT NULL,
	[others_product_material] [nvarchar](max) NOT NULL,
	[others_product_weight] [decimal](20, 2) NOT NULL,
	[others_product_size] [varchar](200) NOT NULL,
PRIMARY KEY CLUSTERED
(
	[product_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[payments_off]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[payments_off](
	[payment_id] [bigint] IDENTITY(1,1) NOT NULL,
	[order_id] [bigint] NOT NULL,
	[payment_date] [date] NOT NULL,
	[payment_method] [nvarchar](50) NOT NULL,
	[amount] [decimal](20, 3) NOT NULL,
	[status_pay] [nvarchar](20) NOT NULL,
PRIMARY KEY CLUSTERED
(
	[payment_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[payments_on]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[payments_on](
	[payment_id] [bigint] IDENTITY(1,1) NOT NULL,
	[order_id] [bigint] NOT NULL,
	[payment_date] [date] NOT NULL,
	[payment_method] [nvarchar](50) NOT NULL,
	[amount] [decimal](20, 3) NOT NULL,
	[status_pay] [nvarchar](20) NOT NULL,
PRIMARY KEY CLUSTERED
(
	[payment_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[product_categories]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[product_categories](
	[category_id] [bigint] IDENTITY(1,1) NOT NULL,
	[category_name] [nvarchar](255) NOT NULL,
PRIMARY KEY CLUSTERED
(
	[category_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[products]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[products](
	[product_id] [bigint] IDENTITY(1,1) NOT NULL,
	[category_id] [bigint] NOT NULL,
	[product_price] [decimal](20, 3) NOT NULL,
	[product_image] [nvarchar](max) NOT NULL,
	[product_quantity] [int] NOT NULL,
	[supplier_id] [bigint] NOT NULL,
	[product_status] [nvarchar](200) NOT NULL,
PRIMARY KEY CLUSTERED
(
	[product_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[roles]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[roles](
	[role_id] [bigint] IDENTITY(1,1) NOT NULL,
	[role_name] [nvarchar](255) NOT NULL,
PRIMARY KEY CLUSTERED
(
	[role_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[salary_coefficient]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[salary_coefficient](
	[salary_coefficient_id] [bigint] IDENTITY(1,1) NOT NULL,
	[salary_coefficient_value] [decimal](20, 3) NOT NULL,
	[update_coefficient_date] [datetime] NOT NULL,
	[role_id] [bigint] NOT NULL,
PRIMARY KEY CLUSTERED
(
	[salary_coefficient_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[shipper]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[shipper](
	[order_id] [bigint] NOT NULL,
	[employee_id] [bigint] NULL,
	[delivery_status] [nvarchar](20) NULL,
PRIMARY KEY CLUSTERED
(
	[order_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[stock_in]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[stock_in](
	[stock_in_id] [bigint] IDENTITY(1,1) NOT NULL,
	[inflow_date] [date] NOT NULL,
	[employee_id] [bigint] NOT NULL,
	[tolal_amount_in] [decimal](20, 3) NULL,
	[note_in] [nvarchar](max) NULL,
PRIMARY KEY CLUSTERED
(
	[stock_in_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[stock_in_details]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[stock_in_details](
	[stock_in_id] [bigint] NOT NULL,
	[product_id] [bigint] NOT NULL,
	[quantity_in] [int] NOT NULL,
	[unit_price_in] [decimal](20, 3) NOT NULL,
PRIMARY KEY CLUSTERED
(
	[stock_in_id] ASC,
	[product_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[suppliers]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[suppliers](
	[supplier_id] [bigint] IDENTITY(1,1) NOT NULL,
	[supplier_name] [nvarchar](max) NOT NULL,
	[supplier_origin] [nvarchar](255) NOT NULL,
PRIMARY KEY CLUSTERED
(
	[supplier_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[user_accounts]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[user_accounts](
	[account_id] [bigint] IDENTITY(1,1) NOT NULL,
	[username] [varchar](255) NOT NULL,
	[password] [varchar](255) NOT NULL,
	[user_role_id] [bigint] NOT NULL,
PRIMARY KEY CLUSTERED
(
	[account_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[user_roles]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[user_roles](
	[user_role_id] [bigint] IDENTITY(1,1) NOT NULL,
	[user_id] [bigint] NOT NULL,
	[role_id] [bigint] NOT NULL,
PRIMARY KEY CLUSTERED
(
	[user_role_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[users]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[users](
	[user_id] [bigint] IDENTITY(1,1) NOT NULL,
	[full_name] [nvarchar](250) NOT NULL,
	[date_of_birth] [date] NOT NULL,
	[gender] [bit] NOT NULL,
	[address] [nvarchar](255) NOT NULL,
	[phone] [varchar](15) NOT NULL,
	[email] [varchar](255) NOT NULL,
	[image_user] [nvarchar](max) NULL,
PRIMARY KEY CLUSTERED
(
	[user_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
ALTER TABLE [dbo].[notiffication] ADD  DEFAULT (getdate()) FOR [notif_date]
GO
ALTER TABLE [dbo].[book_author]  WITH CHECK ADD FOREIGN KEY([author_id])
REFERENCES [dbo].[author] ([author_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[book_author]  WITH CHECK ADD FOREIGN KEY([product_id])
REFERENCES [dbo].[books] ([product_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[books]  WITH CHECK ADD FOREIGN KEY([book_category_id])
REFERENCES [dbo].[book_categories] ([book_category_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[books]  WITH CHECK ADD FOREIGN KEY([book_language_id])
REFERENCES [dbo].[book_languages] ([book_language_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[books]  WITH CHECK ADD FOREIGN KEY([book_publisher_id])
REFERENCES [dbo].[book_publishers] ([book_publisher_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[books]  WITH CHECK ADD FOREIGN KEY([product_id])
REFERENCES [dbo].[products] ([product_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[carts]  WITH CHECK ADD FOREIGN KEY([product_id])
REFERENCES [dbo].[products] ([product_id])
GO
ALTER TABLE [dbo].[carts]  WITH CHECK ADD FOREIGN KEY([user_id])
REFERENCES [dbo].[users] ([user_id])
GO
ALTER TABLE [dbo].[customers]  WITH CHECK ADD FOREIGN KEY([user_id])
REFERENCES [dbo].[users] ([user_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[employee_attendance]  WITH CHECK ADD FOREIGN KEY([employee_id])
REFERENCES [dbo].[employees] ([employee_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[employee_salary]  WITH CHECK ADD FOREIGN KEY([employee_id])
REFERENCES [dbo].[employees] ([employee_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[employee_salary]  WITH CHECK ADD FOREIGN KEY([salary_coefficient_id])
REFERENCES [dbo].[salary_coefficient] ([salary_coefficient_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[employees]  WITH CHECK ADD FOREIGN KEY([education_level_id])
REFERENCES [dbo].[education_level] ([education_level_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[employees]  WITH CHECK ADD FOREIGN KEY([user_id])
REFERENCES [dbo].[users] ([user_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[order_details_off]  WITH CHECK ADD FOREIGN KEY([order_id])
REFERENCES [dbo].[orders_offline] ([order_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[order_details_off]  WITH CHECK ADD FOREIGN KEY([product_id])
REFERENCES [dbo].[products] ([product_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[order_details_on]  WITH CHECK ADD FOREIGN KEY([order_id])
REFERENCES [dbo].[orders_online] ([order_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[order_details_on]  WITH CHECK ADD FOREIGN KEY([product_id])
REFERENCES [dbo].[products] ([product_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[orders_offline]  WITH CHECK ADD FOREIGN KEY([employee_id])
REFERENCES [dbo].[employees] ([employee_id])
GO
ALTER TABLE [dbo].[orders_online]  WITH CHECK ADD FOREIGN KEY([customer_id])
REFERENCES [dbo].[customers] ([customer_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[others_products]  WITH CHECK ADD FOREIGN KEY([others_product_brand_id])
REFERENCES [dbo].[brands] ([brand_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[others_products]  WITH CHECK ADD FOREIGN KEY([product_id])
REFERENCES [dbo].[products] ([product_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[payments_off]  WITH CHECK ADD FOREIGN KEY([order_id])
REFERENCES [dbo].[orders_offline] ([order_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[payments_on]  WITH CHECK ADD FOREIGN KEY([order_id])
REFERENCES [dbo].[orders_online] ([order_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[products]  WITH CHECK ADD FOREIGN KEY([category_id])
REFERENCES [dbo].[product_categories] ([category_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[products]  WITH CHECK ADD FOREIGN KEY([supplier_id])
REFERENCES [dbo].[suppliers] ([supplier_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[salary_coefficient]  WITH CHECK ADD FOREIGN KEY([role_id])
REFERENCES [dbo].[roles] ([role_id])
GO
ALTER TABLE [dbo].[shipper]  WITH CHECK ADD FOREIGN KEY([employee_id])
REFERENCES [dbo].[employees] ([employee_id])
GO
ALTER TABLE [dbo].[shipper]  WITH CHECK ADD FOREIGN KEY([order_id])
REFERENCES [dbo].[orders_online] ([order_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[stock_in]  WITH CHECK ADD FOREIGN KEY([employee_id])
REFERENCES [dbo].[users] ([user_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[stock_in_details]  WITH CHECK ADD FOREIGN KEY([product_id])
REFERENCES [dbo].[products] ([product_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[stock_in_details]  WITH CHECK ADD FOREIGN KEY([stock_in_id])
REFERENCES [dbo].[stock_in] ([stock_in_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[user_accounts]  WITH CHECK ADD FOREIGN KEY([user_role_id])
REFERENCES [dbo].[user_roles] ([user_role_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[user_roles]  WITH CHECK ADD FOREIGN KEY([role_id])
REFERENCES [dbo].[roles] ([role_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[user_roles]  WITH CHECK ADD FOREIGN KEY([user_id])
REFERENCES [dbo].[users] ([user_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[orders_online]  WITH CHECK ADD CHECK  (([status_on]='Deleted' OR [status_on]='Completed' OR [status_on]='Confirmed' OR [status_on]='Pending'))
GO
ALTER TABLE [dbo].[shipper]  WITH CHECK ADD CHECK  (([delivery_status]='Scheduled' OR [delivery_status]='In Transit' OR [delivery_status]='Delivered' OR [delivery_status]='Failed'))
GO
/****** Object:  StoredProcedure [dbo].[GetUserInformation_admin]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[GetUserInformation_admin]
@startFrom INT
AS
BEGIN
    SET NOCOUNT ON;

    DECLARE @pageSize INT = 9; -- Số lượng bản ghi trên mỗi trang
    DECLARE @startRow INT = (@startFrom - 1) * @pageSize; -- Số lượng dòng bắt đầu được bỏ qua

    SELECT
        full_name,
        u.email,
		u.image_user,
        r.role_name,
		r.role_id,
		ua.username,
		ua.password,
		u.user_id,
		u.address,
		u.date_of_birth,
		u.gender,
		u.phone
    FROM
        users u
    INNER JOIN
        user_roles ur ON u.user_id = ur.user_id
    INNER JOIN
        roles r ON ur.role_id = r.role_id
    INNER JOIN
        user_accounts ua ON ur.user_role_id = ua.user_role_id
	where r.role_id=2
    ORDER BY
        u.user_id
    OFFSET @startRow ROWS
    FETCH NEXT @pageSize ROWS ONLY;
END;
GO
/****** Object:  StoredProcedure [dbo].[GetUserInformation_customer]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[GetUserInformation_customer]
@startFrom INT
AS
BEGIN
    SET NOCOUNT ON;

    DECLARE @pageSize INT = 9; -- Số lượng bản ghi trên mỗi trang
    DECLARE @startRow INT = (@startFrom - 1) * @pageSize; -- Số lượng dòng bắt đầu được bỏ qua

    SELECT
        full_name,
        u.email,
		u.image_user,
        r.role_name,
		r.role_id,
		ua.username,
		ua.password,
		u.user_id,
		u.address,
		u.date_of_birth,
		u.gender,
		u.phone
    FROM
        users u
    INNER JOIN
        user_roles ur ON u.user_id = ur.user_id
    INNER JOIN
        roles r ON ur.role_id = r.role_id
    INNER JOIN
        user_accounts ua ON ur.user_role_id = ua.user_role_id
	where r.role_id=1
    ORDER BY
        u.user_id
    OFFSET @startRow ROWS
    FETCH NEXT @pageSize ROWS ONLY;
END;
GO
/****** Object:  StoredProcedure [dbo].[GetUserInformation_employee]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[GetUserInformation_employee]
@startFrom INT
AS
BEGIN
    SET NOCOUNT ON;

    DECLARE @pageSize INT = 9; -- Số lượng bản ghi trên mỗi trang
    DECLARE @startRow INT = (@startFrom - 1) * @pageSize; -- Số lượng dòng bắt đầu được bỏ qua

    SELECT
        full_name,
        u.email,
		u.image_user,
        r.role_name,
		r.role_id,
		ua.username,
		ua.password,
		u.user_id,
		u.address,
		u.date_of_birth,
		u.gender,
		u.phone
    FROM
        users u
    INNER JOIN
        user_roles ur ON u.user_id = ur.user_id
    INNER JOIN
        roles r ON ur.role_id = r.role_id
    INNER JOIN
        user_accounts ua ON ur.user_role_id = ua.user_role_id
	where r.role_id=3
    ORDER BY
        u.user_id
    OFFSET @startRow ROWS
    FETCH NEXT @pageSize ROWS ONLY;
END;
GO
/****** Object:  StoredProcedure [dbo].[InsertNewUser_admin]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[InsertNewUser_admin]
    @full_name NVARCHAR(250),
    @date_of_birth DATE,
    @gender BIT,
    @email VARCHAR(255),
    @address NVARCHAR(255),
    @phone VARCHAR(15),
    @image_user NVARCHAR(MAX),
    @username VARCHAR(255),
    @password VARCHAR(255)
AS
BEGIN
    DECLARE @user_id BIGINT;

    -- Thêm người dùng vào bảng users
    INSERT INTO users (full_name, date_of_birth, gender, address, phone, email, image_user)
    VALUES (@full_name, @date_of_birth, @gender, @address, @phone, @email, @image_user);

    -- Lấy ID của người dùng vừa được thêm
    SET @user_id = SCOPE_IDENTITY();

    -- Thêm quyền cho người dùng vào bảng user_roles
    INSERT INTO user_roles (user_id, role_id)
    VALUES (@user_id, 2);

    DECLARE @user_role_id BIGINT;

    -- Lấy ID của quyền người dùng vừa được thêm
    SET @user_role_id = SCOPE_IDENTITY();

    -- Thêm tài khoản người dùng vào bảng user_accounts
    INSERT INTO user_accounts (username, password, user_role_id)
    VALUES (@username, @password, @user_role_id);
END;
GO
/****** Object:  StoredProcedure [dbo].[InsertNewUser_customer]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[InsertNewUser_customer]
    @full_name NVARCHAR(250),
    @date_of_birth DATE,
    @gender BIT,
    @email VARCHAR(255),
    @address NVARCHAR(255),
    @phone VARCHAR(15),
    @image_user NVARCHAR(MAX),
    @username VARCHAR(255),
    @password VARCHAR(255)
AS
BEGIN
    DECLARE @user_id BIGINT;

    -- Thêm người dùng vào bảng users
    INSERT INTO users (full_name, date_of_birth, gender, address, phone, email, image_user)
    VALUES (@full_name, @date_of_birth, @gender, @address, @phone, @email, @image_user);

    -- Lấy ID của người dùng vừa được thêm
    SET @user_id = SCOPE_IDENTITY();

    -- Thêm quyền cho người dùng vào bảng user_roles
    INSERT INTO user_roles (user_id, role_id)
    VALUES (@user_id, 1);

    DECLARE @user_role_id BIGINT;

    -- Lấy ID của quyền người dùng vừa được thêm
    SET @user_role_id = SCOPE_IDENTITY();

    -- Thêm tài khoản người dùng vào bảng user_accounts
    INSERT INTO user_accounts (username, password, user_role_id)
    VALUES (@username, @password, @user_role_id);
END;
GO
/****** Object:  StoredProcedure [dbo].[InsertNewUser_employee]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[InsertNewUser_employee]
    @full_name NVARCHAR(250),
    @date_of_birth DATE,
    @gender BIT,
    @email VARCHAR(255),
    @address NVARCHAR(255),
    @phone VARCHAR(15),
    @image_user NVARCHAR(MAX),
    @username VARCHAR(255),
    @password VARCHAR(255)
AS
BEGIN
    DECLARE @user_id BIGINT;

    -- Thêm người dùng vào bảng users
    INSERT INTO users (full_name, date_of_birth, gender, address, phone, email, image_user)
    VALUES (@full_name, @date_of_birth, @gender, @address, @phone, @email, @image_user);

    -- Lấy ID của người dùng vừa được thêm
    SET @user_id = SCOPE_IDENTITY();

    -- Thêm quyền cho người dùng vào bảng user_roles
    INSERT INTO user_roles (user_id, role_id)
    VALUES (@user_id, 3);

    DECLARE @user_role_id BIGINT;

    -- Lấy ID của quyền người dùng vừa được thêm
    SET @user_role_id = SCOPE_IDENTITY();

    -- Thêm tài khoản người dùng vào bảng user_accounts
    INSERT INTO user_accounts (username, password, user_role_id)
    VALUES (@username, @password, @user_role_id);
END;
GO
/****** Object:  StoredProcedure [dbo].[RegisterUser]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[RegisterUser]
    @FullName NVARCHAR(250),
    @DateOfBirth DATE,
    @Gender BIT,
    @Phone VARCHAR(15),
    @Address NVARCHAR(255),
    @Email VARCHAR(255),
    @Username VARCHAR(255),
    @Password VARCHAR(255)
AS
BEGIN
    DECLARE @ResponseTable TABLE (
        register_status NVARCHAR(10),
        message NVARCHAR(255)
    );

    -- Validate FullName
    IF @FullName = '' OR @FullName IS NULL
    BEGIN
        INSERT INTO @ResponseTable (register_status, message)
        VALUES ('Failed', 'FullName cannot be empty.');
        SELECT * FROM @ResponseTable;
        RETURN;
    END

    -- Validate DateOfBirth
    IF @DateOfBirth IS NULL
    BEGIN
        INSERT INTO @ResponseTable (register_status, message)
        VALUES ('Failed', 'DateOfBirth cannot be empty and must be a valid date.');
        SELECT * FROM @ResponseTable;
        RETURN;
    END

    -- Validate Gender
    IF @Gender IS NULL
    BEGIN
        INSERT INTO @ResponseTable (register_status, message)
        VALUES ('Failed', 'Gender cannot be empty.');
        SELECT * FROM @ResponseTable;
        RETURN;
    END

    -- Validate Phone
    IF @Phone = '' OR @Phone IS NULL OR NOT (@Phone LIKE '0%' OR @Phone LIKE '+%')
    BEGIN
        INSERT INTO @ResponseTable (register_status, message)
        VALUES ('Failed', 'Phone must start with 0 or + and cannot be empty.');
        SELECT * FROM @ResponseTable;
        RETURN;
    END

    -- Validate Address
    IF @Address = '' OR @Address IS NULL
    BEGIN
        INSERT INTO @ResponseTable (register_status, message)
        VALUES ('Failed', 'Address cannot be empty.');
        SELECT * FROM @ResponseTable;
        RETURN;
    END

    -- Validate Email
    IF @Email = '' OR @Email IS NULL OR NOT @Email LIKE '%_@__%.__%'
    BEGIN
        INSERT INTO @ResponseTable (register_status, message)
        VALUES ('Failed', 'Email cannot be empty and must be in a valid format.');
        SELECT * FROM @ResponseTable;
        RETURN;
    END

    -- Validate Username
    IF @Username = '' OR @Username IS NULL OR @Username LIKE '%[^a-zA-Z0-9]%' OR @Username LIKE '% %'
    BEGIN
        INSERT INTO @ResponseTable (register_status, message)
        VALUES ('Failed', 'Username cannot contain spaces or special characters.');
        SELECT * FROM @ResponseTable;
        RETURN;
    END

    -- Validate Password
    IF LEN(@Password) <= 8
    BEGIN
        INSERT INTO @ResponseTable (register_status, message)
        VALUES ('Failed', 'Password must be longer than 8 characters.');
        SELECT * FROM @ResponseTable;
        RETURN;
    END

    -- Insert user information into users table
    DECLARE @UserID BIGINT;
    INSERT INTO users (full_name, date_of_birth, gender, address, phone, email)
	VALUES (@FullName, @DateOfBirth, @Gender, @Address, @Phone, @Email);

		SET @UserID = SCOPE_IDENTITY();

		-- Insert default role for the user into user_roles table
		DECLARE @UserRoleID BIGINT;
		DECLARE @DefaultRoleID BIGINT = 1; -- Assuming 1 is the default role ID, change as needed

		INSERT INTO user_roles (user_id, role_id)
		VALUES (@UserID, @DefaultRoleID);

		SET @UserRoleID = SCOPE_IDENTITY();

		-- Insert user account into user_accounts table
		INSERT INTO user_accounts (username, password, user_role_id)
		VALUES (@Username, @Password, @UserRoleID);

		INSERT INTO @ResponseTable (register_status, message)
		VALUES ('Success', 'User registered successfully.');

		SELECT * FROM @ResponseTable;
	END
GO
/****** Object:  StoredProcedure [dbo].[SearchAccount_admin]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[SearchAccount_admin]
    @keyword NVARCHAR(200)
AS
BEGIN
    SELECT
		u.full_name,
        u.email,
		u.image_user,
        r.role_name,
		r.role_id,
		ua.username,
		ua.password,
		u.user_id,
		u.address,
		u.date_of_birth,
		u.gender,
		u.phone
    FROM
        users u
    INNER JOIN
        user_roles ur ON u.user_id = ur.user_id
    INNER JOIN
        roles r ON ur.role_id = r.role_id
	INNER JOIN
		user_accounts ua on ua.user_role_id = ur.user_role_id
    WHERE
		r.role_id=2 and
		(lower(u.full_name) LIKE '%' + lower(trim(@keyword))  + '%'
		OR LOWER(ua.username) LIKE '%' + lower(trim(@keyword))  + '%'
		OR LOWER(u.email) LIKE '%' + lower(trim(@keyword)) + '%'
		OR LOWER(u.full_name COLLATE Vietnamese_CI_AI) LIKE '%' + lower(trim(@keyword)) + '%'
		OR LOWER(REPLACE(u.full_name COLLATE Vietnamese_CI_AI,' ','')) LIKE '%' + lower(replace(@keyword,' ','')) + '%');
END;
GO
/****** Object:  StoredProcedure [dbo].[SearchAccount_customer]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[SearchAccount_customer]
    @keyword NVARCHAR(200)
AS
BEGIN
    SELECT
		u.full_name,
        u.email,
		u.image_user,
        r.role_name,
		r.role_id,
		ua.username,
		ua.password,
		u.user_id,
		u.address,
		u.date_of_birth,
		u.gender,
		u.phone
    FROM
        users u
    INNER JOIN
        user_roles ur ON u.user_id = ur.user_id
    INNER JOIN
        roles r ON ur.role_id = r.role_id
	INNER JOIN
		user_accounts ua on ua.user_role_id = ur.user_role_id
    WHERE
		r.role_id=1 and
		(lower(u.full_name) LIKE '%' + lower(trim(@keyword))  + '%'
		OR LOWER(ua.username) LIKE '%' + lower(trim(@keyword))  + '%'
		OR LOWER(u.email) LIKE '%' + lower(trim(@keyword)) + '%'
		OR LOWER(u.full_name COLLATE Vietnamese_CI_AI) LIKE '%' + lower(trim(@keyword)) + '%'
		OR LOWER(REPLACE(u.full_name COLLATE Vietnamese_CI_AI,' ','')) LIKE '%' + lower(replace(@keyword,' ','')) + '%');
END;
GO
/****** Object:  StoredProcedure [dbo].[SearchAccount_employee]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[SearchAccount_employee]
    @keyword NVARCHAR(200)
AS
BEGIN
    SELECT
		u.full_name,
        u.email,
		u.image_user,
        r.role_name,
		r.role_id,
		ua.username,
		ua.password,
		u.user_id,
		u.address,
		u.date_of_birth,
		u.gender,
		u.phone
    FROM
        users u
    INNER JOIN
        user_roles ur ON u.user_id = ur.user_id
    INNER JOIN
        roles r ON ur.role_id = r.role_id
	INNER JOIN
		user_accounts ua on ua.user_role_id = ur.user_role_id
    WHERE
		r.role_id=3 and
		(lower(u.full_name) LIKE '%' + lower(trim(@keyword))  + '%'
		OR LOWER(ua.username) LIKE '%' + lower(trim(@keyword))  + '%'
		OR LOWER(u.email) LIKE '%' + lower(trim(@keyword)) + '%'
		OR LOWER(u.full_name COLLATE Vietnamese_CI_AI) LIKE '%' + lower(trim(@keyword)) + '%'
		OR LOWER(REPLACE(u.full_name COLLATE Vietnamese_CI_AI,' ','')) LIKE '%' + lower(replace(@keyword,' ','')) + '%');
END;
GO
/****** Object:  StoredProcedure [dbo].[sp_EditOtherProduct]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
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
GO
/****** Object:  StoredProcedure [dbo].[sp_InsertProductAndBook]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[sp_InsertProductAndBook]
    @product_name NVARCHAR(MAX),
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

    -- Insert product
    INSERT INTO products (category_id, product_price, product_image, product_quantity, supplier_id, product_status)
    VALUES (@category_id, @product_price, @product_image, @product_quantity, @supplier_id, @product_status);

    -- Get the inserted product ID
    DECLARE @product_id BIGINT = SCOPE_IDENTITY();

    -- Insert book
    INSERT INTO books (product_id, book_name, book_category_id, book_description, book_language_id, book_publication_year, book_packaging_size, book_format, book_ISBN, book_publisher_id)
    VALUES (@product_id, @product_name, @book_category_id, @book_description, @book_language_id, @book_publication_year, @book_packaging_size, @book_format, @book_ISBN, @book_publisher_id);

    -- Insert author if not exists
    IF NOT EXISTS (SELECT 1 FROM author WHERE author_name = @author_name)
    BEGIN
        INSERT INTO author (author_name) VALUES (@author_name);
    END

    -- Get the inserted author ID
    DECLARE @author_id BIGINT = (SELECT author_id FROM author WHERE author_name = @author_name);

    -- Insert book_author
    INSERT INTO book_author (author_id, product_id) VALUES (@author_id, @product_id);

    COMMIT TRANSACTION;

    -- Return the new product ID
    SELECT @product_id AS product_id;
END
GO
/****** Object:  StoredProcedure [dbo].[sp_InsertProductAndOtherProduct]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
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
GO
/****** Object:  StoredProcedure [dbo].[UpdateProductAndBook]    Script Date: 7/25/2024 5:30:10 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
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
GO
