<?php

// Verifica se tem dados submetidos pelo método POST
if (isset($_POST["returnproduct"])) {

    // // Se conecta com a base de dados e com as funções
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    // Capta dos dados submetidos e faz verificação de segurança
    $id = mysqli_real_escape_string($conn, securityDataValidation($_POST['id']));
    $name = mysqli_real_escape_string($conn, securityDataValidation($_POST['name']));
    $description = mysqli_real_escape_string($conn, securityDataValidation($_POST['description']));
    $category = mysqli_real_escape_string($conn, securityDataValidation($_POST['category']));
    $quantity = mysqli_real_escape_string($conn, securityDataValidation($_POST['quantity']));
    $totalborrowed = mysqli_real_escape_string($conn, securityDataValidation($_POST['totalborrowed']));
    $returnedQuantity = mysqli_real_escape_string($conn, securityDataValidation($_POST['returnedQuantity']));
    $emailuser = mysqli_real_escape_string($conn, securityDataValidation($_POST['emailuser']));

    // INÍCIO DA DETECÇÃO E MANEJO DE ERROS

    // Verifica se tem campos vazios
    if (empty($id) || empty($name) ||  empty($description) ||  empty($category) ||  empty($quantity) ||  empty($returnedQuantity)  || empty($emailuser)) {
        header("Location: ../displayproducts.php?error=emptyfield");
        exit();
    }

    // Detecta se o e-mail é válido
    if (invalidEmail($emailuser) !== false) {
        header("Location: ../displayproducts.php?error=invalidemail");
        exit();
    }

    // Se não encontrar problemas, realiza o empréstimo
    makeReturn($conn, $id, $name, $description, $category, $quantity, $totalborrowed, $returnedQuantity, $emailuser);
    

} else {


    // Redireciona para a página abaixo se não encontrar o método POST
    header("Location: ../index.php");

}

?>