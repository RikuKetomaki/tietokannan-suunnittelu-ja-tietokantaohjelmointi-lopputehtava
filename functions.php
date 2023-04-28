<?php
//  Riku Ketomäki
function openDatabase() {
    $database = new PDO('mysql:host=localhost;dbname=chinook;charset=utf8','root','');
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $database;
}

function returnErr(PDOException $pdoex) {
    header('HTTP/1.1 500 Internal Server Error');
    $error = array('error' => $pdoex->getMessage());
    print json_encode($error);
}