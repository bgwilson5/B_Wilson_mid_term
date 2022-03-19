<?php
    class Post {
        //DB Stuff
        private $conn;
        private $table = 'quotes';

        //Post Properties
        public $id;
        public $categoryId;
        public $quote;
        public $authorId;
        public $category_name;
        public $author_name;

        //Constructor with DB
        public function __construct($db){
            $this->conn = $db;
        }

        //Get Post
        public function read() {
            //create query
            $query = 'SELECT a.author as author_name, q.id, q.categoryId, q.quote, q.authorId
            FROM ' . $this->table . ' q
            LEFT JOIN
              authors a ON q.authorId = a.id
            ORDER BY
              q.id DESC';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            //Execute query
            $stmt->execute();

            return $stmt;
        }
        
        //Get single Quote
        public function read_single(){
            //create query
            $query = 'SELECT a.author as author_name, c.category as category_name, q.id, q.categoryId, q.quote, q.authorId
            FROM ' . $this->table . ' q
            LEFT JOIN
              authors a ON q.authorId = a.id
            LEFT JOIN
              categories c ON q.categoryId = c.id
            WHERE
              q.id = ?
              LIMIT 0,1';

                //Prepare Statement
                $stmt = $this->conn->prepare($query);

                //Blind ID
                $stmt->bindParam(1, $this->id);

                //Execute query
                $stmt->execute();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                //Set properties
                $this->quote = $row['quote'];
                $this->categoryId = $row['categoryId'];
                $this->authorId = $row['authorId'];
                $this->author_name = $row['author_name'];
                $this->category_name = $row['category_name'];

        }

        //Create Quote
        public function create(){
            //Create query
            $query = 'INSERT INTO ' 
              . $this->table . '
                SET
                    quote = :quote,
                    authorId = :authorId,
                    categoryId = :categoryId';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean Data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->authorId = htmlspecialchars(strip_tags($this->authorId));
            $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

            //Bind Data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':authorId', $this->authorId);
            $stmt->bindParam(':categoryId', $this->categoryId);

            //Execute query
            if($stmt->execute()){
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);

            return false;

        }

         //Update Quote
         public function update(){
          //Create query
          $query = 'UPDATE ' 
            . $this->table . '
              SET
                  quote = :quote,
                  authorId = :authorId,
                  categoryId = :categoryId
              WHERE
                id = :id';

          //Prepare statement
          $stmt = $this->conn->prepare($query);

          //Clean Data
          $this->quote = htmlspecialchars(strip_tags($this->quote));
          $this->authorId = htmlspecialchars(strip_tags($this->authorId));
          $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));
          $this->id = htmlspecialchars(strip_tags($this->id));

          //Bind Data
          $stmt->bindParam(':quote', $this->quote);
          $stmt->bindParam(':authorId', $this->authorId);
          $stmt->bindParam(':categoryId', $this->categoryId);
          $stmt->bindParam(':id', $this->id);

          //Execute query
          if($stmt->execute()){
              return true;
          }

          //Print error if something goes wrong
          printf("Error: %s. \n", $stmt->error);

          return false;

      }


      //Delete Post
      public function delete(){
        //Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        //Bind data
        $stmt->bindParam(':id', $this->id);

        //Execute query
        if($stmt->execute()){
          return true;
      }

      //Print error if something goes wrong
      printf("Error: %s. \n", $stmt->error);

      return false;

      }
    }