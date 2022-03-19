<?php
    class Author {
        //DB Stuff
        private $conn;
        private $table = 'authors';

        //Post Properties
        public $id;
        public $author;

        //Constructor with DB
        public function __construct($db){
            $this->conn = $db;
        }

        //Get authors
        public function read(){
            //Create Query
            $query = 'SELECT
                id,
                author
            FROM
                ' . $this->table . '
            ORDER BY
                id DESC';

        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;

        }

        //Get single Author
        public function read_single(){
            //create query
            $query = 'SELECT a.id, a.author
            FROM ' . $this->table . ' a
            WHERE
              a.id = ?
            LIMIT 0,1';

                //Prepare Statement
                $stmt = $this->conn->prepare($query);

                //Blind ID
                $stmt->bindParam(1, $this->id);

                //Execute query
                $stmt->execute();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                //Set properties
                $this->id = $row['id'];
                $this->author = $row['author'];

        }

        //Create Author
        public function create(){
            //Create query
            $query = 'INSERT INTO ' 
              . $this->table . '
                SET
                    id = :id,
                    author = :author';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean Data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->author = htmlspecialchars(strip_tags($this->author));

            //Bind Data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':author', $this->author);

            //Execute query
            if($stmt->execute()){
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);

            return false;

        }

        //Update Author
        public function update(){
            //Create query
            $query = 'UPDATE ' 
              . $this->table . '
                SET
                    id = :id,
                    author = :author
                WHERE
                  id = :id';
  
            //Prepare statement
            $stmt = $this->conn->prepare($query);
  
            //Clean Data
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->id = htmlspecialchars(strip_tags($this->id));
  
            //Bind Data
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':id', $this->id);
  
            //Execute query
            if($stmt->execute()){
                return true;
            }
  
            //Print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);
  
            return false;
  
        }

        //Delete Author
      public function delete() {
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