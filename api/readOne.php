<?php

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Allow: GET');
    http_response_code(405);
    echo json_encode(
        array('message' =>'Method not allowed'));
    return;
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');

include_once '../db/database.php';
include_once '../models/Todo.php';

$database = new Database();
$dbConnection = $database->connect();

$todo = new Todo($dbConnection);

if (!isset($_GET['id'])) {
    http_response_code(422);
    echo json_encode(
        array('message' => 'Error missing required query parameter id.')
    );
    return;
}

$todo->setId($_GET['id']);
if ($todo->readOne()) {
    $result = array(
        'id' => $todo->getId(),
        'task' => $todo->getTask(),
        'dateAdded' => $todo->getDateAdded(),
        'done' => $todo->getDone()
    );
    echo json_encode($result);
} else {
    http_response_code(404);
    echo json_encode(
        array('message' => 'Error: No such todo item')
    );
}
