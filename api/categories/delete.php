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
    //store data from request
    $deleteCategory->id = $data->id;
    //load data from request

    if($deleteCategory->delete()){
        //if category successfuly deleted, output the id 
        echo json_encode(array('id' => $deleteCategory->id));
    }
    else {
        echo json_encode(array('message'=> 'No Category Found'));
        //if category was not succesfully deleted than that means no category found
        //output that
    }