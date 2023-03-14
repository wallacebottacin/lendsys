<?php

    if (isset($_POST["deleteProduct"])) {

        // Se conecta com a base de dados e com as funções
        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        $productId = mysqli_real_escape_string($conn, securityDataValidation($_POST['pid']));

        deleteProduct($conn, $productId);

}