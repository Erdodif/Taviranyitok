<?php
require_once "DB.php";
class Taviranyito
{
    private static DB $db;
    private ?int $id;
    private ?string $gyarto;
    private ?string $termek_nev;
    private ?string $megjelenes;
    private ?int $ar;
    private ?int $elerheto;

    public static function init()
    {
        if (empty(Taviranyito::$db)) {
            Taviranyito::$db = new DB();
        }
    }

    public function __construct(?int $id, string $gyarto, string $termek_nev, ?string $megjelenes, int $ar, ?int $elerheto)
    {
        $this->id = $id;
        $this->gyarto = $gyarto;
        $this->termek_nev = $termek_nev;
        $this->megjelenes = $megjelenes;
        $this->ar = $ar;
        $this->elerheto = $elerheto;
    }

    public function db_frissit()
    {
        if ($this->id !== null) {
            //id-vel frissíti az adott id-jüt
            echo "id-vel frissítene...<br>";
            Taviranyito::$db->update($this);
        } else {
            //id nélkül létrehoz egy újjat
            echo "id nélkül létrehozna...<br>";
            Taviranyito::$db->create($this);
        }
    }

    public static function ujTaviranyito(string $gyarto, string $termek_nev, ?string $megjelenes, int $ar): Taviranyito
    {
        return new Taviranyito(null, $gyarto, $termek_nev, $megjelenes, $ar, 0);
    }

    public static function db_TaviranyitokMind(): array
    {
        $res = Taviranyito::$db->read();
        $list = [];
        foreach ($res as $element) {
            $list[] = new Taviranyito(
                $element["id"],
                $element["gyarto"],
                $element["termek_nev"],
                $element["megjelenes"],
                $element["ar"],
                $element["elerheto"]
            );
        }
        return $list;
    }

    public static function db_TaviranyitoEgy(int $id): Taviranyito
    {

        $res = Taviranyito::$db->read($id);
        return new Taviranyito(
            $res["id"],
            $res["gyarto"],
            $res["termek_nev"],
            $res["megjelenes"],
            $res["ar"],
            $res["elerheto"]
        );
    }

    public function getId()
    {
        return $this->id;
    }
    public function getGyarto()
    {
        return $this->gyarto;
    }
    public function getTermekNev()
    {
        return $this->termek_nev;
    }
    public function getMegjelenes()
    {
        return $this->megjelenes;
    }
    public function getAr()
    {
        return $this->ar;
    }
    public function getElerheto()
    {
        return $this->elerheto;
    }
}
Taviranyito::init();
