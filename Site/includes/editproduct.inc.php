<?php

// Verifica se tem dados submetidos pelo método POST
if (isset($_POST["editProductStep2"])) {

    // Se conecta com a base de dados e com as funções
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    // Capta dos dados submetidos e faz verificação de segurança
    $id = mysqli_real_escape_string($conn, securityDataValidation($_POST['id']));
    $name = mysqli_real_escape_string($conn, securityDataValidation($_POST['name']));
    $description = mysqli_real_escape_string($conn, securityDataValidation($_POST['description']));
    $category = mysqli_real_escape_string($conn, securityDataValidation($_POST['category']));
    $quantity = mysqli_real_escape_string($conn, securityDataValidation($_POST['quantity']));
    $totalborrowed = mysqli_real_escape_string($conn, securityDataValidation($_POST['totalborrowed']));


     // INÍCIO DA DETECÇÃO E MANEJO DE ERROS

    // Verifica se tem campos vazios
    if (empty($name) ||  empty($description) ||  empty($category) ||  empty($quantity)) {
        header("Location: ../displayproducts.php?error=emptyfield");
        exit();
    }

    //Verifica se não está alterando as quantidades disponíveis
    if ($quantity < $totalborrowed) {
        header("Location: ../displayproducts.php?error=availabilityerror");
        exit();
    }

    // Se não encontrar problemas, cria o usuário
    editProduct($conn, $id, $name, $description, $category, $quantity, $totalborrowed);
    


} else {


    // Redireciona para a página abaixo se não encontrar o método POST
    header("Location: ./index.php");

}
