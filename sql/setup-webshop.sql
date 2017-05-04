USE olen16;

SET GLOBAL log_bin_trust_function_creators = 1;
SET NAMES utf8;



DROP TABLE IF EXISTS `Prod2Cat`;
DROP TABLE IF EXISTS `ProdCategory`;
DROP TABLE IF EXISTS `Inventory`;
DROP TABLE IF EXISTS `InventoryLog`;
DROP TABLE IF EXISTS `CartRow`;
DROP TABLE IF EXISTS `OrderRow`;
DROP TABLE IF EXISTS `Order`;
DROP TABLE IF EXISTS `Cart`;
DROP TABLE IF EXISTS `Product`;




--
-- Product, cateogry and inventory
--
CREATE TABLE `ProdCategory` (
	`id` INT AUTO_INCREMENT,
	`category` CHAR(20) UNIQUE,

	PRIMARY KEY (`id`)
);

CREATE TABLE `Product` (
	`id` INT AUTO_INCREMENT,
    `description` VARCHAR(30),
    `image` VARCHAR(255) DEFAULT "products/no-image.png",
    `price` INT,
    `deleted` DATETIME DEFAULT NULL,

	PRIMARY KEY (`id`)
);

CREATE TABLE `Prod2Cat` (
	`id` INT AUTO_INCREMENT,
	`product_id` INT,
	`category_id` INT,

	PRIMARY KEY (`id`),
    FOREIGN KEY (`product_id`) REFERENCES `Product` (`id`), 
    FOREIGN KEY (`category_id`) REFERENCES `ProdCategory` (`id`) 
);

CREATE TABLE `Inventory` (
	`id` INT AUTO_INCREMENT,
    `product_id` INT,
    `amount` INT,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`product_id`) REFERENCES `Product` (`id`)
);

CREATE TABLE `InventoryLog` (
	`id` INT AUTO_INCREMENT,
    `product_id` INT,
    `amount` INT,
    `when` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`product_id`) REFERENCES `Product` (`id`)
);



-- ------ --
-- Cart --
-- ------ --
CREATE TABLE `Cart` (
	`id` INT AUTO_INCREMENT,
    
	PRIMARY KEY (`id`)
);

CREATE TABLE `CartRow` (
	`id` INT AUTO_INCREMENT,
    `cart_id` INT,
    `product_id` INT,
	`amount` INT,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`cart_id`) REFERENCES `Cart` (`id`),
	FOREIGN KEY (`product_id`) REFERENCES `Product` (`id`)
);



-- -------- --
-- Order --
-- -------- --
CREATE TABLE `Order` (
	`id` INT AUTO_INCREMENT,
    `user_id` INT,
	`created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	`updated` DATETIME DEFAULT NULL,
	`deleted` DATETIME DEFAULT NULL,
	`delivery` DATETIME DEFAULT NULL,
    
	PRIMARY KEY (`id`),
	FOREIGN KEY (`user_id`) REFERENCES `anax_users` (`id`)
);

CREATE TABLE `OrderRow` (
	`id` INT AUTO_INCREMENT,
    `order_id` INT,
    `product_id` INT,
	`amount` INT,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`order_id`) REFERENCES `Order` (`id`),
	FOREIGN KEY (`product_id`) REFERENCES `Product` (`id`)
);



-- ---------------------------- --
-- Insert some products --
-- ---------------------------- --
INSERT INTO `ProdCategory` (`category`) VALUES
("tv"),
("telefoner"),
("samsung"),
("sony"),
("lg")
;

INSERT INTO `Product` (`description`, `price`) VALUES
("Samsung Galaxy S8+", 8990),
("Samsung 60\" SUHD TV", 11990),
("Nokia 9", 5490),
("OnePlus 5", 4890),
("Sony Xperia XZ Premium", 7990),
("Sony 55\" UHD TV", 8990),
("LG G6", 7490),
("LG 65\" UHD TV", 12990)
;

INSERT INTO `Prod2Cat` (`product_id`, `category_id`) VALUES
(1, 2), (1, 3),
(2, 1), (2, 3),
(3, 2),
(4, 2),
(5, 2), (5, 4),
(6, 1), (6, 4),
(7, 2), (7, 5),
(8, 1), (8, 5)
;


INSERT INTO `Inventory` (`product_id`, `amount`) VALUES
(1, 100), (2, 40),
(3, 50), (4, 200),
(5, 50), (6, 50),
(7, 60), (8, 30)
;


-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------



--
-- Product, category, inventory view
--
CREATE OR REPLACE VIEW VProdCatInv AS
	SELECT
		P.id AS id,
		P.image AS image,
		P.description AS description,
		GROUP_CONCAT(PC.category) AS category,
		P.price AS price,
		I.amount AS amount
	FROM Product AS P
		LEFT JOIN Prod2Cat AS P2C
			ON P.id = P2C.product_id
		LEFT JOIN ProdCategory AS PC
			ON PC.id = P2C.category_id
		INNER JOIN Inventory AS I
			ON I.product_id = P.id
	WHERE P.deleted IS NULL
	GROUP BY P.id
	ORDER BY P.id
;



--
-- Get the number of items of a certain product.
--
DROP FUNCTION IF EXISTS Amount;
CREATE FUNCTION Amount(
	product INT
)
RETURNS INT
RETURN (SELECT amount FROM Inventory WHERE product_id = product);





--
-- Trigger logging of inventory when below 5.
--
DROP TRIGGER IF EXISTS LogInventory;
DELIMITER //

CREATE TRIGGER LogInventory AFTER UPDATE ON `Inventory`
	FOR EACH ROW BEGIN
		IF NEW.amount < 5 THEN
			INSERT INTO `InventoryLog`(product_id, amount) VALUES(NEW.product_id, NEW.amount);
		END IF;
    END
//
	
DELIMITER ;




-- ------------------------------------------------------------------------------------------------------------
-- ------------------------------- Procedures for cart management. -------------------------------
-- ------------------------------------------------------------------------------------------------------------
DROP PROCEDURE IF EXISTS addToCart;
DROP PROCEDURE IF EXISTS removeFromCart;
DROP PROCEDURE IF EXISTS getCart;

DELIMITER //

CREATE PROCEDURE addToCart(
	cart INT,
    product INT,
    amountToAdd INT
)
BEGIN
    
    START TRANSACTION;
    
    IF NOT EXISTS (SELECT * FROM Cart WHERE id = cart) THEN
		INSERT INTO Cart VALUES();
        SET cart = (SELECT LAST_INSERT_ID());
	END IF;
    
	
	IF EXISTS (SELECT * FROM CartRow WHERE cart_id = cart AND product_id = product) THEN
		
		UPDATE CartRow SET amount = amount + amountToAdd WHERE cart_id = cart AND product_id = product;
	
	ELSE

		INSERT INTO CartRow(`cart_id`, `product_id`, `amount`) VALUES(cart, product, amountToAdd);
	
	END IF;
    
    COMMIT;

END
//

CREATE PROCEDURE removeFromCart(
	cart INT,
    product INT,
    amountToRemove INT
)
BEGIN

	DECLARE amountOfProduct INT;
	
    START TRANSACTION;
    
    SET amountOfProduct = (SELECT amount FROM CartRow WHERE cart_id = cart AND product_id = product);
    
    IF amountOfProduct - amountToRemove < 1 THEN
		DELETE FROM CartRow WHERE cart_id = cart AND product_id = product;
	ELSE
		UPDATE CartRow SET amount = amount - amountToRemove WHERE cart_id = cart AND product_id = product;
	END IF;
    
    COMMIT;
    
    
END
//

CREATE PROCEDURE getCart(
	cart INT
)
BEGIN
	
    SELECT
		C.id AS cart_id,
		R.id AS cart_row,
		P.image AS image,
		P.description AS description,
		R.amount AS amount,
		P.price AS price_each,
		(P.price * R.amount) AS total_price
	FROM `Cart` AS C
		INNER JOIN CartRow AS R
			ON C.id = R.cart_id
		INNER JOIN Product AS P
			ON R.product_id = P.id
	WHERE C.id = cart
	ORDER BY cart_row;

END
//

DELIMITER ;



-- --------------------------------------------------------------------------------------------------------------
-- ------------------------------- Procedures for order management. -------------------------------
-- --------------------------------------------------------------------------------------------------------------
DROP PROCEDURE IF EXISTS createOrder;
DROP PROCEDURE IF EXISTS deleteOrder;
DROP PROCEDURE IF EXISTS getOrder;

DELIMITER //

CREATE PROCEDURE createOrder(
	cart INT,
    user INT
)
BEGIN

	DECLARE newOrder INT;
    DECLARE n INT DEFAULT 0;
    DECLARE i INT DEFAULT 0;
    DECLARE invAmount INT;
    DECLARE amountToMove INT;
	
	START TRANSACTION;
    
    INSERT INTO `Order`(`user_id`) VALUES(user);
    SELECT LAST_INSERT_ID() INTO newOrder;
    
    SELECT COUNT(*) FROM `CartRow` WHERE cart_id = cart INTO n;
    SET i = 0;
    cartLoop: WHILE i < n DO
		SELECT amount FROM `CartRow` WHERE cart_id = cart LIMIT i,1 INTO amountToMove;
        SELECT Amount(product_id) FROM `CartRow` WHERE cart_id = cart LIMIT i,1 INTO invAmount;
        
        IF invAmount - amountToMove < 0 THEN
			ROLLBACK;
            SELECT "Not enough items in the inventory.";
            LEAVE cartLoop;
		ELSE
			INSERT INTO `OrderRow`(order_id, product_id, amount) SELECT newOrder, product_id, amount FROM `CartRow` WHERE cart_id = cart LIMIT i,1;
            UPDATE `Inventory` SET amount = amount - amountToMove WHERE product_id = (SELECT product_id FROM `OrderRow` WHERE id = LAST_INSERT_ID());
            SET i = i + 1;
        END IF;

   END WHILE;
    
    DELETE FROM `CartRow` WHERE cart_id = cart;
    COMMIT;

END
//


CREATE PROCEDURE deleteOrder(
	orderID INT
)
BEGIN

    DECLARE n INT DEFAULT 0;
    DECLARE i INT DEFAULT 0;
    DECLARE amountToMove INT;
    DECLARE productID INT;
	
	START TRANSACTION;
    
    UPDATE `Order` SET deleted = CURRENT_TIMESTAMP WHERE id = orderID;
    
    SELECT COUNT(*) FROM `OrderRow` WHERE order_id = orderID INTO n;
    SET i = 0;
    orderLoop: WHILE i < n DO
		SELECT amount FROM `OrderRow` WHERE order_id = orderID LIMIT i,1 INTO amountToMove;
        SELECT product_id FROM `OrderRow` WHERE order_id = orderID LIMIT i,1 INTO productID;
        
		UPDATE `Inventory` SET amount = amount + amountToMove WHERE product_id = productID;
		SET i = i + 1;

   END WHILE;
    
    COMMIT;

END
//


CREATE PROCEDURE getOrder(
	orderID INT
)
BEGIN
	
	SELECT
		O.id AS OrderNumber,
        O.created AS Created,
        O.updated AS updated,
        O.deleted AS deleted,
        O.delivery AS delivery,
		CONCAT(U.firstname, " ", U.lastname) AS CustomerName,
        U.email AS CustomerEmail
	FROM `Order` AS O
		INNER JOIN anax_users AS U
			ON O.user_id = U.id
	WHERE O.id = orderID;
    
    SELECT
		O.id AS OrderNumber,
		R.id AS OrderRow,
        P.image AS Image,
		P.description AS Description,
		R.amount AS Amount,
        P.price AS PriceEach,
        (P.price * R.amount) AS TotalPrice
	FROM `Order` AS O
		INNER JOIN OrderRow AS R
			ON O.id = R.order_id
		INNER JOIN Product AS P
			ON R.product_id = P.id
	WHERE O.id = orderID
	ORDER BY OrderRow;

END
//

DELIMITER ;





--
-- Procedure for getting inventory log.
--
DROP PROCEDURE IF EXISTS getInventoryLog;
DELIMITER //
CREATE PROCEDURE getInventoryLog()
BEGIN
	
	SELECT
		IL.id AS LogNumber,
        P.description AS Product,
        IL.amount AS ItemsLeft,
        IL.`when` AS `When`
	FROM `InventoryLog` AS IL
		INNER JOIN `Product` AS P
			ON IL.product_id = P.id
	WHERE Amount(IL.product_id) = IL.amount;

END
//

DELIMITER ;








--
-- Testing everything
--

-- No carts or cart rows
SELECT * FROM Cart;
SELECT * FROM CartRow;

-- Add to cart 1 and 2
CALL addToCart(1, 5, 48);
CALL addToCart(1, 7, 3);
CALL addToCart(1, 8, 7);

CALL addToCart(2, 1, 5);

-- Carts and cart rows exist now.
SELECT * FROM Cart;
SELECT * FROM CartRow;

-- Display cart 1 and 2.
CALL getCart(1);
CALL getCart(2);

-- Remove from cart 1
CALL removeFromCart(1, 8, 2);

-- Display cart 1 again, now only 5 items of item id 8
CALL getCart(1);

-- Still full inventory
SELECT *, Amount(id) FROM Product;


-- Now make an order


-- No orders yet.
SELECT * FROM `Order`;
SELECT * FROM OrderRow;

-- Create an order of cart 1 with user id 1
CALL createOrder(1, 1);

-- Check it
SELECT * FROM `Order`;
SELECT * FROM OrderRow;

-- The cart rows are gone for cart 1
SELECT * FROM CartRow;

-- The products have also been removed from the inventory
SELECT *, Amount(id) FROM Product;

-- Display the order
CALL getOrder(1);

-- Check the inventory log, only 2 items left of something.
CALL getInventoryLog();

-- Now delete the order
CALL deleteOrder(1);

-- Check it, deleted date is now set.
SELECT * FROM `Order`;

-- The products have also been returned to the inventory
SELECT *, Amount(id) FROM Product;
