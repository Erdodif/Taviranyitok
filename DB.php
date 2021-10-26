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

    public function create(string $gyarto, string $termek_nev, int $ar, string $megjelenes = null, int $elerheto = 0)
    {
        //TODO : MÉG nem működik
        $params = [
            ":gyarto" => $gyarto,
            ":termek_nev" => $termek_nev,
            ":ar" => $ar,
            ":megjelenes" => $megjelenes,
            ":elerheto" => $elerheto
        ];
        if ($megjelenes !== null) {
            $megjelenes = [
                "oszlop" => ", `megjelenes`",
                "param" => ", :megjelenes",
                "tartalom" => $megjelenes
            ];
        } else {
            $megjelenes = [
                "oszlop" => "",
                "param" => "",
            ];
            $params += [":megjelenes" => $megjelenes];
        }
        if ($elerheto !== null) {
            $elerheto = [
                "oszlop" => ", `elerheto`",
                "param" => ", :elerheto",
            ];
            $params += [":elerheto" => $elerheto];
        } else {
            $elerheto = [
                "oszlop" => "",
                "param" => "",
                "tartalom" => $elerheto
            ];
        }
        $sql = "INSERT INTO `taviranyitok` (`gyarto`, `termek_nev`,`ar` ".$megjelenes["oszlop"].$elerheto["oszlop"].")
            VALUES (:gyarto, :termek_nev, :ar, ".$megjelenes["param"].$elerheto["param"].");";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }
}
