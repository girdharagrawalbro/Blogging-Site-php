<?php
$conn = mysqli_connect("localhost","root","", "blogging");   
// $conn = mysqli_connect("sql200.infinityfree.com","if0_36127326","BfFnyEFZOhipWv", "if0_36127326_blogging"); 

 if(!$conn){
    die("<script>alert('connection Failed.')</script>");
}

$result_post = mysqli_query($conn, "SELECT * FROM posts");
$result_category = mysqli_query($conn, "SELECT * FROM category");
$result_author = mysqli_query($conn, "SELECT * FROM author");
$result_queries = mysqli_query($conn, "SELECT * FROM queries");
$result_np_queries = mysqli_query($conn, "SELECT * FROM queries WHERE `status` = 'Not_Processed'");
$result_p_queries = mysqli_query($conn, "SELECT * FROM queries WHERE `status` = 'Processed'");

$result_comment = mysqli_query($conn, "SELECT * FROM comments");

// Fetch arrays for each table
$post_data = mysqli_fetch_all($result_post, MYSQLI_ASSOC);
$category_data = mysqli_fetch_all($result_category, MYSQLI_ASSOC);
$author_data = mysqli_fetch_all($result_author, MYSQLI_ASSOC);
$queries_data = mysqli_fetch_all($result_queries, MYSQLI_ASSOC);
$queries_p_data = mysqli_fetch_all($result_p_queries, MYSQLI_ASSOC);

$queries_np_data = mysqli_fetch_all($result_np_queries, MYSQLI_ASSOC);
$comment_data = mysqli_fetch_all($result_comment, MYSQLI_ASSOC);

// Get the number of rows for each fetched array
$num_post = count($post_data);
$num_category = count($category_data);
$num_author = count($author_data);
$num_queries = count($queries_data);
$num_p_queries = count($queries_p_data);
$num_np_queries = count($queries_np_data);

$num_comment = count($comment_data);

?>