<?php

$servername = 'localhost';
$dbuser= 'bsubuntu';
$dbpassword = 'Zlqhem1317~';
$dbname = 'bbs'; 

try{
$db=new PDO("mysql:host={$servername};dbname={$dbname}",$dbuser,$dbpassword);
   
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,true);
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

//echo "DB연결성공";
} catch (PDOException $e){
    echo $e->getMessage();
}
