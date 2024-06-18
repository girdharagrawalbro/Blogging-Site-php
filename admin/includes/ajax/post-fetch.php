<?php 
include "../../database/queries.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch all posts
    $stmt = $conn->prepare("SELECT * FROM posts");
    $stmt->execute();
    $result = $stmt->get_result();

    $posts = array();
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }

    // Close the statement
    $stmt->close();

    // Get the count of posts
    $postCount = count($posts);

    // Return JSON response with posts data and count
    echo json_encode(['posts' => $posts, 'count' => $postCount]);
}
?>
        