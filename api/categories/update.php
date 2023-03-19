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
    //store request data
    if((isset($data->category)) && (isset($data->id))){
      //check to see if the parameters needed are set
      $updateCategory->id = $data->id;
      $updateCategory->category = $data->category;
      //transfer request data
      if($updateCategory->update()){
        //if update call successful
        $category_arr = array(
          'id' => $updateCategory->id,
          'category' => $updateCategory->category
         );
        print_r(json_encode($category_arr));
        //load updated data into array and print out 
      }
    else { 
        echo json_encode(array('message' => 'category_id Not Found'));
        //if call to update failed, there was no category id found
      }
    }
    else {
      echo json_encode (array('message' => 'Missing Required Parameters'));
      //if call to isset failed, we are missing parameters
    }