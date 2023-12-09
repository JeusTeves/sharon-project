<?php
// Start or resume a session
session_start();

// Check if a user is not logged in; redirect to login page if not
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$database = "student_queue_system";

// Establish connection to the MySQL database server with selected database
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection and handle errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $recordId = $_GET['id'];

    // Query to delete a record from the 'student_queue' table based on the provided ID
    $queryDeleteRecord = "DELETE FROM student_queue WHERE id = $recordId";

    // Execute the delete query
    if (mysqli_query($conn, $queryDeleteRecord)) {
        // Redirect to the student management page after successful deletion
        header("Location: student_management.php");
        exit();
    } else {
        // Terminate script execution and display an error message if deletion fails
        die("Error deleting record: " . mysqli_error($conn));
    }
} else {
    // Terminate script execution if 'id' parameter is not provided in the URL
    die("Invalid request. Record ID not provided.");
}

// Close Database Connection
mysqli_close($conn);
?>
