<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $deleteAuthor = new Author($db);

    $data = json_decode(file_get_contents("php://input"));
    //put request from user into data

    $deleteAuthor->id = $data->id;

    if($deleteAuthor->delete()){
        echo json_encode(array('id' => $deleteAuthor->id));
     //if author was successfully deleted, output author id
    }
    else {
        echo json_encode(array('message'=> 'author_id Not Found'));
        //if author was not deleted, meaning author_id was not found, report fialure
    }