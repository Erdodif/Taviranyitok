<?php
function read($id, $rendezes, $irany)
{
    $ki = [];
    if (!empty($id)) {
        $ki = Taviranyito::db_TaviranyitoEgy($id);
    } else {
        if (isset($rendezes)) {
            $ki = Taviranyito::db_TaviranyitokMind(Taviranyito::oszlopNevRendje($rendezes), $irany);
        } else {
            $ki = Taviranyito::db_TaviranyitokMind();
        }
    }
}
?><!DOCTYPE html>
<html lang="hu">
<head>
   <?php require_once "header.php"; ?>
</head>
<body>
    
</body>
</html>