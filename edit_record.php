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

    // Query to select a record from the 'student_queue' table based on the provided ID
    $querySelectRecord = "SELECT * FROM student_queue WHERE id = $recordId";
    $result = mysqli_query($conn, $querySelectRecord);

    // Check if there's an error in selecting the record
    if (!$result) {
        die("Error selecting record: " . mysqli_error($conn));
    }

    // Check if the record exists
    if (mysqli_num_rows($result) > 0) {
        $record = mysqli_fetch_assoc($result);
    } else {
        die("Record not found.");
    }
} else {
    // Terminate script execution if 'id' parameter is not provided in the URL
    die("Invalid request. Record ID not provided.");
}

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $status = $_POST['status'];

    // Query to update the record in the 'student_queue' table
    $queryUpdateRecord = "UPDATE student_queue SET name='$name', email='$email', course='$course', date='$date', time='$time', status='$status' WHERE id=$recordId";

    // Execute the update query
    if (mysqli_query($conn, $queryUpdateRecord)) {
        // Redirect to the student management page after successful update
        header("Location: student_management.php");
        exit();
    } else {
        // Terminate script execution and display an error message if update fails
        die("Error updating record: " . mysqli_error($conn));
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
    <style>
        /* Styles for the HTML form */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        form {
            width: 50%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <!-- HTML form to edit and update the record -->
    <h2>Edit Record</h2>

    <form action="" method="post">
        <!-- Input fields pre-filled with existing record values -->
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $record['name']; ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $record['email']; ?>" required>

        <label for="course">Course:</label>
        <input type="text" name="course" value="<?php echo $record['course']; ?>" required>

        <label for="date">Date:</label>
        <input type="date" name="date" value="<?php echo $record['date']; ?>" required>

        <label for="time">Time:</label>
        <input type="time" name="time" value="<?php echo $record['time']; ?>" required>

        <label for="status">Status:</label>
        <!-- Dropdown menu with options and pre-selected value -->
        <select name="status" required>
            <option value="Pending" <?php if ($record['status'] === 'Pending') echo 'selected'; ?>>Pending</option>
            <option value="Completed" <?php if ($record['status'] === 'Completed') echo 'selected'; ?>>Completed</option>
            <option value="Cancelled" <?php if ($record['status'] === 'Cancelled') echo 'selected'; ?>>Cancelled</option>
        </select>

        <!-- Form submission and cancellation buttons -->
        <button type="submit">Save Changes</button>
        <a href="student_management.php"><button type="button">Cancel</button></a>
    </form>
</body>
</html>

<?php
// Close Database Connection
mysqli_close($conn);
?>
