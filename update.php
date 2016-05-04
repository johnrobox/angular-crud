<?php
include 'connection.php';

$data = json_decode(file_get_contents('php://input'));

if (!isset($data->firstname) || empty($data->firstname)) {
    $response = array(
        'valid' => false,
        'message' => 'Firstname is required'
    );
} else if (!isset($data->lastname) || empty($data->lastname)) {
    $response = array(
        'valid' => false,
        'message' => 'Lastname is required'
    );
} else if (!isset($data->address) || empty($data->address)) {
    $response = array(
        'valid' => false,
        'message' => 'Address is required'
    );
} else {

    $id = $data->id;
    $firstname = $data->firstname;
    $lastname = $data->lastname;
    $address = $data->address;
    $update = $connection->query('UPDATE employees SET firstname ="'.$firstname.'", lastname="'.$lastname.'", address="'.$address.'" WHERE id='.$id);
    if ($update) {
        $response = array(
            'valid' => true,
            'message' => 'Update succecss.'
        );
    } else {
        $response = array(
            'valid' => false,
            'message' => 'Update error.'
        ); 
    } 
}

echo json_encode($response);
