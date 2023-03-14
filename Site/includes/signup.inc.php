<?php

// Verifica se tem dados submetidos pelo método POST
if (isset($_POST["submit"])) {

    // Se conecta com a base de dados e com as funções
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    // Capta dos dados submetidos e faz verificação de segurança
    $email = mysqli_real_escape_string($conn, securityDataValidation($_POST['email']));
    $password = mysqli_real_escape_string($conn, securityDataValidation($_POST['password']));
    $name = mysqli_real_escape_string($conn,  securityDataValidation($_POST['name']));
    $surname = mysqli_real_escape_string($conn, securityDataValidation($_POST['surname']));
    $phone = mysqli_real_escape_string($conn, securityDataValidation($_POST['phone']));
    $role = mysqli_real_escape_string($conn, securityDataValidation(2));
    $passwordRepeat = mysqli_real_escape_string($conn, securityDataValidation($_POST['passwordRepeat']));

    // INÍCIO DA DETECÇÃO E MANEJO DE ERROS

    // Detecta se existe algum campo vazio
    if (emptyInputSignup($email, $password, $name, $surname, $phone) !== false) {
        header("Location: ../signup.php?error=emptyinput");
        exit();
    }

    // Detecta se o e-mail é válido
    if (invalidEmail($email) !== false) {
        header("Location: ../signup.php?error=invalidemail");
        exit();
    }

    // Verifica se a senhas têm menos de 8 caracteres
    if(strlen($password) < 8 || strlen($passwordRepeat) < 8) {
        header("Location: ../signup.php?error=shortpassword");
        exit();
    }

    // Verifica se a senhas têm mais de 60 caracteres
    if(strlen($password) > 60 || strlen($passwordRepeat) > 60) {
        header("Location: ../signup.php?error=longpassword");
        exit();
    }

    // Verifica se o nome tem mais de 50 caracteres
    if(strlen($nome) > 50) {
        header("Location: ../signup.php?error=longname");
        exit();
    }
    
    // Verifica se o sobrenome tem mais de 50 caracteres
    if(strlen($sobrenome) > 50) {
        header("Location: ../signup.php?error=longsurname");
        exit();
    }

    // Verifica se o e-mail tem mais de 254 caracteres
    if(strlen($email) > 254) {
        header("Location: ../signup.php?error=longemail");
        exit();
    }

    // Verifica se o telefone tem mais de 15 caracteres
    if(strlen($phone) > 15) {
        header("Location: ../signup.php?error=longphone");
        exit();
    }

    // Verifica se o telefone contém apenas números
    if(!is_numeric($phone)) {
        header("Location: ../signup.php?error=phonenotnumber");
        exit();
    }

    // Detecta se as senhas repetidas são iguais
    if (passwordMatch($password, $passwordRepeat) !== false) {
        header("Location: ../signup.php?error=wrongpassword");
        exit();
    }
    

    // Detecta se o usuário já está cadastrado
    if (userExists($conn, $email) !== false) {
        header("Location: ../signup.php?error=userexists");
        exit();
    }


    // Se não encontrar problemas, cria o usuário
    createUser($conn, $email, $password, $name, $surname, $phone, $role);
 
} else {

    // Redireciona para a página abaixo se não encontrar o método POST
    header("Location: ../signup.php");

}

?>