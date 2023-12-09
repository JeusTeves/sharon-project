<?php
// Start or resume a session
session_start();

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
    // Retrieve username and password from the POST request
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to check if the entered credentials exist in the user_login table
    $query = "SELECT * FROM user_login WHERE username = '$username' AND password = '$password'";
    
    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if the query was successful and if any matching rows were found
    if ($result && mysqli_num_rows($result) > 0) {
        // Set the 'user' session variable with the username
        $_SESSION['user'] = $username;
        
        // Redirect to the student_management.php page
        header("Location: student_management.php");
        exit();
    } else {
        // If no matching rows were found, redirect to the login page with an error parameter
        header("Location: login.php?error=1");
        exit();
    }
} else {
    // If the form was not submitted using POST, redirect to the login page
    header("Location: login.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
