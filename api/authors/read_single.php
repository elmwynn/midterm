<?php
    
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $author = new Author($db);

    $author->id = isset($_GET['id']) ?  $_GET['id'] : die();
    //check to see if the request id was successfully set
    if($author->read_single()){
        //if read single returns true:
        $author_arr = array(
            'id' => intval($author->id),
            'author' => $author->author
        );
        print_r(json_encode($author_arr));
        //load queried result values into an array and output it
    }
    else{
        echo json_encode(array('message' => 'author_id Not Found'));
        //if the result was false, there was no author_id found, so report it
    }
        

?>