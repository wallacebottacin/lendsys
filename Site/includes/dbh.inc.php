<?php

// Conexão do PHP com o banco de dados
$dbServername = "localhost:3306"; /* Nome do servidor, trocar quando estiver na hospedagem */
$dbUsername = "wallac58_lendsysadmin"; /* Usuário da base de dados, trocar quando estiver na hospedagem */
$dbPassword = "lendsysadmiN777"; /* Senha da base de dados, trocar quando estiver na hospedagem */
$dbName = "wallac58_lendsys";   /* Nome da base de dados */

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

?>