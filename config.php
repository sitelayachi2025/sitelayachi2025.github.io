<?php

$servername = "sql7.freesqldatabase.com";
$username = "sql7768024 ";
$password = "E9RlyVmAZ2";
$dbname = "sql7768024";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if($conn){
    echo 'باسم الله الرحمان الرحيم والحمد لله رب العالمين';
}
else{
    echo 'DB Not Conect :';
}


?>

