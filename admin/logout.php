<?php
session_start(); // Start the session
session_abort();
session_destroy();

    header("Location: index.php"); // Redirect to login page

    exit(); // Stop further execution

?>
