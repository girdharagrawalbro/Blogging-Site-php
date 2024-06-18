<?php
include "../../database/queries.php";
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $commentId = $_POST['apr-id'];
    $currentStatus = $_POST['status']; // Get the current status

    // Toggle the status
    $newStatus = ($currentStatus === "Not_Processed") ? "Processed" : "Not_Processed";

    // Prepare and bind the SQL statement for updating the post
    $stmt = $conn->prepare("UPDATE queries SET `status` = ? WHERE `id`= ?");
    $stmt->bind_param("si", $newStatus, $commentId);

    // Execute the update statement
    if ($stmt->execute()) {
        $msg = "Query status updated successfully";
        echo json_encode(['success' => true, 'msg' => $msg, 'new_status' => $newStatus]);
    } else {
        // Execution failed, add an error message to $errors array
        $msg = "Error updating query status";
        echo json_encode(['success' => false, 'msg' => $msg]);
    }
    $stmt->close();
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'msg' => "Invalid request method"]);
}
?>
