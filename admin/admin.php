<?php
session_start();

// Check if the user is not logged in as admin
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    // Redirect the user to the login page
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">

    <title>Admin Dashboard</title>
</head>

<body>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <nav class="navbar navbar-dark bg-dark px-3 fixed-top" id="header">
        <a class="navbar-brand" href="#">
            <h3 class="">Code With Girdhar</h3>
        </a> <a class="navbar-brand" href="#">
            <h3 class="">Admin Panel</h3>
        </a> <a class="navbar-brand" href="logout.php">
            <button class="btn btn-danger">Logout</button>

        </a>

    </nav>
    <div class="contain">
        
        <div class="sidenav">
            <ul style="padding:0;">
                <li class="menu-item open" onclick="changeFrameSrc('includes/dashboard.php')">Dashboard</li>
                <li class="menu-item" onclick="changeFrameSrc('includes/post.php')">Posts</li>
                <li class="menu-item" onclick="changeFrameSrc('includes/categories.php')">Categories</li>
                <li class="menu-item" onclick="changeFrameSrc('includes/comments.php')">Comments</li>
                <li class="menu-item" onclick="changeFrameSrc('includes/queries.php')">Queries</li>
                <li class="menu-item" onclick="changeFrameSrc('includes/settings.php')">Settings</li>
            </ul>
        </div>

        <div class="main">
            <iframe id="frame" src="includes/dashboard.php" frameborder="0"></iframe>
        </div>
    </div>
</body>

</html>

<script>
function changeFrameSrc(src) {
    document.getElementById('frame').src = src;
    // Remove any existing 'open' class
    var menuItems = document.querySelectorAll('.menu-item');
    menuItems.forEach(function(item) {
        item.classList.remove('open');
    });
    // Add 'open' class to the clicked item
    event.currentTarget.classList.add('open');
}
function reloadIframe() {
            var iframe = document.getElementById('frame');
            iframe.contentWindow.postMessage('reload', '*');
        }
</script>