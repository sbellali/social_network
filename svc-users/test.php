<?php

// URI connection string
$dsn = 'mysql://user_db_user:password@localhost:3306/user_db';

// PDO options
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

// Create a PDO instance
try {
    $pdo = new PDO($dsn,null, null, $options);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
