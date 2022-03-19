<?php
  //Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type:application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Quotes.php';

  //Instance DB & Connect
  $database = new Database();
  $db = $database->connect();

  //instantiate blog post object
  $quote = new Post($db);

  //Get ID
  $quote->id = isset($_GET['id']) ? $_GET['id'] : die();



  //Get post
  $quote->read_single();

  //Create arry
  $quote_arr = array(
    'id' => $quote->id,
    'quote' =>$quote->quote,
    'authorId' =>$quote->authorId,
    'author_name' =>$quote->author_name,
    'categoryId' =>$quote->categoryId,
    'category_name' =>$quote->category_name,
  );

  //Make JSON
  print_r(json_encode($quote_arr));

