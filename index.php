<?php
header("Content-type: application/json");
require_once "DB.php";
$db = new DB();
$response = array();
$response["error"] = false;
switch ($_GET["method"] ?? $_POST["method"] ?? "empty") {
    case "create":
        try {
            $gyarto = $_GET["gyarto"] ?? $_POST["gyarto"] ?? null;
            $termek_nev = $_GET["termek_nev"] ?? $_POST["termek_nev"] ?? null;
            $megjelenes = $_GET["megjelenes"] ?? $_POST["megjelenes"] ?? null;
            $ar = $_GET["ar"] ?? $_POST["ar"] ?? null;
            $siker;
            if (empty($gyarto) || empty($termek_nev) || empty($ar)) {
                throw new Error("Hiányzó adat!");
            }
            if (!empty($kiadas)) {
                $params = array(
                    "gyarto"=>$gyarto,
                    "termek_nev"=>$termek_nev,
                    "megjelenes"=>$megjelenes,
                    "ar"=>$ar
                );
                echo "feltöltés kiadaás éve alapértéken";
                $db->felvetel($params);
            } else {
                $params = array(
                    "gyarto"=>$gyarto,
                    "termek_nev"=>$termek_nev,
                    "ar"=>$ar
                );
                echo "feltöltés minden adattal";
                $db->felvetel($params);
            }
            $response["error"] = false;
        } catch (Error $e) {
            $response["error"] = true;
            $response["message"] = $e->getMessage();
        }
        break;
    case "read":
        try {
            if (isset($_GET["id"]) || isset($_POST["id"])) {
                $egyezes = (object) array("id" => $_GET["id"] ?? $_POST["id"]);
                $response["data"] = $db->listazasHaEgyenlo($egyezes);
            } else {
                $response["data"] = $db->listazas();
            }
        } catch (Error $e) {
            $response["error"] = true;
            $response["message"] = $e->getMessage();
        }
        break;
    case "update":

        break;
    case "delete":

        break;
    default:
        $response["error"] = true;
        $response["message"] = "Nem megfelelő paraméterek!";
        break;
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);
