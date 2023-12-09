<?php

// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$database = "student_queue_system";

// Establish connection to the MySQL database server with the selected database
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection and handle errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data from the POST request
    $queueNumber = $_POST["queueNumber"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $department = $_POST["department"];
    $date = $_POST["date"];
    $time = $_POST["time"];

    // SQL query with placeholders for data binding
    $insertQuery = "INSERT INTO student_queue (queue_number, name, email, department, date, time) VALUES (?, ?, ?, ?, ?, ?)";
    
    // Prepare the SQL statement
    $stmt = mysqli_prepare($conn, $insertQuery);

    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "isssss", $queueNumber, $name, $email, $department, $date, $time);

    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        echo "Record added successfully!";
    } else {
        echo "Error adding record: " . mysqli_error($conn);
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($conn);

?>
