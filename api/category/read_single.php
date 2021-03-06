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

  //Get ID
  $category->id = isset($_GET['id']) ? $_GET['id'] : die();

  //Get category
  $category->read_single();

  //Create arry
  $cat_arr = array(
    'id' => $category->id,
    'category' =>$category->category,
  );

  //Make JSON
  print_r(json_encode($cat_arr));

