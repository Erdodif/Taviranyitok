<?php
function create($aktualis)
{
    if (isset($aktualis)) {
        $aktualis->db_frissit();
    }
}
?><!DOCTYPE html>
<html lang="hu">
<head>
   <?php require_once __DIR__."/../resources/header.html"; ?>
</head>
<body>
</body>
</html>