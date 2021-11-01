<?php
require_once "index.php";
require_once "read.php";
function update(Taviranyito $aktualis, $extra): string | bool
{/*
    if (!isset($aktualis) || $aktualis->getId() === null) {
        throw new Error("Nincs ID megadva!");
    }*/
    $params = array(
        "id"=> $aktualis->getId(),
        "gyarto"=> $aktualis->getGyarto(),
        "termek_nev"=> $aktualis->getTermekNev(),
        "megjelenes"=> $aktualis->getMegjelenes(),
        "ar"=> $aktualis->getAr(),
        "elerheto"=> $aktualis->getElerheto(),
    );
    if (!hibakereso($params) && isset($_POST["sent"])) {
        $aktualis->db_frissit($aktualis->getId());
        return read(null,null,null,$extra);
    }
    return kiHTML(formoz($aktualis), $extra ?? null);
}
function formoz(Taviranyito $taviranyito, $method = "update")
{
    $id = $taviranyito->getId();
    $termek_nev = $taviranyito->getTermekNev();
    $gyarto = $taviranyito->getGyarto();
    $megjelenes = $taviranyito->getMegjelenes();
    $ar = $taviranyito->getAr();
    $elerheto = $taviranyito->getElerheto();

    return  "
    <div class='card col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 p-1 bg-light'>
        <img class='card-img-top p-2' src='resources/remote-control-svgrepo-com.svg' alt='Távirányító kép'>
        <form class='card-body' method='post'>
            <input type='hidden' name='id' value='$id' id='in_id'>
            <div class='card-title text-center col-12'>
                <input type='text' id='in_termek_nev' name='termek_nev' value='$termek_nev' placeholder='termék neve'>
            </div>
            <ul class='list-group'>
                <li class='list-group-item d-flex justify-content-between align-items-center'>
                    <input type='text' id='in_gyarto' name='gyarto' value='$gyarto' placeholder='Gyártó'>
                </li>
                <li class='list-group-item d-flex justify-content-between align-items-center'>
                    <input type='date' id='in_megjelenes' name='megjelenes' value='$megjelenes' placeholder='Megjelenés'>
                </li>
                <li class='list-group-item d-flex justify-content-between align-items-center'>
                    <input type='number' id='in_ar' name='ar' value='$ar' placeholder='Ár'>
                </li>
                <li class='list-group-item d-flex justify-content-between align-items-center'>
                    <input type='checkbox' id='in_elerheto' name='elerheto' value='$elerheto' id='elerheto'>
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
