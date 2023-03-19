<?php
    
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    $database = new Database();
    $db = $database->connect();

    $quote = new Quote($db);

    if(str_contains($_SERVER['QUERY_STRING'],'&')){
        //check to see if the request is for finding a quote by both category_id and author_id
        //by checking the query string for the '&' sign
        $quote->author_id = isset($_GET['author_id']) ? $_GET['author_id'] : die();
        $quote->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : die();
        //check to see if parameters are set
        $quote->read_single();
        $result = $quote->read_single();
        $num = $result->rowCount();
        //pull out the number of rows resulting from the query result
        if($num > 0){
            //if there are rows resulted
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
                //if zero rows are returned from the query
                array('message'=> 'No Quote Found')
            );
        }
    }

    else if(str_contains($_SERVER['QUERY_STRING'],'author_id')){
        //check to see if the request is by author_id by checking query string
        $quote->author_id = isset($_GET['author_id']) ?  $_GET['author_id'] : die();
        //check to see if parameters are set
        if($quote->read_single()){
            //if call to read_single successful
            $result = $quote->read_single();
            $num = $result->rowCount();
            //retrieve the number of rows from the query
            if($num > 0){
                //if the query resulted in not null rows
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
                        //loop through the results and pull the values into an array
                    }
                    print_r(json_encode($quotes_arr));
                }
        }

        else {
            echo  json_encode(
                array('message'=> 'No Author Found')
                //no rows means no author found
            );
        }
    }
    
    else if(str_contains($_SERVER['QUERY_STRING'],'category_id')){
        //check to see if request is for category_id by checking query string
        $quote->category_id = isset($_GET['category_id']) ?  $_GET['category_id'] : die();
        //check to see if parameters are set
        if($quote->read_single()){
            //if call to read single successful
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
                //pull values from row queries into an array
                print_r(json_encode($quotes_arr));
            }
        }
        else {
            echo  json_encode(
                array('message'=> 'No Category Found')
                //if no rows result
            );
        }
    }
  

    else if(str_contains($_SERVER['QUERY_STRING'],'id')){
       //check to see if request is just by quote id by checking query string
        $quote->id = isset($_GET['id']) ? $_GET['id'] : die();
        //check to see if parameters are set
        if($quote->read_single()){
            //if call to read single successful
            $quote_arr = array(
                'id' => intval($quote->id),
                'quote' => $quote->quote,
                'author' => $quote->author,
                'category' => $quote->category
            );
            //load row values into an array
            print_r(json_encode($quote_arr));
        }
        else{
            echo json_encode(array('message'=> 'No Quotes Found'));
            //if read single fails, no quotes were found
        }
    }
    
