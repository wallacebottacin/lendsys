<?php
    include 'header.php'; 
    include 'includes/functions.inc.php'; ?>

<!-- Continuação do body da página -->

<?php

if (!isset($_SESSION["userid"])) {
    header("Location: ./login.php");
}

$grabUserId = $_SESSION["userid"];

?>
<section>

<div class="container-sm" style="text-align: center">
        <br>
        <h2>Adicionar endereço</h2>
        <br>
</div>

<?php
        echo "<div class='container-lg'>";

        // Captação dos erros
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyinput") {
                echo popError("Os campos rua, cidade e código postal são obrigatórios!");
            }
            else if ($_GET["error"] == "longstreet") {
                echo popError("O nome da rua deve ter no máximo 100 caracteres.");
            }
            else if ($_GET["error"] == "longnumber") {
                echo popError("O número não deve ter mais que 45 caracteres.");
            }
            else if ($_GET["error"] == "longcomplement") {
                echo popError("O complemento não deve ter mais que 45 caracteres.");
            }
            else if ($_GET["error"] == "longcity") {
                echo popError("A cidade não deve ter mais que 45 caracteres");
            }
            else if ($_GET["error"] == "longstate") {
                echo popError("O estado não deve ter mais que 20 caracteres.");
            }
            else if ($_GET["error"] == "longcountry") {
                echo popError("O país não deve ter mais que 45 caracteres.");
            }
            else if ($_GET["error"] == "longcep") {
                echo popError("O CEP não deve ter mais que 45 caracteres.");
            }
            else if ($_GET["error"] == "cepnotnumber") {
                echo popError("O CEP deve conter apenas números.");
            }
            else if ($_GET["error"] == "stmtfailed") {
                echo popError("Problema de conexão com a base de dados (STMT failed).");
            }
        }

        if (isset($_GET["ok"])) {
            if ($_GET["ok"] == "success") {
                echo popSuccess("Cadastro realizado com sucesso!");
            }
        }

        echo "</div>";

    ?>

    <div class="container-sm">
        <form action="includes/addaddress.inc.php" method="POST">
            <div class="mb-2">
                <label for="street" class="form-label">Rua</label>
                <input type="text" name="street" class="form-control" id="street" required>
            </div>
            <div class="mb-2">
                <label for="number" class="form-label">Número</label>
                <input type="text" name="number" class="form-control" id="number">
            </div>
            <div class="mb-2">
                <label for="complement" class="form-label">Complemento</label>
                <input type="text" name="complement" class="form-control" id="complement">
            </div>
            <div class="mb-2">
                <label for="neighborhood" class="form-label">Bairro</label>
                <input type="text" name="neighborhood" class="form-control" id="neighborhood">
            </div>
            <div class="mb-2">
                <label for="city" class="form-label">Cidade</label>
                <input type="text" name="city" class="form-control" id="city" required>
            </div>
            <div class="mb-2">
                <label for="state" class="form-label">Estado</label>
                <input type="text" name="state" class="form-control" id="state">
            </div>
            <div class="mb-2">
                <label for="country" class="form-label">País</label>
                <input type="text" name="country" class="form-control" id="country">
            </div>
            <div class="mb-2">
                <label for="CEP" class="form-label">CEP</label>
                <input type="number" name="CEP" class="form-control" id="CEP" required>
            </div>
            <input type="hidden" name="user_id" value="<?php echo $grabUserId; ?>">
            <button type="submit" name="submit" class="btn btn-info">Adicionar endereço</button>
        </form>
    </div>

</section>

<!-- Footer da página -->
<?php include 'footer.php' ?>