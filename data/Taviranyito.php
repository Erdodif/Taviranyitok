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

    public function __construct(?int $id = null, ?string $gyarto, ?string $termek_nev, ?string $megjelenes, ?int $ar, ?int $elerheto)
    {
        $this->id = $id;
        $this->gyarto = $gyarto;
        $this->termek_nev = $termek_nev;
        $this->megjelenes = $megjelenes;
        $this->ar = $ar;
        $this->elerheto = $elerheto;
    }

    public function letezikIlyenId()
    {
        return !(Taviranyito::$db->read($this->id) === null);
    }

    public function teljes()
    {
        return !(empty($this->id) ||
            empty($this->gyarto) ||
            empty($this->termek_nev) ||
            empty($this->megjelenes) ||
            ($this->ar !== 0 && empty($this->ar)) ||
            empty($this->elerheto));
    }

    public function hibakereso()
    {
        //TODO
    }

    public function db_frissit(): bool
    {
        if ($this->id !== null) {
            //id-vel frissíti az adott id-jüt
            return Taviranyito::$db->update($this);
        } else {
            //id nélkül létrehoz egy újjat
            return Taviranyito::$db->create($this);
        }
    }

    public static function torol(Taviranyito $o): bool
    {
        return Taviranyito::$db->delete($o->id);
    }

    public static function ujTaviranyito(?string $gyarto, ?string $termek_nev, ?string $megjelenes, ?int $ar): Taviranyito
    {
        return new Taviranyito(null, $gyarto, $termek_nev, $megjelenes, $ar, 0);
    }

    public static function db_TaviranyitokMind(int $order = TAVIRANYITOK_DEFAULT, int $direction = 0): array
    {
        $res = Taviranyito::$db->read(null, $order, $direction);
        $list = [];
        if ($res === false) {
            throw new Error("Üres keresés");
        }
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

    public static function db_TaviranyitoEgy(int $id): ?Taviranyito
    {
        try {
            $res = Taviranyito::$db->read($id);
            if ($res === false) {
                throw new Error("Nem létezik ilyen elem");
            }
            $out = new Taviranyito(
                $res["id"],
                $res["gyarto"],
                $res["termek_nev"],
                $res["megjelenes"],
                $res["ar"],
                $res["elerheto"]
            );
        } catch (Error $e) {
            $out = null;
        } finally {
            return $out;
        }
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
    public function getMindenTulajdonsag(): array
    {
        $ki = [];
        foreach ($this as $key => $value) {
            $ki += array($key => $value);
        }
        return $ki;
    }

    public static function getOszlopnev(int $oszlopnev): string
    {
        $param = "";
        switch ($oszlopnev) {
            case TAVIRANYITOK_DEFAULT:
            case TAVIRANYITOK_ID:
                $param = "id";
                break;
            case TAVIRANYITOK_GYARTO:
                $param = "gyarto";
                break;
            case TAVIRANYITOK_TERMEKNEV:
                $param = "termek_nev";
                break;
            case TAVIRANYITOK_MEGJELENES:
                $param = "megjelenes";
                break;
            case TAVIRANYITOK_AR:
                $param = "ar";
                break;
            case TAVIRANYITOK_ELERHETO:
                $param = "elerheto";
                break;
            default:
                throw new Error("Nem megfelelő paraméter!");
        }
        return $param;
    }
    public static function oszlopNevRendje(?string $oszlopnev)
    {
        $param = 0;
        switch ($oszlopnev) {
            case null:
            case "id":
                $param = TAVIRANYITOK_ID;
                break;
            case "gyarto":
                $param = TAVIRANYITOK_GYARTO;
                break;
            case "termek_nev":
                $param = TAVIRANYITOK_TERMEKNEV;
                break;
            case "megjelenes":
                $param = TAVIRANYITOK_MEGJELENES;
                break;
            case "ar":
                $param = TAVIRANYITOK_AR;
                break;
            case "elerheto":
                $param = TAVIRANYITOK_ELERHETO;
                break;
            default:
                throw new Error("Nem megfelelő paraméter!");
        }
        return $param;
    }
}
Taviranyito::init();
define("TAVIRANYITOK_DEFAULT", 0);
define("TAVIRANYITOK_ID", 1);
define("TAVIRANYITOK_GYARTO", 2);
define("TAVIRANYITOK_TERMEKNEV", 3);
define("TAVIRANYITOK_MEGJELENES", 4);
define("TAVIRANYITOK_AR", 5);
define("TAVIRANYITOK_ELERHETO", 6);
