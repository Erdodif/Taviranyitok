<?php
function update($aktualis)
{
    if (!isset($aktualis) || $aktualis->getId() === null) {
        throw new Error("Nincs ID megadva!");
    }
    $aktualis->db_frissit($aktualis->getId());
}
?><!DOCTYPE html>
<html lang="hu">
<head>
   <?php require_once __DIR__."/../resources/header.php"; ?>
</head>
<body>
    
</body>
</html>