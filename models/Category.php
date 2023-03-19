<?php
class Category {
    private $conn;
    private $table = 'categories';

    public $id;
    public $category;

    public function __construct($db){
        $this->conn = $db;
    }
    //construct connection
    public function read(){
        $query = 'SELECT id, category FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single(){
        $query = 'SELECT id, category FROM ' . $this-> table . ' WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        //bind query_string param
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
           if(is_null($row['id']))
           //check to see if row non_null/not false and column is non_null
              return false;
            else{
                $this->category = $row['category'];
                return true;
                //if the retreival resulted in a row, set the category to
                //the retrieved category for output
            }
          }  
    }
    
    public function create(){
        $query = 'INSERT INTO ' . $this->table . '(category) VALUES(:category) RETURNING id';
        //return id to have it for output
        $stmt = $this->conn->prepare($query);
        $this->category =htmlspecialchars(strip_tags($this->category));
        //clean data
        $stmt->bindParam(':category', $this->category);
        //bind parameters
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            //set id
            return true;
        }
        return false;  
    }

    public function update(){
        $query = 'UPDATE ' . $this->table . ' SET category = :category WHERE id = :id RETURNING id';
        //return id to check if id is null
        $stmt = $this->conn->prepare($query);
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->id = htmlspecialchars(strip_tags($this->id));
        //clean data
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':id', $this->id);
        //bind data
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //retrieve result
            if($row){
                if(is_null($row['id']))
                //check to see if result is non-null
                  return false;
                else
                  return true;
              }  
              else
                return false;
        }

          
    
    }

    public function delete(){
        
      $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id RETURNING id';
      //return id to check if id is null
      $stmt = $this->conn->prepare($query);

      $this->id = htmlspecialchars(strip_tags($this->id));
      //clean data
      $stmt->bindParam(':id', $this->id);
      //bind data

      if($stmt->execute()){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
          if(is_null($row['id']))
            return false;
            //check to see if delete call tried to delete an id that
            //does not exist
          else
            return true;
        }  
        else
          return false;
      }
  
}
}
?>