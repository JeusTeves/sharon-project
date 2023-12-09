<?php
// Start or resume a session
session_start();

// Check if a user is not logged in, redirect to the login page
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

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

// SQL query to select all data from the student_queue table
$querySelectData = "SELECT * FROM student_queue";
$result = mysqli_query($conn, $querySelectData);

// Check if the query was successful
if (!$result) {
    die("Error selecting data: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for character set and viewport settings -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Title for the page -->
    <title>Student Management</title>
    
    <!-- Styles for the page -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4caf50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #4caf50;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            color: #45a049;
        }

        .delete-link {
            color: red;
            cursor: pointer;
        }

        .delete-link:hover {
            color: darkred;
        }
    </style>
</head>
<body>
    <!-- Heading for the student management page -->
    <h2>Student Management</h2>

    <!-- Table to display student data -->
    <table>
        <tr>
            <th>Queue Number</th>
            <th>Name</th>
            <th>Email</th>
            <th>Course</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php
        // Loop through the result set and display data in table rows
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td style='text-align: center;'>{$row['queue_number']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['course']}</td>";
            echo "<td>{$row['date']}</td>";
            // Convert 24-hour time format to 12-hour time format
            $time_12_hour = DateTime::createFromFormat('H:i:s', $row['time'])->format('h:i A');
            echo "<td>{$time_12_hour}</td>";
            echo "<td>{$row['status']}</td>";
            // Create links for editing and deleting records
            echo "<td><a href='edit_record.php?id={$row['id']}'>Edit</a> | <a class='delete-link' onclick='confirmDelete({$row['id']})'>Delete</a></td>";
            echo "</tr>";            
        }
        ?>
    </table>

    <!-- Logout link -->
    <a href="logout.php">Logout</a>

    <!-- JavaScript function to confirm record deletion -->
    <script>
        function confirmDelete(recordId) {
            var confirmation = confirm("Are you sure you want to delete this record?");
            if (confirmation) {
                window.location.href = "delete_record.php?id=" + recordId;
            }
        }
    </script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
