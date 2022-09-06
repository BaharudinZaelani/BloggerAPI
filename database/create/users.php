<?php 


$tables = [
    "id" => "int(6) NOT NULL AUTO_INCREMENT PRIMARY KEY",
    "user_name" => "VARCHAR(12)",
    "username" => "VARCHAR(34)",
    "password" => "TEXT",
    "created_at" => "TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"
];
