<?php
require_once "Taviranyito.php";

$id = $_GET["id"] ?? $_POST["id"] ?? null;
$gyarto = $_GET["gyarto"] ?? $_POST["gyarto"] ?? null;
$termek_nev = $_GET["termek_nev"] ?? $_POST["termek_nev"] ?? null;
$megjelenes = $_GET["megjelenes"] ?? $_POST["megjelenes"] ?? null;
$ar = $_GET["ar"] ?? $_POST["ar"] ?? null;
$elerheto = $_GET["elerheto"] ?? $_POST["elerheto"] ?? null;

$ok = isset($gyarto) && isset($termek_nev) && isset($ar);

if ($ok) {
    $aktualis = new Taviranyito(
        $_GET["method"] ?? $_POST["method"] ?? null === "update" ? $id : null,
        $gyarto,
        $termek_nev,
        $megjelenes,
        $ar,
        $elerheto
    );
    echo var_dump($aktualis);
}
try {
    switch ($_GET["method"] ?? $_POST["method"] ?? "read") {
        case 'create':
            if (isset($aktualis)){
                $aktualis->db_frissit();
            }
            break;
        case 'read':
            $id = $_GET["id"] ?? $_POST["id"] ?? null !== null;
            if (!empty($id)) {
                echo var_dump(Taviranyito::db_TaviranyitoEgy($id));
            } else {
                echo var_dump(Taviranyito::db_TaviranyitokMind());
            }
            break;
        case 'update':
            break;
        case 'delete':
            break;
        default:
            break;
    }
} catch (Error $e) {
    echo var_dump($e);
}
