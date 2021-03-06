<?php
require_once "index.php";
require_once "read.php";
function update(Taviranyito $aktualis, $extra): string | bool
{
    $params = $aktualis->getMindenTulajdonsag();
    $result = hibakereso($params);
    if (!$result && isset($_POST["sent"])) {
        $aktualis->db_frissit($aktualis->getId());
        $extra["error"]=false;
        $extra["message"]="Elem szerkesztve!";
        return read(null, null, null, $extra);
    }
    if ($result!==false){
        $extra["error"] = true;
        $extra["invalids"] = $result;
    }
    return kiHTML(formoz($aktualis), $extra ?? null);
}
function formoz(Taviranyito $taviranyito, $method = "update")
{
    if($method ==="update"){
        $id = $taviranyito->getId();
    }
    else{
        $id = "";
    }
    $termek_nev = $taviranyito->getTermekNev();
    $gyarto = $taviranyito->getGyarto();
    $megjelenes = $taviranyito->getMegjelenes();
    $ar = $taviranyito->getAr();
    $elerheto = $taviranyito->getElerheto() === 1 ? "checked" : "";

    return  "
    <div class='card col-12 col-sm-12 col-md-7 col-lg-5 col-xl-4 p-1 bg-light'>
        <img class='card-img-top p-2' src='resources/remote-control-svgrepo-com.svg' alt='Távirányító kép'>
        <form class='card-body' method='post' id='in_all'>
            <input class='in' type='hidden' name='id' value='$id' id='in_id'>
            <ul class='list-group'>
                <li class='list-group-item d-flex flex-column justify-content-between align-items-center' id='parent_termek_nev'>
                    <input class='in' type='text' id='in_termek_nev' name='termek_nev' value='$termek_nev' placeholder='termék neve' required>
                </li>
                <li class='list-group-item d-flex flex-column justify-content-between align-items-center' id='parent_gyarto'>
                    <input class='in' type='text' id='in_gyarto' name='gyarto' value='$gyarto' placeholder='Gyártó' required>
                </li>
                <li class='list-group-item d-flex flex-column justify-content-between align-items-center' id='parent_megjelenes'>
                    <input class='in' type='date' id='in_megjelenes' name='megjelenes' value='$megjelenes' placeholder='Megjelenés' required>
                </li>
                <li class='list-group-item d-flex flex-column justify-content-between align-items-center' id='parent_ar'>
                    <input class='in' type='number' id='in_ar' name='ar' value='$ar' placeholder='Ár' required>
                </li>
                <li class='list-group-item d-flex flex-column justify-content-between align-items-center' id='parent_elerheto'>
                    <input class='in' type='checkbox' id='in_elerheto' name='elerheto' $elerheto id='elerheto'>
                    <label for='elerheto'>
                        Elérhető
                    </label>
                </li>
            </ul>
            <div class='px-2 d-flex flex-row flex-wrap justify-content-between'>
                <input type='hidden' name='method' value='$method'>
                <input type='hidden' name='sent' value='true'>
                <input class='btn btn-primary col-11 col-sm-5 text-center mt-3' type='submit' value='mentés' data-toggle='tooltip' data-placement='top' title='Változtatások mentése'>
                <a class='col-11 col-sm-5 text-center mt-3 btn btn-primary' href='index.php'>
                    mégse
                </a>
            </div>
        </form>
    </div>
    ";
}
