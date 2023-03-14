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
    <h2>Produtos</h2>
    <br>
    <a href="addproduct.php">
        <button class="btn btn-info">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>
            Adicionar produto</button></a>
    <br>
    <br>
</div>


<?php

    echo "<div class='container-lg'>";

    //Capta mensagem de sucesso após deletar um item
    if (isset($_GET["delete"])) {
        if ($_GET["delete"] == "success") {
            echo popSuccess("Item deletado com sucesso!");
        }
    }

    //Capta mensagem de sucesso após editar um item
    if (isset($_GET["edit"])) {
        if ($_GET["edit"] == "success") {
            echo popSuccess("Item editado com sucesso!");
        }
        if ($_GET["edit"] == "lendsuccess") {
            echo popSuccess("Item emprestado com sucesso!");
        }
        if ($_GET["edit"] == "returnsuccess") {
            echo popSuccess("Item devolvido com sucesso!");
        }
        if ($_GET["edit"] == "startlending") {
            echo popInfo("Identifique o produto que você irá emprestar na lista abaixo e clique no botão emprestar:");
        }
        if ($_GET["edit"] == "startreturning") {
            echo popInfo("Identifique o produto que será devolvido na lista abaixo e clique no botão devolver:");
        }
    }

    
    //Capta mensagem de erro após tentar editar um item
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "stmtfailed") {
            echo popError("Problema de conexão com a base de dados.");
        }
        else if ($_GET["error"] == "emptyfield") {
            echo popError("Todos os campos são obrigatórios. Reinicie a operação.");
        }
        else if ($_GET["error"] == "hithere") {
            echo popError("Hi there!");
        }
        else if ($_GET["error"] == "notavailable") {
            echo popError("A quantidade selecionada é maior do que a quantidade disponível. Tente novamente.");
        }
        else if ($_GET["error"] == "invalidemail") {
            echo popError("E-mail do usuário está inválido.");
        }
        else if ($_GET["error"] == "usernotfound") {
            echo popError("Usuário não encontrado. Certifique-se que ele está cadastrado.");
        }
        else if ($_GET["error"] == "deleteforbbiden") {
            echo popError("O produto não pode ser deletado, pois existem empréstimos ativos.");
        }
        else if ($_GET["error"] == "availabilityerror") {
            echo popError("Não é possível alterar a quantidade do produto para um valor abaixo da quantidade atualmente emprestada.");
        }
        else if ($_GET["error"] == "overreturn") {
            echo popError("Você está tentando devolver uma quantidade maior de itens do que o indivíduo pegou emprestado. Reinicie a operação.");
        }
        else if ($_GET["error"] == "zeronotvalid") {
            echo popError("Não é possível devolver uma quantidade menor do que zero. Reinicie a operação.");
        }
    }

    echo "</div>";

    $sql = "SELECT * FROM item;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ../displayproducts.php?error=stmtfailed");
        exit();

    }


    // Imprime os resultados do banco de dados de produtos
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    $resultCheck = mysqli_num_rows($resultData);

    if ($resultCheck > 0) {

        echo "<div class='container-lg table-responsive'>";
        echo " <table class='table table-hover'>
        <thead>
        <tr>
            <th scope='col' style='text-align: center'>Produto</th>
            <th scope='col' style='text-align: center'>Descrição</th>
            <th scope='col' style='text-align: center'>Categoria</th>
            <th scope='col' style='text-align: center'>Estoque</th>
            <th scope='col' style='text-align: center'>Emprestado</th>
            <th scope='col' style='text-align: center'>Disponível</th>";

        // Se for admin vai imprimir mais 4 colunas
        if ($_SESSION["userrole"] == "1") {

            echo "
            <th scope='col' style='text-align: center'>Deletar</th>
            <th scope='col' style='text-align: center'>Editar</th>
            <th scope='col' style='text-align: center'>Emprestar</th>
            <th scope='col' style='text-align: center'>Devolver</th>
            ";
        
        }

        echo "</tr>
            </thead>
            <tbody>";



        while ($row = mysqli_fetch_assoc($resultData)) {
            $id = $row['id'];
            $name = $row['name'];
            $description = $row['description'];
            $category = $row['category'];
            $quantity = $row['quantity'];
            $totalborrowed = $row['totalborrowed'];

            $disponibility = $quantity - $totalborrowed;

            echo "<tr>
                    <th scope='row'>" . $name . "</th>
                    <td>" . $description . "</td>
                    <td>" . $category . "</td>
                    <td style='text-align: center'>" . $quantity . "</td>
                    <td style='text-align: center'>" . $totalborrowed . "</td>
                    <td style='text-align: center'>" . $disponibility . "</td>
                    ";


            // Se for um admin, poderá realizar o CRUD de produtos
            if ($_SESSION["userrole"] == "1") {
                // Admin pode deletar o produto
                echo "<td><form action='includes/deleteProduct.inc.php' method='POST' style='text-align: center'>
                        <input type='hidden' name='pid' value='". $id ."'>
                        <button type='submit' name='deleteProduct' class='btn btn-danger'>
                        
                        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                                <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                        </svg>
                      
                      </button>
                      
                      <br>
                    </form></td>";


                // Admin pode editar o produto
                echo "<td><form action='editproduct.php' method='POST' style='text-align: center'>
                        <input type='hidden' name='id' value='". $id ."'>
                        <input type='hidden' name='name' value='". $name ."'>
                        <input type='hidden' name='description' value='". $description ."'>
                        <input type='hidden' name='category' value='". $category ."'>
                        <input type='hidden' name='quantity' value='". $quantity ."'>
                        <input type='hidden' name='totalborrowed' value='". $totalborrowed ."'>
                        <button type='submit' name='editProductStep1' class='btn btn-warning'>
                        
                        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                        <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                        </svg>
                        
                        </button><br>
                    </form></td>";

                // Admin pode emprestar o produto
                echo "<td><form action='lending.php' method='POST' style='text-align: center'>
                    <input type='hidden' name='id' value='". $id ."'>
                    <input type='hidden' name='name' value='". $name ."'>
                    <input type='hidden' name='description' value='". $description ."'>
                    <input type='hidden' name='category' value='". $category ."'>
                    <input type='hidden' name='quantity' value='". $quantity ."'>
                    <input type='hidden' name='totalborrowed' value='". $totalborrowed ."'>
                    <button type='submit' name='itemforlending' class='btn btn-info'>
                    
                    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-arrow-up-square' viewBox='0 0 16 16'>
                    <path fill-rule='evenodd' d='M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 9.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z'/>
                    </svg>
                    
                    </button><br>
                    </form></td>";

                // Admin pode devolver o produto
                echo "<td><form action='returnproduct.php' method='POST' style='text-align: center'>
                    <input type='hidden' name='id' value='". $id ."'>
                    <input type='hidden' name='name' value='". $name ."'>
                    <input type='hidden' name='description' value='". $description ."'>
                    <input type='hidden' name='category' value='". $category ."'>
                    <input type='hidden' name='quantity' value='". $quantity ."'>
                    <input type='hidden' name='totalborrowed' value='". $totalborrowed ."'>
                    <button type='submit' name='returnproduct' class='btn btn-success'>

                    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-arrow-down-square' viewBox='0 0 16 16'>
                    <path fill-rule='evenodd' d='M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 2.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z'/>
                    </svg>
                    
                    </button><br>
                    </form></td>";

            }

       
        }

        echo "</tr>
        </tbody>
        </table></div>"; // Fecha a linha da tabela

        mysqli_stmt_close($stmt);
        
    } else {
        echo "<div class='container-lg'><p class='text-center'>Nenhum produto cadastrado.</p></div>";
    }

?>
<!-- Footer da página -->
<?php include 'footer.php' ?>