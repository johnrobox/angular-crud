<?php
include 'connection.php';

$data = $connection->query('SELECT * FROM employees');

$response = array();

while($row = mysqli_fetch_array($data)) {
    $response[] = $row;
}

echo json_encode($response);