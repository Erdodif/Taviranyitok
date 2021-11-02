<?php
require_once "index.php";
require_once "update.php";
function create(Taviranyito $aktualis, $extra): string | bool
{
    $params = array(
        "id" => null,
        "gyarto" => $aktualis->getGyarto(),
        "termek_nev" => $aktualis->getTermekNev(),
        "megjelenes" => $aktualis->getMegjelenes(),
        "ar" => $aktualis->getAr(),
        "elerheto" => $aktualis->getElerheto(),
    );
    if (!hibakereso($params) && isset($_POST["sent"])) {
        $aktualis->db_frissit();
        $extra["error"]=false;
        $extra["message"]="A hozzáadás sikeres!";
        return read(null, null, null, $extra);
    }
    return kiHTML(formoz($aktualis, "create"), $extra ?? null);
}