<?php
  //Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type:application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Authors.php';

  //Instance DB & Connect
  $database = new Database();
  $db = $database->connect();

  //instantiate quote post object
  $author = new Author($db);

  // Get raw posted data

    $data = json_decode(file_get_contents("php://input"));

    $author->author = $data->author;
    $author->id = $data->id;

    //Create Author
    if($author->create()) {
        echo json_encode(
            array('message' => 'Author Created')
        );
    } else {
    echo json_encode(
        array('message' => 'Author Not Created')
    );
    }