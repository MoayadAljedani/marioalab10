<?php

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    header('Allow: DELETE');
    http_response_code(405);
    echo json_encode(
        array('message' =>'Method not allowed'));
    return;
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');

include_once '../db/database.php';
include_once '../models/Todo.php';

$database = new Database();
$dbConnection = $database->connect();

$todo = new Todo($dbConnection);

$data = json_decode(file_get_contents('php://DELETE'));
if(!$data || !$data->id){
    http_response_code(422);
    echo json_encode(
        array('message' => 'Error: Missing required parameters id in the JSON body')
    );
    return;
}

$todo->setId($data->id);
if($todo->delete()){
    echo json_encode(
        array('message' => 'The todo item was DELETED')
    );
} else {
    echo json_encode(
        array("message" => 'The todo item was not DELETED')
    );
}
