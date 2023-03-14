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
        <h2>Editar perfil e senha</h2>
        <br>
</div>

<?php

    echo "<div class='container-lg'>";

    // Captação dos erros
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo popError("Todos os campos são obrigatórios!");
        }
        else if ($_GET["error"] == "invalidemail") {
            echo popError("Digite um e-mail válido!");
        }
        else if ($_GET["error"] == "shortpassword") {
            echo popError("A senha deve conter no mínimo 8 caracteres!");
        }
        else if ($_GET["error"] == "longpassword") {
            echo popError("A senha deve conter no menos de 60 caracteres!");
        }
        else if ($_GET["error"] == "longname") {
            echo popError("O nome deve ter menos de 50 caracteres!");
        }
        else if ($_GET["error"] == "longsurname") {
            echo popError("O sobrenome deve ter menos de 50 caracteres!");
        }
        else if ($_GET["error"] == "longemail") {
            echo popError("O e-mail não deve ter mais de 254 caracteres!");
        }
        else if ($_GET["error"] == "longphone") {
            echo popError("O telefone não deve ter mais de 15 números!");
        }
        else if ($_GET["error"] == "wrongpassword") {
            echo popError("As senhas não são iguais!");
        }
        else if ($_GET["error"] == "userexists") {
            echo popError("Esse usuário já existe. <a href='login.php'>Clique aqui</a> para fazer o login!");
        }
        else if ($_GET["error"] == "phonenotnumber") {
            echo popError("O telefone deve conter apenas números!");
        }
        else if ($_GET["error"] == "stmtfailed") {
            echo popError("Problema de conexão com a base de dados (STMT failed).");
        }
    }

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

    echo "<div class='container-sm'>";

    if ($resultCheck > 0) {

        while ($row = mysqli_fetch_assoc($resultData)) {
            $user_and_address_id = $row['id'];
            $email = $row['email'];
            $password = $row['password'];
            $name = $row['name'];
            $surname = $row['surname'];
            $phone = $row['phone'];


                echo "<form action='includes/editprofile.inc.php' method='POST'>
                        <input type='hidden' name='id' value='". $user_id ."'>
                        <div class='mb-2'>
                            <label for='name' class='form-label'>Nome</label>
                            <input type='text' name='name' class='form-control' id='name' value='". $name ."' required>
                        </div>
                        <div class='mb-2'>
                            <label for='surname' class='form-label'>Sobrenome</label>
                            <input type='text' name='surname' class='form-control' id='surname' value='". $surname ."' required>
                        </div>
                        <div class='mb-2'>
                            <label for='email' class='form-label'>E-mail</label>
                            <input type='email' name='email' class='form-control' id='email' value='". $email ."' required>
                        </div>
                        <div class='mb-2'>
                            <label for='phone' class='form-label'>Telefone</label>
                            <input type='number' name='phone' class='form-control' id='phone' value='". $phone ."' required>
                        </div>
                        <div class='mb-2'>
                            <label for='password' class='form-label'>Senha</label>
                            <input type='password' name='password' class='form-control' id='password' required>
                        </div>
                        <div class='mb-2'>
                            <label for='passwordRepeat' class='form-label'>Repita a senha</label>
                            <input type='password' name='passwordRepeat' class='form-control' id='passwordRepeat' required>
                        </div>
                        <button type='submit' name='editinfoprofile' class='btn btn-info'>Atualizar</button>
                    </form>
                    </div>";
            
        }



    }

    echo "</div>";
?>

<!-- Footer da página -->
<?php include 'footer.php' ?>