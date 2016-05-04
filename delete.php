<?php
include 'connection.php';

$data = json_decode(file_get_contents('php://input'));

if (!isset($data->id) || empty($data->id)) {
    $response = array(
        'valid' => false,
        'message' => 'Id required to delete item'
    );
 } else {
     $id = $data->id;
     $delete = $connection->query('DELETE FROM employees WHERE id ='.$id);
     if ($delete) {
         $response = array(
             'valid' => true,
             'message' => 'Delete success.'
         );
     } else {
         $response = array(
             'valid' => false,
             'message' => 'Error in delete action'
         );
     }
 }
 echo json_encode($response);
