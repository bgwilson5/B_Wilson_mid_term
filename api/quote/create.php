<?php
  //Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type:application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Quotes.php';

  //Instance DB & Connect
  $database = new Database();
  $db = $database->connect();

  //instantiate quote post object
  $quote = new Post($db);

  // Get raw posted data

    $data = json_decode(file_get_contents("php://input"));

    $quote->quote = $data->quote;
    $quote->authorId = $data->authorId;
    $quote->categoryId = $data->categoryId;

    //Create post
    if($quote->create()) {
        echo json_encode(
            array('message' => 'Post Created')
        );
    } else {
    echo json_encode(
        array('message' => 'Post Not Created')
    );
    }