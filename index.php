<?php
require_once "data/Taviranyito.php";
//TODO Validáció
$method = $_GET["method"] ?? $_POST["method"] ?? "read";

$id = $_GET["id"] ?? $_POST["id"] ?? null;
$gyarto = $_GET["gyarto"] ?? $_POST["gyarto"] ?? null;
$termek_nev = $_GET["termek_nev"] ?? $_POST["termek_nev"] ?? null;
$megjelenes = $_GET["megjelenes"] ?? $_POST["megjelenes"] ?? null;
$ar = $_GET["ar"] ?? $_POST["ar"] ?? null;
$elerheto = $_GET["elerheto"] ?? $_POST["elerheto"] ?? null;

$rendezes = $_GET["rendezes"] ?? $_POST["rendezes"] ?? null;
$irany = $_GET["irany"] ?? $_POST["irany"] ?? RENDEZES_NOVEKVO;

$aktualis = Taviranyito::ujTaviranyito(
    $id,
    $gyarto,
    $termek_nev,
    $megjelenes,
    $ar,
    $elerheto
);
$extra = [];
try {
    $extra["error"] = false;
    switch ($method) {
        case 'delete':
            require_once "pages/delete.php";
            if (delete($aktualis)) {
                $extra["message"] = "Sikeres törlés";
            } else {
                throw new Error("Meghiúsult");
            }
        default:
        case 'read':
            require_once "pages/read.php";
            echo read(null, $rendezes, $irany, $extra);
            break;
        case 'create':
            require_once "pages/create.php";
            $extra["message"] = create($aktualis);
            break;
        case 'update':
            require_once "pages/update.php";
            $ki = update($aktualis, $extra);
            if ($ki === true) {
                $extra["error"] = true;
                $extra["invalids"] = hibaKereso(array(
                    "id" => $id,
                    "gyarto" => $gyarto,
                    "termek_nev" => $termek_nev,
                    "megjelenes" => $megjelenes,
                    "ar" => $ar,
                    "elerheto" => $elerheto,
                ));
            } else {
                echo $ki;
            }
            break;
        case 'flip':
            $aktualis->db_frissit();
            require_once "pages/read.php";
            echo read(null, $rendezes, $irany, $extra);
            break;
    }
} catch (Error $e) {
    $extra["error"] = true;
    $extra["message"] = $e->getMessage();
    require_once "pages/read.php";
    echo read($id, $rendezes, $irany, $extra);
}

function hibakereso(array $params): array|false
{
    $hibak = [];
    if (empty($hibak)) {
        return false;
    }
    return $hibak;
}

function extrazo(array $extra): string
{
    if ($extra === null || !isset($extra["message"])) {
        return "";
    }
    $message = $extra["message"];
    $vissza = "
        <a href='index.php' class='badge btn btn-danger bg-danger float-end' id='extra-remove'>
            X
        </a>";

    if (isset($extra["invalids"])) {
        $vissza = "
        <span class='badge btn btn-danger bg-danger float-end' id='extra-remove'>
            X
        </span>";
        $message .= "<ul class='list-group'>";
        foreach ($extra["invalids"] as $line) {
            $message .= "<li class='list-group-item'>$line</li>";
        }
        $message .= "</ul>";
    }
    if ($extra["error"] === true) {
        $class = "bg-warning text-gray";
        $tipus = "Hiba";
    } else {
        $class = "bg-primary text-white";
        $tipus = "Üzenet";
    }
    if (isset($extra["title"])) {
        $tipus = $extra["title"];
    }
    return "
    <div class='card col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4' id='extra'>
        <h2 class='card-header $class'>
            $tipus
            $vissza
        </h2>
        <h4 class='card-body'>
            $message
        </h4>
    </div>
    ";
}

function kiHTML($tartalom, $extra)
{
    $extra = extrazo($extra);
    return "
    <!DOCTYPE html>
    <html lang='hu'>
        <head>
            " . file_get_contents(__DIR__ . '/resources/header.html') . "
        </head>
        <body class='d-flex flex-column flex-wrap  justify-content-center align-items-center bg-secondary'>
            <h2 class='col-12 col-sm-11 col-md-10 col-lg-8 col-xl-7 bg-primary text-white py-4 my-0 text-center'>
                Távirányítók
            </h2>
            <div class='d-flex flex-wrap col-12 col-sm-11 col-md-10 col-lg-8 col-xl-7 bg-white p-4' id='deck'>
                $tartalom
            </div>
            <div id='extrak'>
                $extra
            </div>
        </body>
    </html>";
}
