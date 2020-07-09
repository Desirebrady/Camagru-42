<?php
#!/usr/bin/php
include 'database.php';
// CREATE DATABASE
try {
    $conn = new PDO("mysql:host=$DB_DSN_LIGHT", $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS camagru";
    // use exec() because no results are returned
    $conn->exec($sql);
} catch (PDOException $e) {
    echo "ERROR CREATING DATABASE: " . $e->getMessage() . "Aborting process<br>";
}

try {

    $dbh = new PDO("mysql:host=$DB_DSN_LIGHT;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(100) NOT NULL,
            `email` varchar(100) NOT NULL,
            `verified` tinyint(1) NOT NULL DEFAULT '0',
            `token` varchar(255) DEFAULT NULL,
            `password` varchar(255) NOT NULL,
            `recieveCommEmail` varchar(255) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`)
        )";
    $dbh->exec($sql);
} catch (PDOException $e) {
    echo "ERROR CREATING USERS TABLE: " . $e->getMessage() . "Aborting process<br>";
}

try {

    $dbh = new PDO("mysql:host=$DB_DSN_LIGHT;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS  `password_reset` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `email` varchar(100) NOT NULL,
            `token` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
        )";
    $dbh->exec($sql);
} catch (PDOException $e) {
    echo "ERROR CREATING Password_RESET TABLE: " . $e->getMessage() . "Aborting process<br>";
}

try {

    $dbh = new PDO("mysql:host=$DB_DSN_LIGHT;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS  `images` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `username` VARCHAR(100) NOT NULL,
            `image` VARCHAR(100) NOT NULL,
            `like_count` int(11) NOT NULL
        )";
    $dbh->exec($sql);
} catch (PDOException $e) {
    echo "ERROR CREATING IMAGES TABLE: " . $e->getMessage() . "Aborting process<br>";
}
try {

    $dbh = new PDO("mysql:host=$DB_DSN_LIGHT;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS  `tbl_comment` (
            `comment_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `parent_comment_id` int(11) NOT NULL,
            `comment` varchar(200) NOT NULL,
            `comment_sender_name` varchar(40) NOT NULL,
            `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `image_id` int(11) DEFAULT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
          ";
    $dbh->exec($sql);
} catch (PDOException $e) {
    echo "ERROR CREATING COMMENTS TABLE: " . $e->getMessage() . "Aborting process<br>";
}
