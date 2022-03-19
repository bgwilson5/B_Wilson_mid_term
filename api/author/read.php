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

  //Category query
  $result = $author->read();
  // get row count
  $num = $result->rowCount();

  //check if any categories
  if($num > 0){
      //category arry
      $author_arr = array();
      $author_arr['data'] = array();

      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $author_item = array(
            'id'=> $id,
            'author'=> $author,
        );
        // Push to "data"
        array_push($author_arr['data'], $author_item);
      }

      //turn to json & output
      echo json_encode($author_arr);

  } else {
      //no category
      echo json_encode(
          array('message' => 'No Categories Found')
      );

  }