<?php
function delete($aktualis)
{
    if (!isset($aktualis) || $aktualis->getId() === null) {
        throw new Error("Nincs ID megadva!");
    }
    return Taviranyito::torol($aktualis);
}
