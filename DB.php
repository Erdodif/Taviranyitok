<?php
class DB
{
    private $user = "root";
    private $pass = "";
    private $conn;
    public function __construct()
    {
        $this->conn = new PDO('mysql:host=localhost;dbname=taviranyito;charset=utf8', $this->user, $this->pass);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function conn()
    {
        //nem kell elvileg...
        return $this->conn;
    }

    public function read($id = null)
    {
        $sql = "SELECT * FROM `taviranyitok`";
        $res = null;
        if ($id === null) {
            $stmt = $this->conn->prepare($sql . ";");
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = $this->conn->prepare($sql . " WHERE `id` = :id;");
            $stmt->execute(array(":id" => $id));
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $res;
    }

    public function create(object $o)
    {//TODO befejezni és tesztelni
        $sql = "INSERT INTO `taviranyitok` (`id`, `gyarto`, `termek_nev`, `megjelenes`, `ar`, `elerheto`) 
            VALUES (null, :gyarto, :termek_nev, DEFAULT, :ar, DEFAULT);";
        
        $stmt = $this->conn->prepare($sql);
        $gyarto = $o->getGyarto();
        $termek_nev = $o->getTermekNev();
        $ar = $o->getAr();
        $data = array(
            "gyarto" => $gyarto,
            "termek_nev" => $termek_nev,
            "ar" => $ar
        );
        $stmt->execute($data);
    }

    public function update(object $o): bool
    {//TODO befejezni és tesztelni
        $sql = "UPDATE `taviranyitok` 
        SET gyarto = ?, 
            termek_nev = ?, 
            megjelenes = ?, 
            ar = ?, 
            elerheto = ?
        WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$o["gyarto"], $o["termek_nev"], $o["megjelenes"], $o["ar"], $o["elerheto"], $o["id"],]);
    }
}
