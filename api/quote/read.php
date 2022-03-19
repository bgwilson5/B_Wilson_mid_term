<?php
  //Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type:application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Quotes.php';

  //Instance DB & Connect
  $database = new Database();
  $db = $database->connect();

  //instantiate quote post object
  $quote = new Post($db);

  //Quote post query
  $result = $quote->read();
  // get row count
  $num = $result->rowCount();

  //check if any quotes
  if($num > 0){
      //quote arry
      $quotes_arr = array();
      $quotes_arr['data'] = array();

      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $quotes_item = array(
            'id'=> $id,
            'quote'=> $quote,
            'authorId'=> $authorId,
            'author_name'=>$author_name,
            'categoryId'=> $categoryId,
        );
        // Push to "data"
        array_push($quotes_arr['data'], $quotes_item);
      }

      //turn to json & output
      echo json_encode($quotes_arr);

  } else {
      //no post
      echo json_encode(
          array('message' => 'No Quote Found')
      );

  }