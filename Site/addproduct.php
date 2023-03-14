<?php
    include 'header.php';
    include 'includes/functions.inc.php' ?>

<!-- Continuação do body da página -->

<section>

    <div class="container-sm" style="text-align: center">
        <br>
        <h2>Adicionar produto</h2>
        <br>
    </div>

<?php

if (!isset($_SESSION["userid"])) {
    header("Location: ./login.php");
}

if ($_SESSION["userrole"] != "1") {
    header("Location: ./index.php?error=notadmin");
}

echo "<div class='container-lg'>";

// Captação dos erros
if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyinput") {
        echo popError("Todos os campos são obrigatórios!");
    }
    else if ($_GET["error"] == "zerostock") {
        echo popError("É necessário pelo menos 1 unidade!");
    }
    else if ($_GET["error"] == "longname") {
        echo popError("O nome do produto deve ter menos de 45 caracteres");
    }
    else if ($_GET["error"] == "longdescription") {
        echo popError("A descrição do produto deve ter menos de 60 caracteres");
    }
    else if ($_GET["error"] == "longcategory") {
        echo popError("A categoria do produto deve ter menos de 45 caracteres");
    }
    else if ($_GET["error"] == "quantitynotnumber") {
        echo popError("A quantidade deve conter apenas números");
    }
    else if ($_GET["error"] == "stmtfailed") {
        echo popError("Problema de conexão com a base de dados (STMT failed)");
    }
}

if (isset($_GET["addproduct"])) {
    if ($_GET["addproduct"] == "success") {
        echo popSuccess("Cadastro realizado com sucesso!");
    }
}

echo "</div>";


?>

    <div class="container-sm">
        <form action="includes/addproduct.inc.php" method="POST">
            <div class="mb-3">
                <label for="nameHelp" class="form-label">Nome do produto</label>
                <input type="text" name="name" class="form-control" id="nameHelp">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descrição do produto</label>
                <input type="text" name="description" class="form-control" id="description">
                <div id="description" class="form-text">Utilize no máximo 60 caracteres.</div>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Categoria</label>
                <input type="text" name="category" class="form-control" id="category">
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantidade para o estoque</label>
                <input type="number" name="quantity" class="form-control" id="quantity">
            </div>
            <button type="submit" name="submit" class="btn btn-info">Cadastrar produto</button>
        </form>
    </div>

</section>

<!-- Footer da página -->
<?php include 'footer.php' ?>