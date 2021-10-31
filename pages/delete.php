<?php
function delete($aktualis)
{
    if (!isset($aktualis) || $aktualis->getId() === null) {
        throw new Error("Nincs ID megadva!");
    }
    $aktualis->torol();
}
?><!DOCTYPE html>
<html lang="hu">
<head>
   <?php require_once __DIR__."/../resources/header.php"; ?>
</head>
<body>
    
</body>
</html>