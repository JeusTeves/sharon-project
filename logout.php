<?php
// Start or resume a session
session_start();

// Destroy all data registered to a session
session_destroy();

// Redirect to the login.php page
header("Location: login.php");

// Exit the script to ensure no further code is executed
exit();
?>
