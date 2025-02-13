<?php 
/*
$servername = "localhost";
$username = "id20297774_ifpr2023";
$password = "Portuguesk9!";
$database = "id20297774_site";
*/

$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "tcc";


// Cria conexão com o BD
$conn = new mysqli($servername, $username, $password, $database);

// Verifica se deu certo a conexão
if ($conn->connect_error) {
  die("Conexão Falhou: " . $conn->connect_error);
}

?>