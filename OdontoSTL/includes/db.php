<?php
$host = 'localhost';
$dbname = 'u879415716_odontostl_dev';
$user = 'root';
$pass = ''; // ou 'senha' se tiver

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
