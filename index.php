<?php
require_once "Taviranyito.php";
//TODO Validáció
$method = $_GET["method"] ?? $_POST["method"] ?? null;

$id = $_GET["id"] ?? $_POST["id"] ?? null;
$gyarto = $_GET["gyarto"] ?? $_POST["gyarto"] ?? null;
$termek_nev = $_GET["termek_nev"] ?? $_POST["termek_nev"] ?? null;
$megjelenes = $_GET["megjelenes"] ?? $_POST["megjelenes"] ?? null;
$ar = $_GET["ar"] ?? $_POST["ar"] ?? null;
$elerheto = $_GET["elerheto"] ?? $_POST["elerheto"] ?? null;

$rendezes = $_GET["rendezes"] ?? $_POST["rendezes"] ?? null;
$irany = $_GET["irany"] ?? $_POST["irany"] ?? 0;

$aktualis = new Taviranyito(
    $method === "update" ? $id : null,
    $gyarto,
    $termek_nev,
    $megjelenes,
    $ar,
    $elerheto
);
try {
    switch ($_GET["method"] ?? $_POST["method"] ?? "read") {
        case 'create':
            require_once "create.php";
            create($aktualis);
            break;
        case 'read':
            require_once "read.php";
            read($id, $rendezes, $irany);
            break;
        case 'update':
            require_once "update.php";
            update($aktualis);
            break;
        case 'delete':
            require_once "delete.php";
            delete($aktualis);
            break;
        default:
            break;
    }
} catch (Error $e) {
    echo $e->getMessage();
}