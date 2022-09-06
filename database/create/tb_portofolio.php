<?php 

$tables = [
    "id" => "int NOT NULL AUTO_INCREMENT PRIMARY KEY",
    "user_id" => "int NOT NULL",
    "file_name" => "text",
    "description" => "text",
    "created_at" => "TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
    "FOREIGN KEY (user_id)" => "REFERENCES users(id)" 
];