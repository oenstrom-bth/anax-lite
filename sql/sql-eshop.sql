-- ------------------------------------------------------------------------
--
-- For lecture in oophp-v3 kmom03 
--
-- CREATE DATABASE oophp;
-- GRANT ALL ON oophp.* TO user@localhost IDENTIFIED BY "pass";
-- USE oophp;
SET NAMES utf8;



-- ------------------------------------------------------------------------
--
-- Setup tables
--
DROP TABLE IF EXISTS `Prod2Cat`;
DROP TABLE IF EXISTS `ProdCategory`;
DROP TABLE IF EXISTS `Inventory`;
DROP TABLE IF EXISTS `InvenShelf`;
DROP TABLE IF EXISTS `OrderRow`;
DROP TABLE IF EXISTS `InvoiceRow`;
DROP TABLE IF EXISTS `Invoice`;
DROP TABLE IF EXISTS `Order`;
DROP TABLE IF EXISTS `Product`;
DROP TABLE IF EXISTS `Customer`;



-- ------------------------------------------------------------------------
--
-- Product and product category
--
CREATE TABLE `ProdCategory` (
	`id` INT AUTO_INCREMENT,
	`category` CHAR(10),

	PRIMARY KEY (`id`)
);

CREATE TABLE `Product` (
	`id` INT AUTO_INCREMENT,
    `description` VARCHAR(20),

	PRIMARY KEY (`id`)
);

CREATE TABLE `Prod2Cat` (
	`id` INT AUTO_INCREMENT,
	`prod_id` INT,
	`cat_id` INT,

	PRIMARY KEY (`id`),
    FOREIGN KEY (`prod_id`) REFERENCES `Product` (`id`), 
    FOREIGN KEY (`cat_id`) REFERENCES `ProdCategory` (`id`) 
);



-- ------------------------------------------------------------------------
--
-- Inventory and shelfs
--
CREATE TABLE `InvenShelf` (
    `shelf` CHAR(6),
    `description` VARCHAR(40),

	PRIMARY KEY (`shelf`)
);

CREATE TABLE `Inventory` (
	`id` INT AUTO_INCREMENT,
    `prod_id` INT,
    `shelf_id` CHAR(6),
    `items` INT,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`prod_id`) REFERENCES `Product` (`id`),
	FOREIGN KEY (`shelf_id`) REFERENCES `InvenShelf` (`shelf`)
);




-- ------------------------------------------------------------------------
--
-- Customer
--
CREATE TABLE `Customer` (
	`id` INT AUTO_INCREMENT,
    `firstName` VARCHAR(20),
    `lastName` VARCHAR(20),
  
	PRIMARY KEY (`id`)
);



-- ------------------------------------------------------------------------
--
-- Order
--
CREATE TABLE `Order` (
	`id` INT AUTO_INCREMENT,
    `customer` INT,
	`created` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`updated` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
	`deleted` DATETIME DEFAULT NULL,
	`delivery` DATETIME DEFAULT NULL,
    
	PRIMARY KEY (`id`),
	FOREIGN KEY (`customer`) REFERENCES `Customer` (`id`)
);

CREATE TABLE `OrderRow` (
	`id` INT AUTO_INCREMENT,
    `order` INT,
    `product` INT,
	`items` INT,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`order`) REFERENCES `Order` (`id`),
	FOREIGN KEY (`product`) REFERENCES `Product` (`id`)
);



-- ------------------------------------------------------------------------
--
-- Invoice
--
CREATE TABLE `Invoice` (
	`id` INT AUTO_INCREMENT,
    `order` INT,
    `customer` INT,
	`created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    
	PRIMARY KEY (`id`),
	FOREIGN KEY (`order`) REFERENCES `Order` (`id`),
	FOREIGN KEY (`customer`) REFERENCES `Customer` (`id`)
);

CREATE TABLE `InvoiceRow` (
	`id` INT AUTO_INCREMENT,
    `invoice` INT,
    `product` INT,
	`items` INT,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`invoice`) REFERENCES `Invoice` (`id`),
	FOREIGN KEY (`product`) REFERENCES `Product` (`id`)
);




-- ------------------------------------------------------------------------
--
-- By some stuff to get it up and running,
-- the first truck has arrived and you need to
-- insert the details into you database.
--

-- ------------------------------------------------------------------------
--
-- Start with the product catalogue
--
INSERT INTO `ProdCategory` (`category`) VALUES
("mugs"), ("clothes"), ("dbwebb"), ("grillcon")
;

INSERT INTO `Product` (`description`) VALUES
("Mug dbwebb"), ("T-shirt dbwebb"), ("Mug GrillCon"), ("T-shirt GrillCon")
;

INSERT INTO `Prod2Cat` (`prod_id`, `cat_id`) VALUES
(1, 1), (1, 3),
(2, 2), (2, 3),
(3, 1), (3, 4),
(4, 2), (4, 4)
;

SELECT
	P.id,
    P.description,
    GROUP_CONCAT(category) AS category
FROM Product AS P
	INNER JOIN Prod2Cat AS P2C
		ON P.id = P2C.prod_id
	INNER JOIN ProdCategory AS PC
		ON PC.id = P2C.cat_id
GROUP BY P.id
ORDER BY P.description
;



-- ------------------------------------------------------------------------
--
-- The truck has arrived, put the stuff into shelfs and update the database
--
INSERT INTO `InvenShelf` (`shelf`, `description`) VALUES
("AAA101", "House A, aisle A, part A, shelf 101"),
("AAA102", "House A, aisle A, part A, shelf 102")
;

INSERT INTO `Inventory` (`prod_id`, `shelf_id`, `items`) VALUES
(1, "AAA101", 100), (2, "AAA102", 100),
(3, "AAA101", 100), (4, "AAA102", 100)
;

SELECT * FROM InvenShelf;

--
-- View connecting products with their place in the inventory
-- and offering reports for inventory and sales personal.
--
DROP VIEW IF EXISTS VInventory;
CREATE VIEW VInventory AS
SELECT
	S.shelf,
    S.description AS location,
    I.items,
    P.description
FROM Inventory AS I
	INNER JOIN InvenShelf AS S
		ON I.shelf_id = S.shelf
	INNER JOIN Product AS P
		ON P.id = I.prod_id
ORDER BY S.shelf
;

SELECT * FROM VInventory;
SELECT description, items, shelf, description FROM VInventory;



-- ------------------------------------------------------------------------
--
-- The customers are arriving
--
INSERT INTO `Customer` (`firstName`, `lastName`) VALUES
("Mumin", "Trollet"),
("Mamma", "Mumin"),
("Pappa", "Mumin")
;



-- ------------------------------------------------------------------------
--
-- Your first customer order, hurray!
--
INSERT INTO `Order` (`customer`) VALUES
(1), (2)
;

INSERT INTO `OrderRow` (`order`, `product`, `items`) VALUES
(1, 3, 2),
(1, 4, 2),
(2, 1, 1),
(2, 2, 1),
(2, 3, 1),
(2, 4, 1)
;

--
-- Order information
--
SELECT
	O.id AS OrderNumber,
    C.id AS CustomerNumber,
    O.created AS OrderDate,
    O.delivery AS DeliveryDate,
    C.firstName,
    C.lastName
FROM `Order` AS O
	INNER JOIN Customer AS C
		ON O.customer = C.id
;

--
-- Order details
--
DROP VIEW IF EXISTS VOrderDetails;
CREATE VIEW VOrderDetails AS
SELECT
    O.id AS OrderNumber,
    R.id AS OrderRow,
    P.description AS Description,
    R.items AS Items
FROM `Order` AS O
	INNER JOIN OrderRow AS R
		ON O.id = R.order
	INNER JOIN Product AS P
		ON R.product = P.id
ORDER BY OrderRow
;

SELECT * FROM VOrderDetails;

--
-- Order Plocklist
--
DROP VIEW IF EXISTS VPlockList;
CREATE VIEW VPlockList AS 
SELECT
    O.id AS OrderNumber,
    R.id AS OrderRow,
    P.description AS Description,
    R.items AS Items,
    S.shelf AS Shelf,
    S.description AS ShelfLocation,
    I.items AS ItemsAvailable
FROM `Order` AS O
	INNER JOIN OrderRow AS R
		ON O.id = R.order
	INNER JOIN Product AS P
		ON R.product = P.id
	INNER JOIN Inventory AS I
		ON P.id = I.prod_id
	INNER JOIN InvenShelf AS S
		ON I.shelf_id = S.shelf
ORDER BY OrderRow
;

SELECT * FROM VPlockList;



-- ------------------------------------------------------------------------
--
-- Lets create the invoice using the order information
--
INSERT INTO `Invoice` (`order`, `customer`)
SELECT `id`, `customer` FROM `Order`
; 

INSERT INTO `InvoiceRow` (`invoice`, `product`, `items`)
SELECT
	I.id AS InvoiceNumber,
    R.product AS ProductId,
    R.items AS Items
FROM Invoice AS I
	INNER JOIN OrderRow AS R
		ON I.order = R.order
;

--
-- Invoice header
--
SELECT
	I.id AS InvoiceNumber,
    I.order AS OrderNumber,
    I.customer AS CustomerNumber,
    I.created AS InvoiceDate,
    O.created AS OrderDate,
    C.firstName AS FirstName,
    C.lastName AS LastName
FROM Invoice AS I
	INNER JOIN Customer AS C
		ON I.customer = C.id
	INNER JOIN `Order` AS O
		ON I.order = O.id
;

--
-- Details for invoice
--
SELECT
	R.invoice AS InvoiceNumber,
    R.id AS InvoiceRow,
    P.description AS Description,
    R.items AS Items
FROM InvoiceRow AS R
	INNER JOIN Product AS P
		ON R.product = P.id
ORDER BY InvoiceNumber, InvoiceRow
;
