<?php
include "../../database/queries.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        $title = $_POST['title'];
    $body = $_POST['body'];
    $category = $_POST['category'];
    $author = $_POST['author'];
    $publish = isset($_POST['publish']) ? "Published" : "Not-published";
    $post_id = $_POST['post_id'];
    // Prepare and bind the SQL statement for updating the post
    $stmt = $conn->prepare("UPDATE posts SET post_title = ?, post_content = ?, post_category = ?, post_author = ?, `post_status` = ? WHERE  ID = ?");
    $stmt->bind_param("sssssi", $title, $body, $category, $author, $publish, $post_id);

    // Execute the update statement
    if ($stmt->execute()) {
        $msg = "Post updated successfully";
    } else {
        // Execution failed, add an error message to $errors array
        $msg = "Error updating post";
    }
    
    // Close the statement
    $stmt->close();
    echo json_encode(['msg' => $msg]);

}
function createSlug($title) {
    // Convert title to lowercase
    $slug = strtolower($title);
    
    // Replace spaces with hyphens
    $slug = str_replace(' ', '-', $slug);
    
    // Remove special characters
    $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);
    
    // Remove consecutive hyphens
    $slug = preg_replace('/-+/', '-', $slug);
    
    return $slug;
}
?>
