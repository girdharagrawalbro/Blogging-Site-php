<?php
include "../../database/queries.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    $del_id = $_POST['del-id'];
        $stmt = $conn->prepare("DELETE FROM `category` WHERE ID = ?");
        $stmt->bind_param("i", $del_id);
     
        // Execute the delete statement
        if ($stmt->execute() === true) {
            $msg = "Category Deleted";
        } else {
            // Execution failed, add an error message to $errors array
            $msg = "Error deleting post";
        }
    
        // Close the statement
        $stmt->close();
echo json_encode(['msg' => $msg]);

    }   
    ?>