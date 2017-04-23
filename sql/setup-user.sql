USE olen16;

DROP TABLE IF EXISTS anax_users;

CREATE TABLE anax_users
(
	id					INT PRIMARY KEY AUTO_INCREMENT,
    authority		VARCHAR(16) NOT NULL DEFAULT 'user',
    username	VARCHAR(64) UNIQUE NOT NULL,
    password		VARCHAR(255) NOT NULL,
    firstname		VARCHAR(64),
    lastname		VARCHAR(64),
    email			VARCHAR(255) UNIQUE NOT NULL,
    birthday		DATE,
    bio				TEXT,
    isBanned		BOOL DEFAULT false
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

INSERT INTO
	anax_users(authority, username, password, firstname, lastname, email)
VALUES
('admin', 'admin', '$2y$10$V1O35gaDqEqtqWpPU1YXjemzNs3w6pYW9wgW53Gg893Kjn8d3/W9i', 'Admin', 'Adminsson', 'admin@adminsson.se'),
('user', 'oenstrom', '$2y$10$rjxELKzpGhuvjlcv6VKx9..FklnGKbfBgu1s6A3qrnTLu.WxBQwxS', 'Olof', 'Enström', 'olof.enstrom@gmail.com'),
('user', 'doe', '$2y$10$sb9FpMF2/zala3cfHrA.W.XZa7aFuBGx4B9Jl5DTyAZhw5oIAB/N2', 'doe', 'doesson', 'doe@doesson.com');