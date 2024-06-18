<?php
include "../../database/queries.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $author = $_POST['author'];
   $stmt = $conn->prepare("INSERT INTO category (`name`, `desc`, author) VALUES (?, ?, ?)");
   $stmt->bind_param("sss", $name, $desc, $author);

   // Execute the insert statement
   if ($stmt->execute() === true) {
       $msg = "New Category uploaded successfully";
   } else {
       // Execution failed, add an error message to $errors array
       $msg = "Error uploading category";
   }

   // Close the statement
   $stmt->close();


// Return JSON response
echo json_encode(['msg' => $msg]);
}


?>
