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
        $sql = "INSERT INTO `taviranyitok` VALUES (:gyarto, :termek_nev, :megjelenes, :ar :elerheto)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(
            array(
                ":gyarto" => $o["gyarto"],
                ":termek_nev" => $o["termek_nev"],
                ":megjelenes" => $o["megjelenes"],
                ":ar" => $o["ar"],
                ":elerheto" => $o["elerheto"]
            )
        );
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
