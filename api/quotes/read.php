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

    if($num > 0) {
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
        }
       echo json_encode($quotes_arr);
    }
    else{
        echo  json_encode(
            array('message'=> 'No Quote Found')
        );
    }