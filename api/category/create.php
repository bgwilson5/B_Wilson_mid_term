<?php
  //Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type:application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Categories.php';

  //Instance DB & Connect
  $database = new Database();
  $db = $database->connect();

  //instantiate quote post object
  $category = new Category($db);

  // Get raw posted data

    $data = json_decode(file_get_contents("php://input"));

    $category->category = $data->category;
    $category->id = $data->id;

    //Create category
    if($category->create()) {
        echo json_encode(
            array('message' => 'Category Created')
        );
    } else {
    echo json_encode(
        array('message' => 'Category Not Created')
    );
    }