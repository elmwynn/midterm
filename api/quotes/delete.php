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
    //retreive data from request

    $deleteQuote->id = $data->id;
    //set data

    if($deleteQuote->delete()){
        echo json_encode(array('id' => $deleteQuote->id));
        //if call to delete successful
    }
    else {
        echo json_encode(array('message'=> 'No Quotes Found'));
        //if call to delete fails, then no quotes with that id have been found
    }