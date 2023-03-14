<?php

// Conexão do PHP com o banco de dados
$dbServername = "*********"; /* Nome do servidor, trocar quando estiver na hospedagem */
$dbUsername = "*********"; /* Usuário da base de dados, trocar quando estiver na hospedagem */
$dbPassword = "*********"; /* Senha da base de dados, trocar quando estiver na hospedagem */
$dbName = "*********";   /* Nome da base de dados */

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

?>