<?php
    
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    $database = new Database();
    $db = $database->connect();

    $newQuote = new Quote($db);

    $data = json_decode(file_get_contents("php://input"));
    //retrieve and store user request

    if((isset($data->quote)) && (isset($data->author_id)) && (isset($data->category_id))){
        //check to see if all the parameters are set
        $newQuote->quote = $data->quote;
        $newQuote->author_id = $data->author_id;
        $newQuote->category_id = $data->category_id;
       // $newQuote->id = $data->id;

        if($newQuote->create()){
            //if call to create successful:
            $quote_arr = array(
                'id' => $newQuote->id,
                'quote' => $newQuote->quote,
                'author_id' => $newQuote->author_id,
                'category_id' => $newQuote->category_id
            );
            print_r(json_encode($quote_arr));
            //load created variables into and output it
        }
        
    }
    else {
        echo json_encode (array('message' => 'Missing Required Parameters'));
        //output if any parameters are not set
    }



