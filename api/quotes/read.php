<?php
    
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    $database = new Database();
    $db = $database->connect();

    $quote = new Quote($db);

    $result = $quote->read();

    $num = $result->rowCount();
    //retrieve rows from query read
    if($num > 0) {
        //if there are rows
        $quotes_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $quote_item = array(
                'id' => $id,
                'quote' => $quote,
                'author'=> $author,
                'category'=> $category
            );
            array_push($quotes_arr, $quote_item);
            //loop through rows and put data values into array
        }
       echo json_encode($quotes_arr);
    }
    else{
        echo  json_encode(
            array('message'=> 'No Quote Found')
            //if no rows, then no quotes
        );
    }