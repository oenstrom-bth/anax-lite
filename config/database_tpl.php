<?php
/**
 * Config file for Database.
 */
return [
    "dsn"             => "mysql:host=localhost;dbname=dbnamehere;",
    "username"        => "username",
    "password"        => "password",
    "driver_options"  => array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"),
];
