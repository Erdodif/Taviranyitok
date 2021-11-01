<?php
require_once "data/Taviranyito.php";
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
    $method === ("update" ? $id : ($method === "delete" ? $id : null)),
    $gyarto,
    $termek_nev,
    $megjelenes,
    $ar,
    $elerheto
);
$extra = [];
try {
    $extra["error"] = false;
    switch ($_GET["method"] ?? $_POST["method"] ?? "read") {
        case 'create':
            require_once "pages/create.php";
            $extra["message"] = create($aktualis);
            break;
        case 'update':
            require_once "pages/update.php";
            $extra["message"] = update($aktualis);
            break;
        case 'delete':
            require_once "pages/delete.php";
            $extra["message"] = delete($aktualis);
            break;
        default:
            break;
    }
} catch (Error $e) {
    $extra["error"] = true;
    $extra["message"] = $e->getMessage();
} finally {
    require_once "pages/read.php";
    echo read($id, $rendezes, $irany, extrazo($extra));
}
function extrazo(array $extra):string{
    if(!isset($extra["message"])){
        return "";
    }
    $message = $extra["message"];
    if($extra["error"]===true){
        $class = "bg-warning text-gray";
        $tipus = "Hiba";
    }
    else{
        $class = "bg-primary text-white";
        $tipus = "Üzenet";
    }
    return "
    <div class='card col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4' id='extra'>
        <h2 class='card-header $class'>
            $tipus
            <span class='badge btn btn-danger bg-danger float-end' id='extra-remove'>
                X
            </span>
        </h2>
        <h4 class='card-body'>
            $message
        </h4>
    </div>
    ";
}