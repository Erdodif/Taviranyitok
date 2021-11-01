<?php
function delete($aktualis)
{
    if (!isset($aktualis) || $aktualis->getId() === null) {
        return array("error" => true, "message" => "Nincs ID megadva!");
    }
    try {
        $aktualis->torol();
        $ki = "Sikeres törlés";
    } catch (Error $e) {
        throw new Error($e->getMessage());
    }
    return $ki;
}
