<?php
  //Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type:application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Categories.php';

  //Instance DB & Connect
  $database = new Database();
  $db = $database->connect();

  //instantiate category post object
  $category = new Category($db);

  //Category query
  $result = $category->read();
  // get row count
  $num = $result->rowCount();

  //check if any categories
  if($num > 0){
      //category arry
      $cat_arr = array();
      $cat_arr['data'] = array();

      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $cat_item = array(
            'id'=> $id,
            'category'=> $category,
        );
        // Push to "data"
        array_push($cat_arr['data'], $cat_item);
      }

      //turn to json & output
      echo json_encode($cat_arr);

  } else {
      //no category
      echo json_encode(
          array('message' => 'No Categories Found')
      );

  }