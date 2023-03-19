<?php
    
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $author = new Author($db);

    $result = $author->read();

    $num = $result->rowCount();
    //count the number of rows result from the query

    if($num > 0) {
        //if rows exist:
        $authors_arr = array();
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $author_item = array(
                'id' => $id,
                'author' => $author
            );
            array_push($authors_arr, $author_item);
        }
       echo json_encode($authors_arr);
       //loop through the rows and fetch the data, load it into an array, output the array
    }
    else{
        echo  json_encode(
            array('message'=> 'No Categories Found')
        );
        //if query request result is empty
    }

?>