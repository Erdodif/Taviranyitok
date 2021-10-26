<?php
require_once "DB.php";
$db = new DB();
echo var_dump($db->olvas());
echo var_dump($_GET ?? $_POST);