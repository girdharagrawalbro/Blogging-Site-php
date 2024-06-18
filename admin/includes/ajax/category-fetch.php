<?php 
include "../../database/queries.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch all posts
    $stmt = $conn->prepare("SELECT * FROM category");
    $stmt->execute();
    $result = $stmt->get_result();

    $category = array();
    while ($row = $result->fetch_assoc()) {
        $category[] = $row;
    }

    // Close the statement
    $stmt->close();

    // Get the count of posts
    $categorycount = count($category);

    // Return JSON response with posts data and count
    echo json_encode(['category' => $category, 'count' => $categorycount]);
}
?>
        