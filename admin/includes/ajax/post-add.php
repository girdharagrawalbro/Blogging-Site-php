<?php
include "../../database/queries.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $category = $_POST['category'];
    $author = $_POST['author'];
    $publish = isset($_POST['publish']) ? "Published" : "Not-published";
    
    // Prepare the SQL statement with the correct number of placeholders
    $stmt = $conn->prepare("INSERT INTO posts (post_title, post_content, post_category, post_author, post_status) VALUES (?, ?, ?, ?, ?)");
    
    // Bind parameters to the placeholders
    $stmt->bind_param("sssss", $title, $body, $category, $author, $publish);

    // Execute the insert statement
    if ($stmt->execute() === true) {
        $msg = "New post uploaded successfully";
    } else {
        // Execution failed, add an error message to $msg variable
        $msg = "Error uploading post";
    }

    // Close the statement
    $stmt->close();

    // Return JSON response
    echo json_encode(['msg' => $msg]);
}
?>
