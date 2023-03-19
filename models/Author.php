<?php
class Author {
    private $conn;
    private $table = 'authors';

    public $id;
    public $author;

    public function __construct($db){
        $this->conn = $db;
    }
    //construct the connection

    public function read(){
        $query = 'SELECT id, author FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single(){
        $query = 'SELECT id, author FROM ' . $this-> table . ' WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        //bind query_string value to id in query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
          //check to see if there is a row
            if(is_null($row['id']))
            //check to see if column id is null
               return false;
             else{
              //if not, set author to the author in retrieved row
                 $this->author = $row['author'];
                 return true;
             }
           }  
    }

    public function create(){
        $query = 'INSERT INTO ' . $this->table . '(author) VALUES(:author) RETURNING id';
        //return id from creation function to set it later
        $stmt = $this->conn->prepare($query);
        $this->author =htmlspecialchars(strip_tags($this->author));
        //clean data
        $stmt->bindParam(':author', $this->author);
        //bind the parameter request to the statement
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            //set the id to post request id
            return true;
        }
        return false;  
    }

    public function update(){
        $query = 'UPDATE ' . $this->table . ' SET author = :author WHERE id = :id RETURNING id';
        //update with returning statement to see if id exists
        $stmt = $this->conn->prepare($query);
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->id = htmlspecialchars(strip_tags($this->id));
        //clean data
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':id', $this->id);
    

        if($stmt->execute()) {
          //if the statement executed
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //retrieve the row from the exeuted query
            if($row){
              //if the row exists
                if(is_null($row['id']))
                //if the column id does not exist
                  return false;
                else
                  return true;
                //the row and column exist so the query retrieved non-null values
              }  
              else
              //row doesn't exist so query retrieved null/nothing
                return false;

          }

    }

    public function delete(){
        
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id RETURNING id';
        //return the id from the delete request to check if id is null
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        //clean data
        $stmt->bindParam(':id', $this->id);
        //bind id from user json request
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //retrieve result
            if($row){
              //if row exists/is true
              if(is_null($row['id']))
              //if column is empty
                return false;
              //that means id does not exist so return false
              else
                return true;
              //row and column exists
            }  
            else
              return false;
          }
  }
}
