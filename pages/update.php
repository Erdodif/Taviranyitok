<?php
require_once "index.php";
function update($aktualis, $extra)
{
    if (!isset($aktualis) || $aktualis->getId() === null) {
        throw new Error("Nincs ID megadva!");
    }
    if ($extra["error"] === false || !isset($extra["invalids"])) {
        $aktualis->db_frissit($aktualis->getId());
        return $extra;
    }
    else{
        return kiHTML(formoz($aktualis), $extra ?? null);
    }
}
function formoz(Taviranyito $taviranyito)
{
    $id = $taviranyito->getId();
    $termek_nev = $taviranyito->getTermekNev();
    $gyarto = $taviranyito->getGyarto();
    $megjelenes = $taviranyito->getMegjelenes();
    $ar = $taviranyito->getAr();
    $elerheto = $taviranyito->getElerheto();

    return  "
    <div class='card col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 p-1'>
        <img class='card-img-top p-2' src='resources/remote-control-svgrepo-com.svg' alt='Távirányító kép'>
        <form class='card-body' method='post'>
            <input type='hidden' name='id' value='$id'>
            <div class='card-title text-center col-12'>
                <input type='text' name='termek_nev' value='$termek_nev' placeholder='termék neve'>
            </div>
            <ul class='list-group'>
                <li class='list-group-item d-flex justify-content-between align-items-center'>
                    <input type='text' name='gyarto' value='$gyarto' placeholder='Gyártó'>
                </li>
                <li class='list-group-item d-flex justify-content-between align-items-center'>
                    <input type='date' name='megjelenes' value='$megjelenes' placeholder='Megjelenés'>
                </li>
                <li class='list-group-item d-flex justify-content-between align-items-center'>
                    <input type='number' name='ar' value='$ar' placeholder='Ár'>
                </li>
                <li class='list-group-item d-flex justify-content-between align-items-center'>
                    <input type='checkbox' name='elerheto' value='$elerheto' id='elerheto'>
                    <label for='elerheto'>
                        Elérhető
                    </label>
                </li>
            </ul>
            <div class='row px-2'>
                <input type='hidden' name='method' value='read'>
                <input class='btn btn-primary' type='submit' value='mentés' data-toggle='tooltip' data-placement='top' title='Változtatások mentése'>
                <a class='col-12 col-sm-6 text-center mt-3 btn btn-primary' href='index.php'>
                    mégse
                </a>
            </form>
        </div>
    </div>
    ";
}
