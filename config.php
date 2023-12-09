<?php

// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$database = "student_queue_system";

// Establish connection to the MySQL database server
$conn = mysqli_connect($host, $username, $password);

// Check connection and handle errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create Database (if not exists)
$queryCreateDatabase = "CREATE DATABASE IF NOT EXISTS $database";
if (!mysqli_query($conn, $queryCreateDatabase)) {
    die("Error creating database: " . mysqli_error($conn));
}

// Select Database
if (!mysqli_select_db($conn, $database)) {
    die("Error selecting database: " . mysqli_error($conn));
}

// Create User Login Table (if not exists)
$queryCreateTableUserLogin = "CREATE TABLE IF NOT EXISTS user_login (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
if (!mysqli_query($conn, $queryCreateTableUserLogin)) {
    die("Error creating user_login table: " . mysqli_error($conn));
}

// Insert Admin User
$queryInsertAdminUser = "INSERT INTO user_login (username, password) VALUES ('admin', 'admin')";
if (!mysqli_query($conn, $queryInsertAdminUser)) {
    die("Error inserting admin user: " . mysqli_error($conn));
}

// Create Student Queue Table (if not exists)
$queryCreateTableStudentQueue = "CREATE TABLE IF NOT EXISTS student_queue (
    id INT PRIMARY KEY AUTO_INCREMENT,
    queue_number INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    course VARCHAR(50) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending'
)";
if (!mysqli_query($conn, $queryCreateTableStudentQueue)) {
    die("Error creating student_queue table: " . mysqli_error($conn));
}

// Close Database Connection
mysqli_close($conn);

?>
