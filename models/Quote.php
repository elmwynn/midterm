<?php
class Quote {
    private $conn;
    private $table = 'quotes';

    public $id;
    public $quote;
    public $author_id;
    public $category_id;
    public $author;
    public $category;

    public function __construct($db){
        $this->conn = $db;
    }
    //construct connection

    public function read(){
        $query = 'SELECT quotes.id, quote, author, category FROM ' . $this->table . ' INNER JOIN authors ON quotes.author_id = authors.id INNER JOIN categories ON quotes.category_id = categories.id';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single(){


        if(str_contains($_SERVER['QUERY_STRING'],'&')){
            $query = 'SELECT quotes.id, author, quote, category FROM ' . $this-> table . ' INNER JOIN authors ON quotes.author_id = authors.id INNER JOIN categories ON quotes.category_id = categories.id WHERE author_id = ? AND category_id = ?';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->author_id);
            $stmt->bindParam(2, $this->category_id);
            //bind parameters
            $stmt->execute();
            return $stmt;
        }

        else if(str_contains($_SERVER['QUERY_STRING'],'author_id')){
            $query = 'SELECT quotes.id, author, quote, category FROM ' . $this-> table . ' INNER JOIN authors ON quotes.author_id = authors.id INNER JOIN categories ON quotes.category_id = categories.id WHERE author_id = ?';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->author_id);
            //bind parameter
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //retrieve result
            if($row){
                if(is_null($row['id']))
                    return false;
                    //check to see if query resulted in empty result
                else {
                    return $stmt;
                    //return statement if query resulted in actual data
                }
              }  
              else
                return false;    
        }

        else if(str_contains($_SERVER['QUERY_STRING'],'category_id')){
            $query = 'SELECT quotes.id, quote, author, category FROM ' . $this-> table . 
            ' INNER JOIN authors ON quotes.author_id = authors.id INNER JOIN categories ON quotes.category_id = categories.id WHERE category_id = ?';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->category_id);
            //bind parameter
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row){
                if(is_null($row['id']))
                    return false;
                else 
                    return $stmt;
                    //check to see if query resulted in null rows
                    //if not return the stmt
              }  
              else
                return false;     
        }

        
        else if(str_contains($_SERVER['QUERY_STRING'],'id')){
            $query = 'SELECT quotes.id, author, quote, category FROM ' . $this-> table . ' INNER JOIN authors ON quotes.author_id = authors.id INNER JOIN categories ON quotes.category_id = categories.id WHERE quotes.id = ?';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id);
            //bind parameters
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row){
                if(is_null($row['id']))
                    return false;
                else {
                    $this->quote = $row['quote'];
                    $this->author = $row['author'];
                    $this->category = $row['category'];  
                    return true;
                    //check to see if resulting query resulted in actual non-null rows
                    //or values and if it did, set the quote, author, and category values
                    //for output
                }
              }  
              else
                return false;    
        }
    }

    public function create(){

        $testQueryOne = 'SELECT * FROM ' . $this->table . ' WHERE author_id = :author_id';
        //query to see if author_id for post request exists
        $stmtTest = $this->conn->prepare($testQueryOne); 
        $stmtTest->bindParam(':author_id', $this->author_id);
        //bind parameter for author_id
        if($stmtTest->execute()){
          $row = $stmtTest->fetch(PDO::FETCH_ASSOC);
          if(!($row)){
            //if row is false/does not exist, then the author_id does not exist
            echo json_encode(array('message' => 'author_id Not Found'));
           return false;
          }
        }
        $testQueryTwo = 'SELECT * FROM ' . $this->table . ' WHERE category_id = :category_id';
        //query to see if category_id for post request exists
        $stmtTestTwo = $this->conn->prepare($testQueryTwo); 
        $stmtTestTwo->bindParam(':category_id', $this->category_id);
        //bind parameter for category_id
        if($stmtTestTwo->execute()){
          $row = $stmtTestTwo->fetch(PDO::FETCH_ASSOC);
          if(!($row)){
            //if row is false/does not exist, then category_id does not exist
             echo json_encode(array('message' => 'category_id Not Found'));
             return false;
          }
        }

  
        $query = 'INSERT INTO ' . $this->table . '(quote, author_id, category_id) VALUES(:quote, :author_id, :category_id) RETURNING id';
        $stmt = $this->conn->prepare($query); 
        //prepare actual post request query, returning id for output
        $this->quote =htmlspecialchars(strip_tags($this->quote));
        $this->author_id =htmlspecialchars(strip_tags($this->author_id));
        $this->category_id =htmlspecialchars(strip_tags($this->category_id));
        //clean values
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);
        //bind values
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            //set id for output
            return true;
        }
        return false;    
       }


    public function update(){

        $testQueryOne = 'SELECT * FROM ' . $this->table . ' WHERE author_id = :author_id';
        //test query to see if author_id for put request exists
        $stmtTest = $this->conn->prepare($testQueryOne); 
        $stmtTest->bindParam(':author_id', $this->author_id);
        //bind author_id parameter
        if($stmtTest->execute()){
          $row = $stmtTest->fetch(PDO::FETCH_ASSOC);
          if(!($row)){
            //if row is false/does not exist, then author_id does not exist
            echo json_encode(array('message' => 'author_id Not Found'));
           return false;
          }
        }
        $testQueryTwo = 'SELECT * FROM ' . $this->table . ' WHERE category_id = :category_id';
        //test query to see if category_id for put request exists
        $stmtTestTwo = $this->conn->prepare($testQueryTwo); 
        $stmtTestTwo->bindParam(':category_id', $this->category_id);
        if($stmtTestTwo->execute()){
          $row = $stmtTestTwo->fetch(PDO::FETCH_ASSOC);
          if(!($row)){
            //if row is false/does not exist, then category_id does not exist
             echo json_encode(array('message' => 'category_id Not Found'));
             return false;
          }
        }

        $query = 'UPDATE ' . $this->table . ' SET quote = :quote, author_id = :author_id, category_id = :category_id
         WHERE id = :id RETURNING id';
         //actual put request, returning id to set id to test for null
        $stmt = $this->conn->prepare($query);

        $this->quote =htmlspecialchars(strip_tags($this->quote));
        $this->id =htmlspecialchars(strip_tags($this->id));
        //clean data

        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);
        //bind data
        
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row){
                if(is_null($row['id'])){
                  //if row is false/does not exist and neither does column, then the quote id does not exist
                    echo json_encode(array('message'=> 'No Quotes Found'));
                    return false;
                }
                else
                  return true;
              }  
              else {
                echo json_encode(array('message'=> 'No Quotes Found'));
                return false;
              }
        }
      
    }

    public function delete(){
        
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id RETURNING id';
        //return id to test if id is null
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        //clean data

        $stmt->bindParam(':id', $this->id);
        //bind data

        if($stmt->execute()) {
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          if($row){
            if(is_null($row['id']))
            //if row is false/does not exist and neither does column, then the quote id does not exist
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