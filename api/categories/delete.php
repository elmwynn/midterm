<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $deleteCategory = new Category($db);

    $data = json_decode(file_get_contents("php://input"));

    $deleteCategory->id = $data->id;

    if($deleteCategory->delete()){
        echo json_encode(array('id' => $deleteCategory->id));
    }
    else {
        echo json_encode(array('message'=> 'No Category Found'));
    }