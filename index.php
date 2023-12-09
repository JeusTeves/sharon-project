<?php
// Include the configuration file (assumed to contain functions and constants)
include('config.php');

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

// Array to store validation errors
$errors = [];

// Find the available queue number using the defined function
$availableQueueNumber = findAvailableQueueNumber();

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Array of required form fields
    $requiredFields = ['name', 'email', 'department', 'date', 'time'];

    // Validate required fields
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = "The '$field' field must be filled out.";
        }
    }

    // If no validation errors, proceed with form submission
    if (empty($errors)) {
        // Retrieve form data
        $name = $_POST['name'];
        $email = $_POST['email'];
        $course = $_POST['department'];
        $date = $_POST['date'];
        $time = $_POST['time'];

        // SQL query to insert a new record into the 'student_queue' table
        $queryInsertQueue = "INSERT INTO student_queue (queue_number, name, email, course, date, time, status) VALUES ('$availableQueueNumber', '$name', '$email', '$course', '$date', '$time', 'Pending')";

        // Execute the insert query
        if (mysqli_query($conn, $queryInsertQueue)) {
            // Increment the available queue number for the next submission
            $availableQueueNumber++;
            // Set a flag to display a success popup
            $successPopup = true;
        } else {
            // Add an error message if the insert query fails
            $errors[] = "Error: " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);

// Function to find the available queue number
function findAvailableQueueNumber() {
    global $conn;

    // Query to find the maximum queue number in the 'student_queue' table
    $queryMaxQueueNumber = "SELECT MAX(queue_number) FROM student_queue";
    $resultMaxQueueNumber = mysqli_query($conn, $queryMaxQueueNumber);
    $row = mysqli_fetch_array($resultMaxQueueNumber);
    $maxQueueNumber = $row[0];

    // Initialize the available queue number
    $availableQueueNumber = 0;

    // Query to find distinct used queue numbers in the 'student_queue' table
    $queryUsedQueueNumbers = "SELECT DISTINCT queue_number FROM student_queue";
    $resultUsedQueueNumbers = mysqli_query($conn, $queryUsedQueueNumbers);
    $usedQueueNumbers = [];

    // Store used queue numbers in an array
    while ($row = mysqli_fetch_assoc($resultUsedQueueNumbers)) {
        $usedQueueNumbers[] = $row['queue_number'];
    }

    // Find the first available queue number not in use
    while (in_array($availableQueueNumber, $usedQueueNumbers) && $availableQueueNumber <= $maxQueueNumber + 1) {
        $availableQueueNumber++;
    }

    return $availableQueueNumber;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- HTML head section with meta tags and styles -->
    <!-- ... (styles not included for brevity) ... -->
</head>
<body>
    <!-- HTML body section -->
    <div class="container">
        <h2>Student Queue System</h2>

        <?php
        // Display validation errors if any
        if (!empty($errors)) {
            echo '<div class="error-message">';
            foreach ($errors as $error) {
                echo '<p>' . $error . '</p>';
            }
            echo '</div>';
        }

        // Display a success popup if the form was submitted successfully
        if (isset($successPopup)) {
            echo '<script>alert("Form submitted successfully!");</script>';
        }
        ?>

        <!-- HTML form for student queue submission -->
        <form action="index.php" method="post">
            <!-- Form fields, some pre-filled with data -->
            <label for="queueNumber">Queue Number:</label>
            <input type="text" name="queueNumber" value="<?php echo $availableQueueNumber; ?>" readonly class="center-input" disabled>

            <!-- ... (other form fields) ... -->

            <!-- Submit button -->
            <button type="submit">Submit</button>
        </form>

        <!-- Link to the student management page -->
        <a href="student_management.php">Student Management</a>
    </div>
</body>
</html>
