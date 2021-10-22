<?php
class DB
{
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "taviranyito";
    private $conn;
    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        mysqli_report(MYSQLI_REPORT_ERROR);
        mysqli_set_charset($this->conn, "utf8mb4");
        if ($this->conn->connect_error) {
            throw new Error("Sikertelen kapcsolódás az adatbázissal: " . $this->conn->connect_error);
        }
    }

    private function muvelet($row, $param = null, $kellvissza = false)
    {
        if ($param === null) {
            $result = $this->conn->query($row);
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $stmt = $this->conn->prepare($row);
            echo $stmt;
            echo var_dump($param);
            $tipus = "ssd";
            if(isset($param["megjelenes"])){
                $tipus = "sssd";
            }
            $stmt->bind_param($tipus, $param);
            $siker = $stmt->execute();
            if ($kellvissza) {
                $siker = $stmt->get_result();
            }
            return $siker;
        }
    }

    public function listazas()
    {
        $sql = "SELECT * FROM taviranyitok";
        return $this->muvelet($sql);
    }

    public function listazasHaEgyenlo(object $clause)
    {
        $feltetel = "";
        $meret = 0;
        foreach ($clause as $key) {
            $meret++;
        }
        $i = 0;
        foreach ($clause as $key => $value) {
            $i++;
            $key = mysqli_real_escape_string($this->conn, $key);
            $value = mysqli_real_escape_string($this->conn, $value);
            $feltetel .= $key . "=" . $value;
            if ($i < $meret) {
                $feltetel .= " & ";
            }
        }
        $sql = "SELECT * FROM taviranyitok WHERE $feltetel";
        return $this->muvelet($sql);
    }

    public function felvetel($object)
    {
        $megjelenesHaVan = "";
        if(isset($object["megjelenes"])){
            $megjelenesHaVan = ",`taviranyitok`.`megjelenes`";
        }
        $values = "(";
        foreach ($object as $key) {
            $values = "?,";
        }
        $values = mb_strcut($values, 0, mb_strlen($values) - 1) . ")";
        $sql = "INSERT INTO `taviranyitok` (`taviranyitok`.`gyarto`,`taviranyitok`.`termek_nev`".$megjelenesHaVan.",`taviranyitok`.`ar`) VALUES $values";
        return $this->muvelet($sql, $object);
    }
}
