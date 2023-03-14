<?php
    include 'header.php';
    include 'includes/functions.inc.php'; 
    
    if (isset($_SESSION["userid"])) {
        header("Location: ./login.php");
    }
    
    ?>

<!-- Continuação do body da página -->

<section>


    <div class="container-sm" style="text-align: center">
        <br>
        <h2>Cadastro de usuário</h2>
        <br>
    </div>

    <?php
    
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

    if (isset($_GET["signup"])) {
        if ($_GET["signup"] == "success") {
            echo popSuccess("Cadastro realizado com sucesso!");
        }
    }

?>

    <div class="container-lg">

    <form action="includes/signup.inc.php" method="POST">
        <div class='mb-2'>
            <label for="name" class="form-label">Primeiro nome</label>
            <input type="text" name="name" class="form-control" id="name" required>
        </div>
        <div class='mb-2'>
            <label for="surname" class="form-label">Sobrenome</label>
            <input type="text" name="surname" class="form-control" id="surname" required>
        </div>
        <div class='mb-2'>
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>
        <div class='mb-2'>
            <label for="phone" class="form-label">Telefone</label>
            <input type="number" name="phone" class="form-control" id="phone" required>
        </div>
        <div class='mb-2'>
            <label for="password" class="form-label">Senha</label>
            <input type="password" name="password" class="form-control" id="password" required>
        </div>
        <div class='mb-2'>
            <label for="passwordRepeat" class="form-label">Repita a senha</label>
            <input type="password" name="passwordRepeat" class="form-control" id="passwordRepeat" required>
        </div>
        <button type="submit" name="submit" class="btn btn-info">Cadastrar</button>
    </form>
</div>


</section>

<!-- Footer da página -->
<?php include 'footer.php' ?>