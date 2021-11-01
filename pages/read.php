<?php
function kartyasit(Taviranyito $taviranyito): string
{
    $id = $taviranyito->getId();
    $termek_nev = $taviranyito->getTermekNev();
    $gyarto = $taviranyito->getGyarto();
    $megjelenes = $taviranyito->getMegjelenes();
    $ar = $taviranyito->getAr();
    $elerheto = $taviranyito->getElerheto();
    return "
    <div class='card col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 p-1'>
        <img class='card-img-top p-2' src='resources/remote-control-svgrepo-com.svg' alt='Távirányító kép'>
            <div class='card-body'>
                <a class='card-title text-center col-12' href='../index.php'>
                    <form class='badge badge-pill m-0 p-0 text-center col-12' method='post' data-toggle='tooltip' data-placement='top' title='Rendezés termék neve alapján'>
                        <input type='hidden' name='method' value='read'>
                        <input type='hidden' name='rendezes' value='termek_nev'>
                        <input type='hidden' name='irany' value='0'>
                        <h4 class='text-center'>
                            <input class='btn btn-light' type='submit' value='$termek_nev'>
                        </h4>
                    </form>
                </a>
                <ul class='list-group'>
                    <li class='list-group-item d-flex justify-content-between align-items-center'>
                        $gyarto
                        <a href='../index.php'>
                            <form class='badge badge-pill m-0 p-0' method='post' data-toggle='tooltip' data-placement='top' title='Rendezés a Gyártó alapján'>
                                <input type='hidden' name='method' value='read'>
                                <input type='hidden' name='rendezes' value='gyarto'>
                                <input type='hidden' name='irany' value='0'>
                                <input class='btn btn-primary py-0 px-2 font-weight-bold' type='submit' value='Gyártó'>
                            </form>
                        </a>
                    </li>
                    <li class='list-group-item d-flex justify-content-between align-items-center'>
                        $megjelenes
                        <a href='../index.php'>
                            <form class='badge badge-pill m-0 p-0' method='post' data-toggle='tooltip' data-placement='top' title='Rendezés a megjelenés ideje szerint'>
                                <input type='hidden' name='method' value='read'>
                                <input type='hidden' name='rendezes' value='megjelenes'>
                                <input type='hidden' name='irany' value='0'>
                                <input class='btn btn-primary py-0 px-2 font-weight-bold' type='submit' value='Megjelenéss'>
                            </form>
                        </a>
                    </li>
                    <li class='list-group-item d-flex justify-content-between align-items-center'>
                        $ar
                        <a href='../index.php'>
                            <form class='badge badge-pill m-0 p-0' method='post' data-toggle='tooltip' data-placement='top' title='Rendezés ár szerint'>
                                <input type='hidden' name='method' value='read'>
                                <input type='hidden' name='rendezes' value='ar'>
                                <input type='hidden' name='irany' value='0'>
                                <input class='btn btn-primary py-0 px-2 font-weight-bold' type='submit' value='Ár'>
                            </form>
                        </a>
                    </li>
                    <li class='list-group-item d-flex justify-content-between align-items-center'>
                        $elerheto
                        <a href='../index.php'>
                            <form class='badge badge-pill m-0 p-0' method='post' data-toggle='tooltip' data-placement='top' title='Előre az elérhetőeket'>
                                <input type='hidden' name='method' value='read'>
                                <input type='hidden' name='rendezes' value='elerheto'>
                                <input type='hidden' name='irany' value='0'>
                                <input class='btn btn-primary py-0 px-2 font-weight-bold' type='submit' value='Elérhető'>
                            </form>
                        </a>
                    </li>
                </ul>
            <div class='d-flex flex-row flex-wrap px-2 justify-content-between'>
                <form class='col-12 col-md-6' method='post' class='text-center mt-3'>
                    <input type='hidden' name='method' value='update'>
                    <input type='hidden' name='id' value='$id'>
                    <input type='hidden' name='gyarto' value='$gyarto'>
                    <input type='hidden' name='termek_nev' value='$termek_nev'>
                    <input type='hidden' name='megjelenes' value='$megjelenes'>
                    <input type='hidden' name='ar' value='$ar'>
                    <input type='hidden' name='elerheto' value='$elerheto'>
                    <input class='btn btn-primary' type='submit' value='Szerkesztés' data-toggle='tooltip' data-placement='top' title='Termék szerkesztése'>
                </form>
                
                <form class='col-12 col-md-6' method='post' class='text-center mt-3'>
                    <input type='hidden' name='method' value='delete'>
                    <input type='hidden' name='id' value='$id'>
                    <input type='hidden' name='gyarto' value='$gyarto'>
                    <input type='hidden' name='termek_nev' value='$termek_nev'>
                    <input type='hidden' name='megjelenes' value='$megjelenes'>
                    <input type='hidden' name='ar' value='$ar'>
                    <input type='hidden' name='elerheto' value='$elerheto'>
                    <input class='btn btn-danger' type='submit' value='Törlés' data-toggle='tooltip' data-placement='top' title='Termék eltávolítása'>
                </form>
            </div>
        </div>
    </div>
    ";
}
function hany($mit)
{
    echo var_dump($mit);
}

function read($id, $rendezes, $irany)
{
    $kartyak = "";
    $taviranyitok = [];
    if (!empty($id)) {
        $taviranyito = Taviranyito::db_TaviranyitoEgy($id);
        if ($taviranyito === null) {
            /*
            $kartyak .= "
            <div class='bg-light'>
                <h1 class='col-12 text-center text-danger'>
                    404 - Az erőforrás nem található
                </h1>
                <a href='index.php' class='btn btn-primary'>
                    Vissza
                </a>
            </div>";*/
            $hiba = __DIR__ . '/../resources/error.html';
            $kartyak .= file_get_contents($hiba);
        } else {
            $kartyak .= kartyasit($taviranyito);
        }
    } else {
        if (isset($rendezes)) {
            $taviranyitok = Taviranyito::db_TaviranyitokMind(Taviranyito::oszlopNevRendje($rendezes), $irany);
        } else {
            $taviranyitok = Taviranyito::db_TaviranyitokMind();
        }
        foreach ($taviranyitok as $elem) {
            $kartyak .= kartyasit($elem);
        }
    }
    return kiHTML($kartyak);
}
function kiHTML($tartalom)
{
    return "
    <!DOCTYPE html>
    <html lang='hu'>
        <head>
            " . mb_substr(require(__DIR__ . '/../resources/header.html'), 1) . "
        </head>
        <body class='d-flex flex-column flex-wrap  justify-content-center align-items-center bg-secondary'>
            <h2 class='col-12 col-sm-11 col-md-10 col-lg-8 col-xl-7 bg-primary text-white py-4 my-0 text-center'>
                Távirányítók
            </h2>
            <div class='d-flex flex-wrap col-12 col-sm-11 col-md-10 col-lg-8 col-xl-7 bg-white p-4'>
                $tartalom
            </div>
        </body>
    </html>";
}
