<?php
include('config.php');

$host = "localhost";
$username = "root";
$password = "";
$database = "student_queue_system";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$errors = [];
$availableQueueNumber = findAvailableQueueNumber();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $requiredFields = ['name', 'email', 'department', 'date', 'time'];

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = "The '$field' field must be filled out.";
        }
    }
    if (empty($errors)) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $course = mysqli_real_escape_string($conn, $_POST['department']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $time = mysqli_real_escape_string($conn, $_POST['time']);

        $queryInsertQueue = "INSERT INTO student_queue (queue_number, name, email, course, date, time, status) VALUES ('$availableQueueNumber', '$name', '$email', '$course', '$date', '$time', 'Pending')";

        if (mysqli_query($conn, $queryInsertQueue)) {
            $availableQueueNumber++;
            $successPopup = true;
        } else {
            $errors[] = "Error: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);

function findAvailableQueueNumber() {
    global $conn;

    $queryMaxQueueNumber = "SELECT MAX(queue_number) FROM student_queue";
    $resultMaxQueueNumber = mysqli_query($conn, $queryMaxQueueNumber);
    $row = mysqli_fetch_array($resultMaxQueueNumber);
    $maxQueueNumber = $row[0];

    $availableQueueNumber = 0;

    $queryUsedQueueNumbers = "SELECT DISTINCT queue_number FROM student_queue";
    $resultUsedQueueNumbers = mysqli_query($conn, $queryUsedQueueNumbers);
    $usedQueueNumbers = [];

    while ($row = mysqli_fetch_assoc($resultUsedQueueNumbers)) {
        $usedQueueNumbers[] = $row['queue_number'];
    }

    while (in_array($availableQueueNumber, $usedQueueNumbers) && $availableQueueNumber <= $maxQueueNumber + 1) {
        $availableQueueNumber++;
    }

    return $availableQueueNumber;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Queue System</title>
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
        }
        * {
    margin: 0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 10%;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url(nemsu1.jpg);
            background-repeat:no-repeat;
            background-attachment:fixed;
            background-size:100% 100%;
            overflow: hidden;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
           
        }

        .container {
            display: flex;
            flex-direction:column;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 25px;
            box-shadow: inset -5px -5px rgba(0, 0, 0, 0.5);
            padding: 20px;
            width: 25%;
            text-align: center;
            margin: auto;
            position:absolute;
            top: 22%;
            z-index: 1;
            
        }

        
        .form{
            color: white;
            font-family: initial;
            font-size: 22px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            text-align: left;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 2px solid #0004ff;
            border-radius: 4px;
            text-align: center;
        }

        button {
            background-color: blue;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            border: 2px solid white;
            width: 150px;
            height: 43px;
        }

        button:hover {
            background-color: black;
            color:white;
            border: 2px solid red;
            
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }

        a {
            text-decoration: none;
            color: #4caf50;
            font-weight: bold;
            display: block;
            margin-top: 10px;
            color:aqua;
        }

        a:hover {
            color: white;
        }

        @media (max-width: 480px) {
            .container {
                width: 90%;
            }
        }
        .box{
            position: relative;
            width: 40vw;
            height: 11vh;
            display: flex;
            justify-content: center;
            align-items: center;
            top: -60%; 
            margin: auto; 
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 25px;
            box-shadow: inset -5px -5px rgba(0, 0, 0, 0.5);
            z-index: 1;
           
        }
        .box h2 {
            color:#fff;
            font-size: 1.8em;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-shadow: 0 0 10px #00b3ff,
                        0 0 20px #00b3ff,
                        0 0 40px #00b3ff,
                        0 0 80px #00b3ff,
                        0 0 120px #00b3ff;
            margin: 0;
        }
        body, .form, label, button {
        font-size: 1.3rem;
        }
        .lightbar {
            position: absolute;
            top:0;
            left:0;
            width: 10px;
            height: 100%;
            border-radius: 10px;
            background: #fff;
            z-index:2;
            box-shadow: 0 0 10px #00b3ff,
                        0 0 20px #00b3ff,
                        0 0 40px #00b3ff,
                        0 0 80px #00b3ff,
                        0 0 120px #00b3ff;
            animation: animatelightbar 5s linear infinite;
        }
        @keyframes animatelightbar
        {
            0%,5%
            {
                transform: scaleY(0) translateX(0);
            }
            10%
            {
                transform: scaleY(1) translateX(0);
            }
            90%
            {
                transform: scaleY(1) translateX(calc(600px -
                10px));
            }
            95%,100%
            {
                transform: scaleY(0) translateX(calc(600px -
                10px));
            }
        }
        .topLayer{
            
            position: absolute;
            top:0;
            left:0;
            width: 100%;
            height: 100%;
            background:hidden;
            animation: animatetopLayer 10s linear infinite;
        }
        @keyframes animatetopLayer
        {
            0%,2.5%
            {
                transform:  translateX(0);
            }
            5%
            {
                transform:  translateX(0);
            }
            45%
            {
                transform:  translateX(100%);
                
            }
            47.5%,50%
            {
                transform:  translateX(100%);
            }

           50.001%,52.5%
            {
                transform:  translateX(-100%);
            }
            55%
            {
                transform:  translateX(-100%);
            }
            95%
            {
                transform:  translateX(0%);
                
            }
            97.5%,100%
            {
                transform:  translateX(0%);
            }
        }
    </style>
</head>
<body>
<div class="box">
        <div class="lightbar"></div>
        <div class="topLayer"></div>
        <h2>Student Queue System</h2>
    </div>
    <div class="container">
        <?php
        if (!empty($errors)) {
            echo '<div class="error-message">';
            foreach ($errors as $error) {
                echo '<p>' . $error . '</p>';
            }
            echo '</div>';
        }

        if (isset($successPopup)) {
            echo '<script>
            if (confirm("Form submitted successfully! Go to waiting list?")) {
                window.location.href = "waiting_list.php";
            } else {
                window.location.href = "index.php";
            }
            </script>';
        }
        ?>
        <div class="form">
        <form action="index.php" method="post">
            <div class="queue">
            <label for="queueNumber">Queue Number:</label>
            <input style="color:white; font-size:15px"type="text" name="queueNumber" value="<?php echo $availableQueueNumber; ?>" readonly class="center-input" disabled>
            </div>
            <label for="name">Name:</label>
            <input type="text" placeholder="Enter Your Name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" placeholder="Enter Your Email" name="email" required>

            <label for="department">Department:</label>
            <select name="department" required>
                <option value="" disabled selected>Select a Department</option>
                <option value="Industrial Technology">Department of Industrial Technology</option>
                <option value="General Teacher Training">Department of General Teacher Training</option>
                <option value="Business & Management">Department Of Business & Management</option>
                <option value="Computer Studies">Department of Computer Studies</option>
                <option value="Public Administration">Department of Public Administration</option>
                <option value="Criminal Justice Education">Department of Criminal Justice Education</option>
            </select>

            <label for="date">Date:</label>
            <input type="date" name="date" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>

            <label for="time">Time:</label>
            <select name="time" required>
                <option value="08:00">8am</option>
                <option value="13:00">1pm</option>
            </select>

            <div style="display: flex; justify-content: space-between; align-items: center;">
    <form action="index.php" method="post">
        <button type="submit">Submit</button>
    </form>

    <form action="waiting_list.php" method="post">
        <button type="submit" style="margin-left: 10px;">Waiting List</button>
    </form>
</div>

<a href="student_management.php">Student Management</a>
</div>
</body>
</html>
