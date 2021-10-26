<?php
require_once "DB.php";
$db = new DB();
try {
    switch ($_GET["method"] ?? $_POST["method"] ?? null) {
        case 'create':
            $gyarto = $_GET["gyarto"] ?? $_POST["gyarto"] ?? null;
            $termek_nev = $_GET["termek_nev"] ?? $_POST["termek_nev"] ?? null;
            $megjelenes = $_GET["megjelenes"] ?? $_POST["megjelenes"] ?? null;
            $ar = $_GET["ar"] ?? $_POST["ar"] ?? null;
            $elerheto = $_GET["elerheto"]?? $_POST["elerheto"] ?? null;
            $ok = isset($gyarto) &&
                isset($termek_nev) &&
                isset($ar);
            echo var_dump($gyarto);
            echo var_dump($termek_nev);
            echo var_dump($ar);
            echo var_dump($megjelenes);
            echo var_dump($elerheto);
            if ($ok) {
                $ok = $db->create($gyarto, $termek_nev, $ar, $megjelenes, $elerheto);
                echo var_dump($ok);
                if ($ok){
                    echo "siker";
                }
                else{
                    throw new Error("Valami nem stimmelt...");
                }
            } else {
                throw new Error("Nincs elég paraméter!");
            }
            break;
        case 'read':
            echo var_dump($db->read($_GET["id"] ?? $_POST["id"] ?? null));
            break;
        case 'update':
            break;
        case 'delete':
            break;
        default:
            throw new Error('Nem megfelelő paraméterek!');
            break;
    }
} catch (Error $e) {
}
