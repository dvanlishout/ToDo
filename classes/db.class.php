<?php
class dbconnect{
    var $dbhost = "localhost";
    var $dbname = "todo";
    var $dbuser = "root";
    var $dbpassw = "root";
    var $conn;
    var $query;

    public function __construct(){
        $this->conn = new PDO('mysql:host='.$this->dbhost.';dbname='.$this->dbname, $this->dbuser, $this->dbpassw, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'") );
    }
    public function run($sql){
        $this->query = $this->conn->prepare($sql);
        return $this->query->execute();
    }
    public function fetch(){
        return $this->query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function close(){
        $this->conn = NULL;
        $this->query = NULL;
    }
}
?>