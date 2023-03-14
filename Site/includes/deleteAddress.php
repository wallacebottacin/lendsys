<?php

if (isset($_POST["deleteAddress"])) {

    // Se conecta com a base de dados e com as funções
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $addressId = mysqli_real_escape_string($conn, securityDataValidation($_POST['aid']));

    deleteAddress($conn, $addressId);

}