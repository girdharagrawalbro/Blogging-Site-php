<?php 
include "../admin/database/queries.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch all posts
    $stmt = $conn->prepare("SELECT * FROM comment");
    $stmt->execute();
    $result = $stmt->get_result();

    $comment = array();
    while ($row = $result->fetch_assoc()) {
        $comment[] = $row;
    }

    // Close the statement
    $stmt->close();

    // Get the count of posts
    $commentcount = count($comment);

    // Return JSON response with posts data and count
    echo json_encode(['comment' => $comment, 'count' => $commentcount]);
}
?>
        