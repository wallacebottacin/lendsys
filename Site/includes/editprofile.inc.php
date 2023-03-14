<?php

// Verifica se tem dados submetidos pelo método POST
if (isset($_POST["editinfoprofile"])) {

    // Se conecta com a base de dados e com as funções
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    // Capta dos dados submetidos e faz verificação de segurança
    $id = mysqli_real_escape_string($conn, securityDataValidation($_POST['id']));
    $name = mysqli_real_escape_string($conn,  securityDataValidation($_POST['name']));
    $surname = mysqli_real_escape_string($conn, securityDataValidation($_POST['surname']));
    $email = mysqli_real_escape_string($conn, securityDataValidation($_POST['email']));
    $phone = mysqli_real_escape_string($conn, securityDataValidation($_POST['phone']));
    $password = mysqli_real_escape_string($conn, securityDataValidation($_POST['password']));
    $passwordRepeat = mysqli_real_escape_string($conn, securityDataValidation($_POST['passwordRepeat']));

    // INÍCIO DA DETECÇÃO E MANEJO DE ERROS

    // Detecta se existe algum campo vazio
    if (emptyInputSignup($email, $password, $name, $surname, $phone) !== false) {
        header("Location: ../editprofile.php?error=emptyinput");
        exit();
    }

    // Detecta se o e-mail é válido
    if (invalidEmail($email) !== false) {
        header("Location: ../editprofile.php?error=invalidemail");
        exit();
    }

    // Verifica se a senhas têm menos de 8 caracteres
    if(strlen($password) < 8 || strlen($passwordRepeat) < 8) {
        header("Location: ../editprofile.php?error=shortpassword");
        exit();
    }

    // Verifica se a senhas têm mais de 60 caracteres
    if(strlen($password) > 60 || strlen($passwordRepeat) > 60) {
        header("Location: ../editprofile.php?error=longpassword");
        exit();
    }

    // Verifica se o nome tem mais de 50 caracteres
    if(strlen($nome) > 50) {
        header("Location: ../editprofile.php?error=longname");
        exit();
    }
    
    // Verifica se o sobrenome tem mais de 50 caracteres
    if(strlen($sobrenome) > 50) {
        header("Location: ../editprofile.php?error=longsurname");
        exit();
    }

    // Verifica se o e-mail tem mais de 254 caracteres
    if(strlen($email) > 254) {
        header("Location: ../editprofile.php?error=longemail");
        exit();
    }

    // Verifica se o telefone tem mais de 15 caracteres
    if(strlen($phone) > 15) {
        header("Location: ../editprofile.php?error=longphone");
        exit();
    }

    // Verifica se o telefone contém apenas números
    if(!is_numeric($phone)) {
        header("Location: ../editprofile.php?error=phonenotnumber");
        exit();
    }

    // Detecta se as senhas repetidas são iguais
    if (passwordMatch($password, $passwordRepeat) !== false) {
        header("Location: ../editprofile.php?error=wrongpassword");
        exit();
    }
    

    // Detecta se o usuário já está cadastrado
    if (userExistsOrSame($conn, $email, $id) !== false) {
        header("Location: ../editprofile.php?error=userexists");
        exit();
    }


    // Se não encontrar problemas, cria o usuário
    editUser($conn, $id, $name, $surname, $email, $phone, $password);
    
      

} else {


    // Redireciona para a página abaixo se não encontrar o método POST
    header("Location: ../index.php");

}

?>