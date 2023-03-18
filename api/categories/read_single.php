<?php
    
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $category = new Category($db);

    $category->id = isset($_GET['id']) ? $_GET['id'] : die();

    $category->read_single();

    $category_arr = array(
        'id' => intval($category->id),
        'category' => $category->category
    );

    if(is_null($category->category)) 
         echo json_encode(array('message'=> 'category_id Not Found'));
    else
        print_r(json_encode($category_arr));
?>