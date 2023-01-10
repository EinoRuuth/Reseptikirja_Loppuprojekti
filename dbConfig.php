<?php
$server = "localhost";
$user = "root";
$password = "";
$database = "keittokirja";

    
$yhteys = new mysqli($server, $user, $password, $databse);
    
if ($conn->connect_error) {
    die("Yhteyden muodostaminen epäonnistui: " .$conn->connect_error);
}
$conn->set_charset("utf8");
?>