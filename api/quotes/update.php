<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    $database = new Database();
    $db = $database->connect();

    $updateQuote = new Quote($db);

    $data = json_decode(file_get_contents("php://input"));
    //retrieve data from request
    if((isset($data->quote)) && (isset($data->author_id)) && (isset($data->category_id)) && (isset($data->quote)) && (isset($data->id))){
        //check to see if all parameters are set
        $updateQuote->id = $data->id;
        $updateQuote->quote = $data->quote;
        $updateQuote->category_id = $data->category_id;
        $updateQuote->author_id = $data->author_id;
        if($updateQuote->update()){
            //if call to update successful
            $quote_arr = array(
                'id' => $updateQuote->id,
                'quote' => $updateQuote->quote,
                'author_id' => $updateQuote->author_id,
                'category_id' => $updateQuote->category_id
            );
            print_r(json_encode($quote_arr));
            //load updated values into array and output
        }
    }
    else {
        echo json_encode (array('message' => 'Missing Required Parameters'));
        //if call to isset fail that means a parameter is missing
    }


