<?php
    class Database {
        private $conn;
        private $host;
        private $port;
        private $dbname;
        private $username;
        private $password;

      public function __construct() {
            $this->username = getenv('USERNAME');
            $this->password = getenv('PASSWORD');
            $this->dbname = getenv('DBNAME');
            $this->host = getenv('HOST');
            $this->port = getenv('PORT');
        } 

        public function connect() {
            if($this->conn){
                //if connection already exists
                return $this->conn;
            }
            else{
                $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname};";
                //recreate dsn with private variables
                try{
                    $this->conn = new PDO($dsn, $this->username, $this->password);
                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $this->conn;
                }
                catch(PDOException $e){
                    echo 'Connection Error: ' . $e->getMessage() . ' ' . var_dump($dsn);
                }
            }
        }
    }
?>