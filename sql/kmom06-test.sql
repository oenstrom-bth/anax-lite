USE olen16;


--
-- anax_content --> deleted -index
-- anax_content --> published -index
-- anax_content --> type -index
--
SHOW CREATE TABLE anax_content;
SHOW INDEX FROM anax_content;
DROP INDEX index_published ON anax_content;
DROP INDEX index_deleted ON anax_content;
CREATE INDEX index_published ON anax_content(published);
CREATE INDEX index_deleted ON anax_content(deleted);


SELECT * FROM anax_content WHERE type = 'post' AND published <= NOW() AND (deleted IS NULL OR deleted > NOW());
EXPLAIN SELECT * FROM anax_content WHERE type = 'post' AND published <= NOW() AND (deleted IS NULL OR deleted > NOW());

EXPLAIN SELECT * FROM anax_content FORCE INDEX (index_published, index_deleted) WHERE type = 'post' AND published <= NOW() AND (deleted IS NULL OR deleted > NOW());

EXPLAIN SELECT * FROM anax_content WHERE type = 'post' AND published <= NOW() AND (deleted IS NULL OR deleted > NOW());
SELECT * FROM anax_content WHERE type = 'post' AND published <= NOW() AND (deleted IS NULL OR deleted > NOW());

SELECT * FROM anax_content WHERE published <= NOW();
EXPLAIN SELECT * FROM anax_content  FORCE INDEX (index_published) WHERE published <= NOW();
EXPLAIN SELECT * FROM anax_content WHERE published <= NOW();

SELECT * FROM anax_content  FORCE INDEX (index_published) WHERE published <= NOW();
SELECT * FROM anax_content WHERE published <= NOW();

EXPLAIN SELECT * FROM anax_users WHERE username = "oenstrom";


-- Först 14(alla), sen 1? -- Index på deleted och type
SELECT * FROM anax_content WHERE deleted <= NOW() AND type = 'page';
EXPLAIN SELECT * FROM anax_content WHERE deleted <= NOW();



CREATE INDEX index_type ON anax_content(type);
-- Först 14(alla), sen 1? -- Index på 'type'
SELECT * FROM anax_content WHERE type = 'block';
EXPLAIN SELECT * FROM anax_content WHERE type = 'block';




EXPLAIN SELECT
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
	ORDER BY P.id;
    

SELECT amount FROM Product AS P INNER JOIN Inventory AS Inv ON Inv.product_id = P.id WHERE P.id = 2;
EXPLAIN SELECT amount FROM Inventory WHERE product_id = 2;
