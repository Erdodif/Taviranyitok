<?php
require_once "Taviranyito.php";
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
    public function conn(): PDO
    {
        //nem kell elvileg...
        return $this->conn;
    }

    public function read(?int $id = null, int $order = TAVIRANYITOK_DEFAULT, int $direction = RENDEZES_NOVEKVO): array|false
    {
        $sql = "SELECT * FROM `taviranyitok`";
        $res = null;
        if ($id === null) {
            if ($order === TAVIRANYITOK_DEFAULT && $direction === RENDEZES_NOVEKVO) {
                $sql .= ";";
            } else {
                $param = Taviranyito::getOszlopnev($order);
                $irany = DB::getOrder($direction);
                $sql .= "ORDER BY `" . $param . "` " . $irany . ";";
            }
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = $this->conn->prepare($sql . " WHERE `id` = :id;");
            $stmt->execute(array(":id" => $id));
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $res;
    }

    public function create(Taviranyito $o): bool
    { 
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
        return $stmt->execute($data);
    }

    public function update(Taviranyito $o): bool
    { 
        if (!$o->letezikIlyenId()) {
            throw new Error("ilyen elem nem l??tezik");
        }
        $id = $o->getId();
        $gyarto = $o->getGyarto();
        $termek_nev = $o->getTermekNev();
        $megjelenes = $o->getMegjelenes();
        $ar = $o->getAr();
        $elerheto = $o->getElerheto();
        $sql = "UPDATE `taviranyitok` 
        SET " .
            ($gyarto === null ? "" : "gyarto = :gyarto, ") .
            ($termek_nev === null ? "" : "termek_nev = :termek_nev, ") .
            ($megjelenes === null ? "" : "megjelenes = :megjelenes, ") .
            ($ar === null ? "" : "ar = :ar, ") .
            ($elerheto === null ? "" : "elerheto = :elerheto, ");
        $sql = mb_substr($sql, 0, -2);
        $sql .= " WHERE id = :id;";
        //Lehetne a kinull??z??sok helyett addit??v a param??terkezel??s
        $data = array(
            "id" => $id,
            "gyarto" => $gyarto,
            "termek_nev" => $termek_nev,
            "megjelenes" => $megjelenes,
            "ar" => $ar,
            "elerheto" => $elerheto
        );
        foreach ($o->getMindenTulajdonsag() as $key => $value) {
            if ($value === null) {
                unset($data[$key]);
            }
        }
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM `taviranyitok` WHERE `id` = ?';
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(array($id));
    }

    public static function getOrder(int $order): string
    {
        if ($order === RENDEZES_NOVEKVO) {
            return "ASC";
        } else if ($order === RENDEZES_CSOKKENO) {
            return "DESC";
        } else {
            throw new Error("Nem megfelel?? param??ter!");
        }
    }
}

define("RENDEZES_NOVEKVO", 0);
define("RENDEZES_CSOKKENO", 1);
