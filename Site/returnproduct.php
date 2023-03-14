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
        <h2>Realizar devolução</h2>
        <br>
</div>


<?php

    //Verifica se o usuário é um administrador, caso contrário ele a página é bloqueada.
    if ($_SESSION["userrole"] != "1") {
        header("Location: ./index.php?error=notadmin");
    }


    echo "<div class='container-lg'>";


    // Verifica se recebe um método Post e cria o formulário de edição.
    if (isset($_POST["returnproduct"])) {
        $id = mysqli_real_escape_string($conn, securityDataValidation($_POST['id']));
        $name = mysqli_real_escape_string($conn, securityDataValidation($_POST['name']));
        $description = mysqli_real_escape_string($conn, securityDataValidation($_POST['description']));
        $category = mysqli_real_escape_string($conn, securityDataValidation($_POST['category']));
        $quantity = mysqli_real_escape_string($conn, securityDataValidation($_POST['quantity']));
        $totalborrowed = mysqli_real_escape_string($conn, securityDataValidation($_POST['totalborrowed']));
        $availability = $quantity - $totalborrowed;


        echo "<div class='container-lg'>";

        echo "<div class='container'>
                <div class='row'>
                    <div class='col-2'></div>
                    <div class='col-1'>

                    <svg xmlns='http://www.w3.org/2000/svg' width='40' height='40' fill='currentColor' class='bi bi-layers' viewBox='0 0 16 16'>
                        <path d='M8.235 1.559a.5.5 0 0 0-.47 0l-7.5 4a.5.5 0 0 0 0 .882L3.188 8 .264 9.559a.5.5 0 0 0 0 .882l7.5 4a.5.5 0 0 0 .47 0l7.5-4a.5.5 0 0 0 0-.882L12.813 8l2.922-1.559a.5.5 0 0 0 0-.882l-7.5-4zm3.515 7.008L14.438 10 8 13.433 1.562 10 4.25 8.567l3.515 1.874a.5.5 0 0 0 .47 0l3.515-1.874zM8 9.433 1.562 6 8 2.567 14.438 6 8 9.433z'/>
                    </svg>
                    
                    </div>
                    <div class='col-6'>";

        echo "<b>Produto: </b>". $name . "<br>";
        echo "<b>Descrição: </b>". $description . "<br>";
        echo "<b>Categoria: </b>". $category . "<br>";
        echo "<b>Quantidade total: </b>". $quantity . "<br>";
        echo "<b>Emprestados: </b>". $totalborrowed . "<br>";
        echo "<b>Disponíveis: </b>" . $availability ."<br>";

        echo "</div>
                    <div class='col-3'></div>
                </div>
            </div><br><br>";

        echo "<div class='container-sm'>";
        echo "<form action='includes/returnproduct.inc.php' method='POST'>
                <input type='hidden' name='id' value='". $id ."'>
                <input type='hidden' name='name' value='". $name ."'>
                <input type='hidden' name='description' value='". $description ."'>
                <input type='hidden' name='category' value='". $category ."'>
                <input type='hidden' name='quantity' value='". $quantity ."'>
                <input type='hidden' name='totalborrowed' value='". $totalborrowed ."'>
                <div class='mb-2'>
                    <label for='returnedQuantity' class='form-label'>Quantidade a ser devolvida</label>
                    <input type='number' name='returnedQuantity' class='form-control' id='returnedQuantity' required>
                </div>
                <div class='mb-2'>
                    <label for='emailuser' class='form-label'>E-mail do usuário</label>
                    <input type='email' name='emailuser' class='form-control' id='emailuser' required>
                </div>
                <button type='submit' name='returnproduct' class='btn btn-success'>
                
                <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-arrow-down-square' viewBox='0 0 16 16'>
                <path fill-rule='evenodd' d='M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 2.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z'/>
                </svg>
                
                Finalizar devolução</button>
            </form>";

    echo "</div></div>";


    // Mostra os usuários com empréstimos ativos do item
    $sql = "SELECT * FROM user_has_item 
    INNER JOIN item ON user_has_item.item_id = item.id
    INNER JOIN user ON user_has_item.user_id = user.id
    WHERE item.id = ?
    ORDER BY user_has_item.lendupto ASC;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {

    header("Location: ./index.php?error=stmtfailed");
    exit();

    }

    mysqli_stmt_bind_param($stmt, "s", $id); // Is used to bind variables to the parameter markers of a prepared statement
    mysqli_stmt_execute($stmt); // Accepts a prepared statement object (created using the prepare() function) as a parameter, and executes it
    $resultData = mysqli_stmt_get_result($stmt);


    // Imprime os resultados do banco de dados de produtos
    $resultCheck = mysqli_num_rows($resultData);

    $grabDate = date('Y-m-d H:i:s');

    if ($resultCheck > 0) {

    echo "<br><br><br><div class='container-lg table-responsive'>";
    echo "<table class='table table-hover'>
        <thead>
            <tr>
                <th scope='col' style='text-align: center'>E-mail</th>
                <th scope='col' style='text-align: center'>Quantidade</th>
                <th scope='col' style='text-align: center'>Devolver até</th>
            </tr>
        </thead>
    <tbody>";

    while ($row = mysqli_fetch_assoc($resultData)) {
    $quantityborrowed = $row['quantityborrowed'];
    $lendupto = $row['lendupto'];
    $email = $row['email'];

    $format = "Y-m-d H:i:s";
    $date1  = \DateTime::createFromFormat($format, $grabDate);
    $date2  = \DateTime::createFromFormat($format, $lendupto);

    if ($date1 > $date2) {
        $alertClass = "class='table-danger'";
    } else {
        $alertClass = "";
    }

    // Formata a data para mostrar ao usuário
    $formattedDate = date("d/m/Y - H:i:s", strtotime($lendupto));

    echo "<tr ". $alertClass .">
            <th scope='row'>" . $email . "</th>
            <td style='text-align: center'>" . $quantityborrowed . "</td>
            <td style='text-align: center'>" . $formattedDate . "</td>
        </tr>";

    }
    echo "
    </tbody>
    </table></div>"; // Fecha a linha da tabela

    echo "</div>";

    } else {
    echo "<br><br><br><div class='container-lg text-center'>Nenhum empréstimo ativo para esse produto.</div>";
    }


    } 
    
    // Caso contrário, exibe uma mensagem pedindo para selecionar o produto na área "Mostrar Produtos"
    else {
        echo "Selecione primeiro o produto na <a href='displayproducts.php'>lista de produtos</a> e clique em emprestar.";
    }



?>
</section>
<!-- Footer da página -->
<?php include 'footer.php' ?>