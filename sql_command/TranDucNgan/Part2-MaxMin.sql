-- Retrieves the product with the highest price
SELECT MAX(product_price) AS highest_price
FROM products;

-- Retrieves the product with the lowest price
SELECT MIN(product_price) AS lowest_price
FROM products;

-- Retrieves the most recent order date from online orders
SELECT MAX(order_date_on) AS latest_order_date
FROM orders_online;

-- Retrieves the earliest work date of employees
SELECT MIN(work_date) AS earliest_work_date
FROM employees;

-- Retrieves the book with the latest publication year
SELECT MAX(book_publication_year) AS latest_publication_year
FROM books;
