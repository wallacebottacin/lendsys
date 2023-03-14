<?php

// Se conecta com a base de dados e com as funções
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

// Verifica se tem dados submetidos pelo método POST
if (isset($_POST["submit"])) {

    // Capta dos dados submetidos e faz verificação de segurança
    $street = mysqli_real_escape_string($conn, securityDataValidation($_POST['street']));
    $number = mysqli_real_escape_string($conn, securityDataValidation($_POST['number']));
    $complement = mysqli_real_escape_string($conn, securityDataValidation($_POST['complement']));
    $neighborhood = mysqli_real_escape_string($conn, securityDataValidation($_POST['neighborhood']));
    $city = mysqli_real_escape_string($conn, securityDataValidation($_POST['city']));
    $state = mysqli_real_escape_string($conn, securityDataValidation($_POST['state']));
    $country = mysqli_real_escape_string($conn, securityDataValidation($_POST['country']));
    $postalcode = mysqli_real_escape_string($conn, securityDataValidation($_POST['CEP']));
    $user_id = mysqli_real_escape_string($conn, securityDataValidation($_POST['user_id']));
    
    
    // INÍCIO DA DETECÇÃO E MANEJO DE ERROS

    // Verifica se alguns campos importantes não estão em branco
    if (emptyInputAddAddress($street, $city, $postalcode) !== false) {
        header("Location: ../addaddress.php?error=emptyinput");
        exit();
    }

    // Verifica se rua tem mais de 100 caracteres
    if(strlen($street) > 100) {
        header("Location: ../addaddress.php?error=longstreet");
        exit();
    }
    
    // Verifica se o número tem mais de 45 caracteres
    if(strlen($number) > 45) {
        header("Location: ../addaddress.php?error=longnumber");
        exit();
    }

    // Verifica se o complemento tem mais de 45 caracteres
    if(strlen($complement) > 45) {
        header("Location: ../addaddress.php?error=longcomplement");
        exit();
    }

    // Verifica se a cidade tem mais de 45 caracteres
    if(strlen($city) > 45) {
        header("Location: ../addaddress.php?error=longcity");
        exit();
    }

    // Verifica se o estado tem mais de 20 caracteres
    if(strlen($state) > 20) {
        header("Location: ../addaddress.php?error=longstate");
        exit();
    }

    // Verifica se o estado tem mais de 45 caracteres
    if(strlen($country) > 45) {
        header("Location: ../addaddress.php?error=longcountry");
        exit();
    }

    // Verifica se o CEP tem mais de 11 caracteres
    if(strlen($postalcode) > 45) {
        header("Location: ../addaddress.php?error=longcep");
        exit();
    }

    // Verifica se a quantidade contém apenas números
    if(!is_numeric($postalcode)) {
        header("Location: ../addaddress.php?error=cepnotnumber");
        exit();
    }
    

    // Se não encontrar problemas, cria o produto
    addAddress($conn, $street, $number, $complement, $neighborhood, $city, $state, $country, $postalcode, $user_id);
    
    $stmt = mysqli_stmt_init($conn); // Initializes a statement and returns an object suitable for mysqli_stmt_prepare

    

} else {


    // Redireciona para a página abaixo se não encontrar o método POST
    header("Location: ../addaddress.php");

}

?>