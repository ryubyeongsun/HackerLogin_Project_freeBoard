<?php
$servername = 'localhost';
$username = 'bsubuntu';
$password = 'Zlqhem1317~';
$db = 'bbs'; 

try{
$conn = new PDO("mysql:host=".$servername.";dbname=".$db, $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//echo "DB 연결 성공";
} catch (PDOException $e){
    echo "Connetion failed: ". $e->getMessage();
}