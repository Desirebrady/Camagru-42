<?php
#!/usr/bin/php
include 'database.php';
// CREATE DATABASE
try {
    $conn = new PDO("mysql:host=$DB_DSN_LIGHT", $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE camagru";
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Database created successfully<br>";
    }
catch(PDOException $e)
    {
    echo "ERROR CREATING DATABASE: ".$e->getMessage()."\nAborting process\n<br>";
	}
	
try {
        // Connect to DATABASE previously created
        $dbh = new PDO("mysql:host=$DB_DSN_LIGHT;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE TABLE `users` (
          `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `username` VARCHAR(50) NOT NULL,
          `password` VARCHAR(255) NOT NULL,
		  `email` VARCHAR(100) NOT NULL,
		  `confirm_mail` VARCHAR(1) NOT NULL DEFAULT 'N',
          `token` VARCHAR(50) NOT NULL
        )";
        $dbh->exec($sql);
        echo "Table users created successfully\n";
	}
catch (PDOException $e) {
    echo "ERROR CREATING TABLE: ".$e->getMessage()."\nAborting process\n";
    }

$conn = null;
?>