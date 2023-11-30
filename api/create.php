<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    echo json_encode(
        array('message' =>'Method not allowed'));
    return;
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

include_once '../db/database.php';
include_once '../models/Todo.php';

$database = new Database();
$dbConnection = $database->connect();

$todo = new Todo($dbConnection);

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['task'])) {
    http_response_code(422);
    echo json_encode(
        array('message' => 'Error missing required parameter task in the JSON body')
    );
    return;
}

$todo->setTask($data['task']);
if ($todo->create()) {
    echo json_encode(
        array('message' => 'A todo item was created')
    );
} else {
    echo json_encode(
        array('message' => 'Error: No todo item was created')
    );
}