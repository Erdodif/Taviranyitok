<?php
class DB{
    private $user = "root";
    private $pass = "";
    private $conn;
    public function __construct()
    {
        $this->conn = new PDO('mysql:host=localhost;dbname=taviranyito;charset=utf8',$this->user,$this->pass);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function conn(){
        return $this->conn;
    }
    public function olvas(){
        $stmt = $this->conn()->prepare("SELECT * FROM `taviranyitok`");
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo var_dump($stmt);
        return $res;
    }
}