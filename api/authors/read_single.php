<?php
    
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $author = new Author($db);

    $author->id = isset($_GET['id']) ?  $_GET['id'] : die();

    if($author->read_single()){

        $author_arr = array(
            'id' => intval($author->id),
            'author' => $author->author
        );
        
        print_r(json_encode($author_arr));
    }
    else{
        echo json_encode(array('message' => 'author_id Not Found'));
    }
        

?>