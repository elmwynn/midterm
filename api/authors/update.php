<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $updateAuthor = new Author($db);

    $data = json_decode(file_get_contents("php://input"));

    if((isset($data->author)) && (isset($data->id))){
      $updateAuthor->id = $data->id;
      $updateAuthor->author = $data->author;
      if($updateAuthor->update()){
        $author_arr = array(
          'id' => $updateAuthor->id,
          'category' => $updateAuthor->author
         );
        print_r(json_encode($author_arr));
      }
    else { 
        echo json_encode(array('message' => 'author_id Not Found'));
      }
    }
    else{
      echo json_encode (array('message' => 'Missing Required Parameters'));
    }