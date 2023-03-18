<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    $database = new Database();
    $db = $database->connect();

    $deleteQuote = new Quote($db);

    $data = json_decode(file_get_contents("php://input"));

    $deleteQuote->id = $data->id;

    if($deleteQuote->delete()){
        echo json_encode($deleteQuote->id);
    }
    else {
        echo json_encode(array('message'=> 'No Quote Found'));
    }