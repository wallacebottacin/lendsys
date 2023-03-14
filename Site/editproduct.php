<?php
    include 'header.php';
    require_once 'includes/functions.inc.php';
    
    if (!isset($_SESSION["userid"])) {
        header("Location: ./login.php");
    }
    ?>

<!-- Continuação do body da página -->
<section>


<div class="container-sm" style="text-align: center">
    <br>
    <h2>Editar produto</h2>
    <br>
</div>



<?php

    //Verifica se o usuário é um administrador, caso contrário ele a página é bloqueada.
    if ($_SESSION["userrole"] != "1") {
        header("Location: ./index.php?error=notadmin");
    }

    echo "<div class='container-lg'>";

    // Verifica se recebe um método Post e cria o formulário de edição.
    if (isset($_POST["editProductStep1"])) {
        $id = mysqli_real_escape_string($conn, securityDataValidation($_POST['id']));
        $name = mysqli_real_escape_string($conn, securityDataValidation($_POST['name']));
        $description = mysqli_real_escape_string($conn, securityDataValidation($_POST['description']));
        $category = mysqli_real_escape_string($conn, securityDataValidation($_POST['category']));
        $quantity = mysqli_real_escape_string($conn, securityDataValidation($_POST['quantity']));
        $totalborrowed = mysqli_real_escape_string($conn, securityDataValidation($_POST['totalborrowed']));

        echo "<form action='includes/editproduct.inc.php' method='POST'>
                <input type='hidden' name='id' value='". $id ."'>
                <input type='hidden' name='totalborrowed' value='". $totalborrowed ."'>
                <div class='mb-2'>
                    <label for='name' class='form-label'>Nome do produto</label>
                    <input type='text' name='name' class='form-control' id='name' value='". $name ."' required>
                </div>
                <div class='mb-2'>
                    <label for='description' class='form-label'>Descrição</label>
                    <input type='text' name='description' class='form-control' id='description' value='". $description ."' required>
                </div>
                <div class='mb-2'>
                    <label for='category' class='form-label'>Categoria</label>
                    <input type='text' name='category' class='form-control' id='category' value='". $category ."' required>
                </div>
                <div class='mb-2'>
                    <label for='category' class='form-label'>Quantidade</label>
                    <input type='number' class='form-control' id='quantity' name='quantity' value='". $quantity ."' required>
                    <div id='quantity' class='form-text'>Atenção: quantidade total não pode ser menor que ". $totalborrowed ." unidades, pois essas unidades já estão emprestadas.</div>
                </div>
                <button type='submit' name='editProductStep2' class='btn btn-info'>Editar produto</button>
            </form>";

    } 
    
    // Caso contrário, exibe uma mensagem pedindo para selecionar o produto na área "Mostrar Produtos"
    else {
        echo "Selecione primeiro o produto na <a href='displayproducts.php'>lista de produtos</a> e clique em editar.";
    }

    echo "</div>";

?>
</section>
<!-- Footer da página -->
<?php include 'footer.php' ?>