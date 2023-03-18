<?php
    
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $newCategory = new Category($db);

    $data = json_decode(file_get_contents("php://input"));
    if(isset($data->category)){
        $newCategory->category = $data->category;
        //$newCategory->id = $data->id;
        if($newCategory->create()){
            $category_arr = array(
                'id' => $newCategory->id,
                'category' => $newCategory->category
            );
            print_r(json_encode($category_arr));
        }
        
    }
    else {
        echo json_encode (array('message' => 'Missing Required Parameters'));
    }



