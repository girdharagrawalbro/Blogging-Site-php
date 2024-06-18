<?php
include "../../database/queries.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $author = $_POST['author'];
    $id = $_POST['id'];

    $stmt = $conn->prepare("UPDATE category SET `name` = ?, `desc` = ?, author = ? WHERE ID = ?");
    $stmt->bind_param("sssi", $name, $desc, $author,$id);

    // Execute the update statement
    if ($stmt->execute()) {
        $msg = "Category updated successfully";
    } else {
        // Execution failed, add an error message to $errors array
        $msg = "Error Category post";
    }

    // Close the statement
    $stmt->close();
    echo json_encode(['msg' => $msg]);

}

?>
