<!doctype html>
<html lang="en">
<?php include "admin/database/queries.php"; 
$query = "";
    $nodata = false;
// Check if the search query is provided in the URL
if(isset($_POST['submit'])) {
    // Sanitize the search query to prevent SQL injection
   $query = mysqli_real_escape_string($conn, $_POST['query']);
    // // Query to fetch posts matching the search query
    $sql = "SELECT * FROM posts WHERE post_title LIKE '%$query%' OR post_content LIKE '%$query%' OR post_category LIKE '%$query%' and post_status = 'Published'"; 
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
    //     // Fetch search results
        $postdata = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
     $nodata =true; 
        $postdata = [];
    }
} elseif(isset($_GET['category']))
{
    $category = $_GET['category'];
    $sql = "SELECT * FROM posts where post_category = '$category' and post_status = 'Published'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $postdata = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
else{
    $nodata =true; 
    $postdata = [];
}
}
else{
    // $resultpost = mysqli_query($conn, "SELECT * FROM posts where `post_status` = 'Published'");
    $resultpost = mysqli_query($conn, "SELECT * FROM posts WHERE post_status = 'Published' ORDER BY post_date DESC LIMIT 6");

    $postdata = mysqli_fetch_all($resultpost, MYSQLI_ASSOC);
}
?>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
        <title>Learn Coding</title>
    </head>
    <body>
        <?php include "includes/header.php"; ?>
        <div class="bg-image">
            <h1 class="text-center text-white" id="head-text">
                <?php 
            if(isset($_POST['submit'])) {
                echo "Search Result for '". $query . "'";
            }elseif(isset($_GET['category'])){
                echo "Search Result for Category '". $category . "'";
            }
            else {
                echo "Code With Girdhar";
            }
            ?>
            </h1>
        </div>
        <div class="contain">
            
    <div class="post-list">
        <?php 
        if($nodata == true){
            echo "<p>No Data Found</p>";
        } else {
            foreach ($postdata as $row) {
                echo "
                <a class='nav-link text-dark' href='post.php?id=".$row['ID']."'>
                <div class='card mb-3'>
                <div class='card-body'>
                            <h5 class='card-title'>".$row['post_category']."</h5>
                            <h2 class='card-title'>".$row['post_title']."</h2>
                            <p class='post-content'>".$row['post_content']."</p>
                            <a href='post.php?id=".$row['ID']."' class='read-more'>Read More</a>
                            <h5 class='card-text'>On ".$row['post_date']."</h5>
                </div>
            </div>
                </a>";
            }
        }
        ?>
    </div>
    <?php include "includes/sidebar.php"; ?>
</div>
        <?php include "includes/footer.php"; ?>
    </body>
    </html>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    var postContents = document.querySelectorAll('.post-content');
    var maxLength = 200; // Maximum length of text to display
    postContents.forEach(function(postContent) {
        if (postContent.textContent.length > maxLength) {
            var truncatedText = postContent.textContent.substring(0, maxLength);
            postContent.textContent = truncatedText + '...';
        }
    });
});
    </script>
