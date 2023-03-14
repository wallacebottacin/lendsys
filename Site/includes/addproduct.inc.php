<?php

// Se conecta com a base de dados e com as funções
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

// Verifica se tem dados submetidos pelo método POST
if (isset($_POST["submit"])) {

    // Capta dos dados submetidos e faz verificação de segurança
    $name = mysqli_real_escape_string($conn, securityDataValidation($_POST['name']));
    $description = mysqli_real_escape_string($conn, securityDataValidation($_POST['description']));
    $category = mysqli_real_escape_string($conn,  securityDataValidation($_POST['category']));
    $quantity = mysqli_real_escape_string($conn, securityDataValidation($_POST['quantity']));
    $totalborrowed = mysqli_real_escape_string($conn, securityDataValidation(0));

    // INÍCIO DA DETECÇÃO E MANEJO DE ERROS

    // Verifica se a quantidade é maior que zero
    if($quantity < 1) {
        header("Location: ../addproduct.php?error=zerostock");
        exit();
    }

    // Detecta se existe algum campo vazio
    if (emptyInputAddProduct($name, $description, $category, $quantity) !== false) {
        header("Location: ../addproduct.php?error=emptyinput");
        exit();
    }

    // Verifica se o nome tem mais de 45 caracteres
    if(strlen($name) > 45) {
        header("Location: ../addproduct.php?error=longname");
        exit();
    }
    
    // Verifica se a descrição tem mais de 60 caracteres
    if(strlen($description) > 60) {
        header("Location: ../addproduct.php?error=longdescription");
        exit();
    }

    // Verifica se a categoria tem mais de 45 caracteres
    if(strlen($category) > 45) {
        header("Location: ../addproduct.php?error=longcategory");
        exit();
    }

    // Verifica se a quantidade contém apenas números
    if(!is_numeric($quantity)) {
        header("Location: ../addproduct.php?error=quantitynotnumber");
        exit();
    }


    // Se não encontrar problemas, cria o produto
    addProduct($conn, $name, $description, $category, $quantity, $totalborrowed);
    
    $stmt = mysqli_stmt_init($conn); // Initializes a statement and returns an object suitable for mysqli_stmt_prepare

    

} else {


    // Redireciona para a página abaixo se não encontrar o método POST
    header("Location: ../addproduct.php");

}


?>