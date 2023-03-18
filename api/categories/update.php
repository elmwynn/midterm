<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $updateCategory = new Category($db);
    $data = json_decode(file_get_contents("php://input"));
    if((isset($data->category)) && (isset($data->id))){
      $updateCategory->id = $data->id;
      $updateCategory->category = $data->category;
      if($updateCategory->update()){
        $category_arr = array(
          'id' => $updateCategory->id,
          'category' => $updateCategory->category
         );
        print_r(json_encode($category_arr));
      }
    else { 
        echo json_encode(array('message' => 'category_id Not Found'));
      }
    }
    else {
      echo json_encode (array('message' => 'Missing Required Parameters'));
    }