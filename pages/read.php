<?php
function kartyasit(Taviranyito $taviranyito): string
{


    return "";
}

function read($id, $rendezes, $irany)
{
    $kartyak = "";
    $taviranyitok = [];
    if (!empty($id)) {
        $taviranyitok = Taviranyito::db_TaviranyitoEgy($id);
    } else {
        if (isset($rendezes)) {
            $taviranyitok = Taviranyito::db_TaviranyitokMind(Taviranyito::oszlopNevRendje($rendezes), $irany);
        } else {
            $taviranyitok = Taviranyito::db_TaviranyitokMind();
        }
    }
    foreach ($taviranyitok as $elem) {
        $kartyak .= kartyasit($elem);
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
    <head>
        <?php require_once __DIR__."/../resources/header.php"; ?>
    </head>
    <body>
    </body>
</html>