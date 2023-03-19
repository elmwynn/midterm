<?php
class Category {
    private $conn;
    private $table = 'categories';

    public $id;
    public $category;

    public function __construct($db){
        $this->conn = $db;
    }

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
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
           if(is_null($row['id']))
              return false;
            else{
                $this->category = $row['category'];
                return true;
            }
          }  
    }
    
    public function create(){
        $query = 'INSERT INTO ' . $this->table . '(category) VALUES(:category) RETURNING id';
        
        $stmt = $this->conn->prepare($query);
        $this->category =htmlspecialchars(strip_tags($this->category));
        $stmt->bindParam(':category', $this->category);

        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            return true;
        }
        return false;  
    }

    public function update(){
        $query = 'UPDATE ' . $this->table . ' SET category = :category WHERE id = :id RETURNING id';

        $stmt = $this->conn->prepare($query);
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row){
                if(is_null($row['id']))
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

      $stmt = $this->conn->prepare($query);

      $this->id = htmlspecialchars(strip_tags($this->id));

      $stmt->bindParam(':id', $this->id);

      if($stmt->execute()) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
          if(is_null($row['id']))
            return false;
          else
            return true;
        }  
        else
          return false;
      }
  
}
}
?>