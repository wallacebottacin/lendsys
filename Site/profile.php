<?php
    include 'code.php';
    
    

    if (!isset($_SESSION["userid"])) {
        header("Location: ./login.php");
    }
    
    include 'header.php'; 
    require_once 'includes/functions.inc.php';

    ?>

<!-- Continuação do body da página -->

<div class="container-sm" style="text-align: center">
        <br>
        <h2>Perfil</h2>
        <br>
</div>


<?php

    echo "<div class='container-lg'>";

    // Captação dos erros
    if (isset($_GET["edituser"])) {
        if ($_GET["edituser"] == "success") {
            echo popSuccess("Cadastro atualizado com sucesso!");
        }
    }

    echo "</div>";


    $user_id = $_SESSION["userid"];

    // Prepara a consulta na Base de Dados
    $sql = "SELECT * FROM user WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ./index.php?error=stmtfailed");
        exit();

    }

    mysqli_stmt_bind_param($stmt, "s", $user_id); // Is used to bind variables to the parameter markers of a prepared statement
    mysqli_stmt_execute($stmt); // Accepts a prepared statement object (created using the prepare() function) as a parameter, and executes it
    $resultData = mysqli_stmt_get_result($stmt);

        
    // Imprime os resultados do banco de dados de produtos
    $resultCheck = mysqli_num_rows($resultData);

    echo "<div class='container-lg'>";

    if ($resultCheck > 0) {

        while ($row = mysqli_fetch_assoc($resultData)) {
            $user_and_address_id = $row['id'];
            $email = $row['email'];
            $password = $row['password'];
            $name = $row['name'];
            $surname = $row['surname'];
            $phone = $row['phone'];

            echo "<div class='container-lg'>";

            echo "<div class='container'>
                    <div class='row'>
                        <div class='col-2'></div>
                        <div class='col-1'>
    
                        <svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' fill='currentColor' class='bi bi-person-badge' viewBox='0 0 16 16'>
                            <path d='M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0z'/>
                            <path d='M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0h-7zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492V2.5z'/>
                        </svg>
                        
                        </div>
                        <div class='col-8'>";
    
            echo "<b>Nome: </b>". $name . " " . $surname . "<br>";
            echo "<b>E-mail: </b>". $email . "<br>";
            echo "<b>Telefone: </b>". $phone . "<br>";
            echo "<b>ID: </b>". $user_and_address_id . "<br>";
    
            echo "</div>
                        <div class='col-2'></div>
                    </div>
                </div><br><br>";
    
            echo "</div>";


            echo "<div class='container-lg d-flex justify-content-center'>";

            echo "<a href='editprofile.php'><button class='btn btn-info m-2'>Editar informações</button></a>";
            echo "<a href='editprofile.php'><button class='btn btn-info m-2'>Mudar senha</button></a>";
            echo "<a href='displayaddress.php'><button class='btn btn-info m-2'>Endereços</button></a>";

            echo "</div>";
        }

    }



?>

<!-- Footer da página -->
<?php include 'footer.php' ?>