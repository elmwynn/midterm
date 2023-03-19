<?php
    
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $category = new Category($db);

    $category->id = isset($_GET['id']) ? $_GET['id'] : die();
    //check to see if the parameter is set

    if ($category->read_single()){
        //if call to read_single successful
        $category_arr = array(
            'id' => intval($category->id),
            'category' => $category->category
        );
        print_r(json_encode($category_arr));
        //load requested result into array and output
    }
    else {
        echo json_encode(array('message'=> 'category_id Not Found'));
        //if call to read_single unsuccessfuly then no category was found
    }
?>