<?php
include 'connection.php';

$data = json_decode( file_get_contents('php://input') );

if (!isset($data->firstname) || empty($data->firstname)) {
    $response = array(
        'valid' => false,
        'message' => 'Firstname is required.'
    );
} else if (!isset($data->lastname) || empty($data->lastname)) {
    $response = array(
        'valid' => false,
        'message' => 'Lastname is required.'
    );
} else if (!isset($data->address) || empty($data->address)) {
    $response = array(
        'valid' => false,
        'message' => 'Address is required.'
    );
} else {
    $firstname = $data->firstname;
    $lastname = $data->lastname;
    $address = $data->address;
    $insert = $connection->query('INSERT INTO employees (firstname, lastname, address) VALUES ("'.$firstname.'","'.$lastname.'","'. $address.'")');
    if ($insert) {
        $response = array(
            'valid' => true,
            'message' => 'Employee add success'
            );
    } else {
        $response = array(
            'valid' => false,
            'message' => 'Error in adding employee .'
        );
    }
}
echo json_encode($response);