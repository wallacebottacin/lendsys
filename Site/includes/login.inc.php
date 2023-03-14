<?php

// Verifica se existe uma submissão de login pelo POST
if (isset($_POST["submit"])) {

    // Se conecta a base de dados e também às funções
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    // Capta dos dados submetidos e faz uma checagem de segurança
    $email = mysqli_real_escape_string($conn, securityDataValidation($_POST["email"]));
    $password = mysqli_real_escape_string($conn, securityDataValidation($_POST["password"]));

    // Verifica se não tem nenhum campo vazio
    if (emptyInputLogin($email, $password) !== false) {
        header("Location: ../login.php?error=emptyinput");
        exit();
    }

    // Chama a função de login do usuário
    loginUser($conn, $email, $password);

}

?>