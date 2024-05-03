CREATE TABLE IF NOT EXISTS products (
    product_id INT(11) NOT NULL AUTO_INCREMENT,
    product_name VARCHAR(100) NOT NULL,
    product_category VARCHAR(100) NOT NULL,
    product_description VARCHAR(255) NOT NULL,
    product_image VARCHAR(255) NOT NULL,
    product_image2 VARCHAR(255) NOT NULL,
    product_image3 VARCHAR(255) NOT NULL,
    product_image4 VARCHAR(255) NOT NULL,
    product_price DECIMAL(6,2) NOT NULL,
    product_special_offer INT(2) NOT NULL,
    product_color VARCHAR(100) NOT NULL,
    PRIMARY KEY (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS orders (
    order_id INT(11) NOT NULL AUTO_INCREMENT,
    order_cost DECIMAL(6,2) NOT NULL,
    order_status VARCHAR(100) NOT NULL DEFAULT 'on_hold',
    user_id INT(11) NOT NULL,
    user_phone INT(11) NOT NULL,
    user_city VARCHAR(255) NOT NULL,
    user_address VARCHAR(255) NOT NULL,
    order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (order_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS order_items (
    item_id INT(11) NOT NULL AUTO_INCREMENT,
    order_id INT(11) NOT NULL,
    product_id VARCHAR(255) NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    product_image VARCHAR(255) NOT NULL,
    user_id INT(11) NOT NULL,
    order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (item_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS users (
    user_id INT(11) NOT NULL AUTO_INCREMENT,
    user_name VARCHAR(100) NOT NULL,
    user_email VARCHAR(100) NOT NULL,
    user_password VARCHAR(100) NOT NULL,
    PRIMARY KEY (user_id),
    UNIQUE KEY UX_Constraint (user_email)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
