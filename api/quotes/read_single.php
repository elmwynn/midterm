<?php
    
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    $database = new Database();
    $db = $database->connect();

    $quote = new Quote($db);

    if(str_contains($_SERVER['QUERY_STRING'],'&')){
        $quote->author_id = isset($_GET['author_id']) ? $_GET['author_id'] : die();
        $quote->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : die();
        $quote->read_single();
        $result = $quote->read_single();
        $num = $result->rowCount();
        if($num > 0){
            $quotes_arr = array();
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $quote_item = array(
                    'id' => $id,
                    'quote' => $quote,
                    'author' => $author,
                    'category' => $category
                ); 
                array_push($quotes_arr, $quote_item);
            }
            print_r(json_encode($quotes_arr));
        }
        else{
            echo  json_encode(
                array('message'=> 'No Quote Found')
            );
        }
    }

    else if(str_contains($_SERVER['QUERY_STRING'],'author_id')){
        $quote->author_id = isset($_GET['author_id']) ?  $_GET['author_id'] : die();
        $quote->read_single();
        $result = $quote->read_single();
        $num = $result->rowCount();
        if($num > 0) {
            $quotes_arr = array();
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $quote_item = array(
                    'id' => intval($quote->id),
                    'quote' => $quote->quote,
                    'author' => $quote->author,
                    'category' => $quote->category
                ); 
                array_push($quotes_arr, $quote_item);
            }
            print_r(json_encode($quotes_arr));
        }
        else{
            echo  json_encode(
                array('message'=> 'No Author Found')
            );
        }
    }
    
    else if(str_contains($_SERVER['QUERY_STRING'],'category_id')){
        $quote->category_id = isset($_GET['category_id']) ?  $_GET['category_id'] : die();
        $quote->read_single();
        $result = $quote->read_single();
        $num = $result->rowCount();
        if($num > 0){
            $quotes_arr = array();
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $quote_item = array(
                    'id' => intval($quote->id),
                    'quote' => $quote->quote,
                    'author' => $quote->author,
                    'category' => $quote->category
                ); 
                array_push($quotes_arr, $quote_item);
            }
            print_r(json_encode($quotes_arr));
        }
        else{
            echo  json_encode(
                array('message'=> 'No Category Found')
            );
        }
    }

    else if(str_contains($_SERVER['QUERY_STRING'],'id')){
       
        $quote->id = isset($_GET['id']) ? $_GET['id'] : die();
    
        $quote->read_single();

        $quote_arr = array(
            'id' => intval($quote->id),
            'quote' => $quote->quote,
            'author' => $quote->author,
            'category' => $quote->category
        );

        if(is_null($quote->quote)) 
            echo json_encode(array('message'=> 'No Quote Found'));
        else
            print_r(json_encode($quote_arr));
    }
    
