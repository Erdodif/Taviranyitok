<?php
require_once "Taviranyito.php";
//TODO VAlidáció
$id = $_GET["id"] ?? $_POST["id"] ?? null;
$gyarto = $_GET["gyarto"] ?? $_POST["gyarto"] ?? null;
$termek_nev = $_GET["termek_nev"] ?? $_POST["termek_nev"] ?? null;
$megjelenes = $_GET["megjelenes"] ?? $_POST["megjelenes"] ?? null;
$ar = $_GET["ar"] ?? $_POST["ar"] ?? null;
$elerheto = $_GET["elerheto"] ?? $_POST["elerheto"] ?? null;
$rendezes = $_GET["rendezes"] ?? $_POST["rendezes"] ?? null;
$irany = $_GET["irany"] ?? $_POST["irany"] ?? 0;

$aktualis = new Taviranyito(
    $_GET["method"] ?? $_POST["method"] ?? null === "update" ? $id : null,
    $gyarto,
    $termek_nev,
    $megjelenes,
    $ar,
    $elerheto
);
try {
    switch ($_GET["method"] ?? $_POST["method"] ?? "read") {
        case 'create':
            if (isset($aktualis)) {
                $aktualis->db_frissit();
            }
            break;
        case 'read':
            $id = $_GET["id"] ?? $_POST["id"] ?? null !== null;
            if (!empty($id)) {
                echo var_dump(Taviranyito::db_TaviranyitoEgy($id))."<br>";
                echo ($aktualis->letezikIlyenId()?"létezik":"nem létezik")."<br>";
                echo ($aktualis->teljes()?"helyes":"nem helyes")."<br>";
            } else {
                if (isset($rendezes)){
                    echo var_dump(Taviranyito::db_TaviranyitokMind(Taviranyito::oszlopNevRendje($rendezes),$irany));
                }
                else{
                    echo var_dump(Taviranyito::db_TaviranyitokMind());
                }
            }
            break;
        case 'update':
            if (!isset($aktualis) || $aktualis->getId() === null) {
                throw new Error("Nincs ID megadva!");
            }
            $aktualis->db_frissit($aktualis->getId());
            break;
        case 'delete':
            if (!isset($aktualis) || $aktualis->getId() === null) {
                throw new Error("Nincs ID megadva!");
            }
            $aktualis->torol();
            break;
        default:
            break;
    }
} catch (Error $e) {
    echo $e->getMessage();
}
