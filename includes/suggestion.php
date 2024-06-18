<?php include "../admin/database/queries.php";

$query = $_GET['query'];

 



$result = $conn->query($sql);
$suggestions = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $suggestions[] = array(
            'title' => $row['post_title'],
            'ID' => $row['ID']
        );
    }
}

echo json_encode($suggestions);

$conn->close();
?>
