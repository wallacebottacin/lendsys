<?php
    include 'header.php';
    require_once 'includes/functions.inc.php';
    
    if (!isset($_SESSION["userid"])) {
        header("Location: ./login.php");
    }
    ?>

<!-- Continuação do body da página -->

<div class="container-sm" style="text-align: center">
    <br>
    <h2>Meus endereços</h2>
    <br>
    <a href="addaddress.php">
        <button class="btn btn-info">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
            </svg>
            Adicionar endereço</button></a>
    <br>
    <br>
</div>

<?php

if (isset($_SESSION["userid"])) {

    echo "<div class='container-lg'>";

    //Capta mensagem de sucesso após deletar um endereço
    if (isset($_GET["delete"])) {
        if ($_GET["delete"] == "success") {
            echo popSuccess("Endereço deletado com sucesso!");
        }
    }

    //Capta mensagem de sucesso após adicionar um endereço
    if (isset($_GET["add"])) {
        if ($_GET["add"] == "success") {
            echo popSuccess("Endereço adicionado com sucesso!");
        }
    }

    echo "<div>";

    $addressOwner = mysqli_real_escape_string($conn, securityDataValidation($_SESSION["userid"]));

    $sql = "SELECT * FROM address WHERE user_id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ../displayaddress.php.php?error=stmtfailed");
        exit();

    }

    mysqli_stmt_bind_param($stmt, "s", $addressOwner); // Is used to bind variables to the parameter markers of a prepared statement
    mysqli_stmt_execute($stmt); // Accepts a prepared statement object (created using the prepare() function) as a parameter, and executes it

    // Imprime os resultados do banco de dados de endereços
    $resultData = mysqli_stmt_get_result($stmt);
    $resultCheck = mysqli_num_rows($resultData);


    echo "<div class='container'>
            <div class='row'>
                <div class='col'>
                </div>
                <div class='col-11'>";

    if ($resultCheck > 0) {

        echo "<div class='container'>";

        while ($row = mysqli_fetch_assoc($resultData)) {
            $id = $row['id'];
            $name = $row['street'];
            $number = $row['number'];
            $complement = $row['complement'];
            $neighborhood = $row['neighborhood'];
            $city = $row['city'];
            $state = $row['state'];
            $country = $row['country'];
            $postalcode = $row['postalcode'];
            
            echo "<div class='container'>
                <div class='row'>
                    <div class='col-sm-1 text-end'>

                        <svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' fill='currentColor' class='bi bi-geo-alt' viewBox='0 0 16 16'>
                            <path d='M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z'/>
                            <path d='M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'/>
                        </svg>

                    </div>
                    <div class='col-sm-11'>
                    <div class='row'>
                        <div class='col-8 col-sm-7'>
                        ". $name .", " . $number . "<br>
                        ". $complement . " - " . $neighborhood . "<br>
                        ". $postalcode . " - " . $city . ", " . $state . "<br>
                        ". $country . "
                        </div>
                        <div class='col-4 col-sm-5'>
                        
                        <form action='includes/deleteAddress.php' method='POST'>
                            <input type='hidden' name='aid' value='". $id ."'>
                            <button type='submit' name='deleteAddress' class='btn btn-danger'>
                            
                                <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                    <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                                    <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                                </svg>
                    
                    </button><br>
                        </form>
                        
                        </div>
                    </div>
                    </div>
                </div></div><br>";

            }

        echo "</div>";
    }
    else {
        echo "Nenhum endereço cadastrado. <a href='addaddress.php'>Clique aqui</a> para cadastrar seu primeiro endereço.";
    }

    echo "</div>
            <div class='col'>
            </div>
        </div></div>";

    mysqli_stmt_close($stmt);

    }
?>

<!-- Footer da página -->
<?php include 'footer.php' ?>