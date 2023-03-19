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
    //load data from request into variable

    if((isset($data->author)) && (isset($data->id))){
      //check to see if necessary parameters are set
      $updateAuthor->id = $data->id;
      $updateAuthor->author = $data->author;
      //transfer request data
      if($updateAuthor->update()){
        //if call to update successful
        $author_arr = array(
          'id' => $updateAuthor->id,
          'author' => $updateAuthor->author
         );
        print_r(json_encode($author_arr));
        //load updated values into an array and output
      }
    else { 
        echo json_encode(array('message' => 'author_id Not Found'));
        //if call to update failed, there was no author_id matching the request, so output that
      }
    }
    else{
      echo json_encode (array('message' => 'Missing Required Parameters'));
      //if call to isset failed, a parameter was missing so output that
    }