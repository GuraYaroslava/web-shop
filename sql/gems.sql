CREATE DATABASE gems DEFAULT CHARSET utf8;

use gems;

SET NAMES 'cp1251'; 
SET character_set_client='cp1251';
SET character_set_connection='cp1251';

CREATE TABLE categories (
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(50) NOT NULL,
   parent_id INT NOT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE users (
    id             INT NOT NULL AUTO_INCREMENT,
    login          VARCHAR(50)	NOT NULL,
    pass		   CHAR(50) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE products (
    id          INT NOT NULL AUTO_INCREMENT,
    label     	VARCHAR(15) NOT NULL,
    name        VARCHAR(40) NOT NULL,
    price       INT NOT NULL,
    amount      INT NOT NULL,
    PRIMARY KEY(id),
    UNIQUE KEY(label)
);

CREATE TABLE product_category 
(
  id 			INT NOT NULL AUTO_INCREMENT,
  product_id  	INT NOT NULL,
  category_id 	INT NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(product_id) REFERENCES products (id) ON DELETE CASCADE,
  FOREIGN KEY(category_id) REFERENCES categories (id) ON DELETE CASCADE
);

CREATE TABLE product_images (
    id         		INT		 			NOT NULL AUTO_INCREMENT,
    image_name 		VARCHAR(50)			NOT NULL,
    product_id    	INT		 			NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE cart (
    user_id 			INT		 	NOT NULL,
    product_id 			INT		 	NOT NULL,
    amount  			INT		 	DEFAULT 1,
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY(product_id)	REFERENCES products(id) ON DELETE CASCADE
);

INSERT INTO categories(name, parent_id) VALUES
('Украшения', 0),
('Фирмы', 1),
('Кольца', 2),
('Серьги', 2),
('Браслеты', 2),
('Oliver', 3),
('Hello', 3),
('Yarik', 3),
('Новинкa', 1);

INSERT INTO products(label, name, price, amount) VALUES
('a0123', 'Кольцо (Oliver)', 55, 5),
('b0321', 'Серьги (Oliver)', 60, 5),
('c5631', 'Браслет (Oliver)', 70, 5),
('4532d', 'Кольцо (Hello)', 40, 5),
('e2345', 'Серьги (Hello)', 50, 5),
('4530f', 'Браслет (Hello)', 20, 5),
('45g35', 'Кольцо (Yarik)', 15, 5),
('435h7', 'Серьги (Yarik)', 15, 5),
('757i2', 'Браслет (Yarik)', 45, 5),
('453j1', 'Новиночка', 5, 5);

INSERT INTO product_category (product_id, category_id) VALUES
(1, 2),
(1, 5),
(2, 3),
(2, 5),
(3, 4),
(3, 5),
(4, 2),
(4, 6),
(5, 3),
(5, 6),
(6, 4),
(6, 6),
(7, 2),
(7, 7),
(8, 3),
(8, 7),
(9, 4),
(9, 7),
(10, 1);

INSERT INTO users(login, pass) VALUES
('admin', 1),
('creater', 2);

GRANT SELECT, INSERT, UPDATE, DELETE
ON gems.*
TO yarik@localhost IDENTIFIED BY 'sun';