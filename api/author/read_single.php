<?php
  //Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type:application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Authors.php';

  //Instance DB & Connect
  $database = new Database();
  $db = $database->connect();

  //instantiate category post object
  $author = new Author($db);

  //Get ID
  $author->id = isset($_GET['id']) ? $_GET['id'] : die();

  //Get category
  $author->read_single();

  //Create arry
  $author_arr = array(
    'id' => $author->id,
    'author' =>$author->author,
  );

  //Make JSON
  print_r(json_encode($author_arr));

