<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Metadata for character set and viewport settings -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Styles for the page -->
    <style>
        /* Styling for the entire body */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Styling for the login container */
        .login-container {
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
        }

        /* Styling for the heading */
        h2 {
            text-align: center;
            color: #333;
        }

        /* Styling for the form */
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Styling for labels */
        label {
            margin-top: 10px;
            color: #333;
        }

        /* Styling for input fields */
        input {
            margin: 8px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 250px;
        }

        /* Styling for the login button */
        button {
            margin-top: 15px;
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Hover effect for the login button */
        button:hover {
            background-color: #45a049;
        }

        /* Styling for the index link */
        .index-link {
            text-align: center;
            margin-top: 15px;
        }

        /* Styling for the index link anchor tag */
        .index-link a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
    </style>
    
    <!-- Title for the page -->
    <title>Login</title>
</head>
<body>
    <!-- Container for the login content -->
    <div class="login-container">
        <!-- Heading for the login page -->
        <h2>Login</h2>
        
        <!-- Login form -->
        <form action="process_login.php" method="post">
            <!-- Label and input field for username -->
            <label for="username">Username:</label>
            <input type="text" name="username" placeholder="Enter your username" required>
            
            <!-- Label and input field for password -->
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Enter your password" required>
            
            <!-- Submit button for the form -->
            <button type="submit">Login</button>
        </form>

        <!-- Link to navigate to the index page -->
        <div class="index-link">
            <a href="index.php">Go to Index</a>
        </div>
    </div>
</body>
</html>
