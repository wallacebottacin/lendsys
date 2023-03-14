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
        <h2>Meus empréstimos</h2>
        <p>Itens destacados em vermelho estão em atraso.</p>
        <br>
</div>

<?php

    echo "<div class='container-lg'>";
    echo "<div class='container-lg'>";

    //Capta erro do usuário tentar editar um produto de edição restrita ao admin
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "notadmin") {
            echo popError("Você precisa ser administrador para editar produtos.");
        }
    }

    echo "</div>";

    $user_id = $_SESSION["userid"];

    // Prepara a consulta na Base de Dados
    $sql = "SELECT * FROM user_has_item
            INNER JOIN item ON user_has_item.item_id = item.id
            WHERE user_has_item.user_id = ?
            ORDER BY user_has_item.lendupto ASC;";
            
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

    $grabDate = date('Y-m-d H:i:s');

    if ($resultCheck > 0) {

        echo "<div class='container-lg table-responsive'>";
            echo "<table class='table table-hover'>
                    <thead>
                        <tr>
                            <th scope='col' style='text-align: center'>Produto</th>
                            <th scope='col' style='text-align: center'>Quantidade</th>
                            <th scope='col' style='text-align: center'>Devolver até</th>
                        </tr>
                    </thead>
                <tbody>";

        while ($row = mysqli_fetch_assoc($resultData)) {
            $user_id = $row['user_id'];
            $item_id = $row['item_id'];
            $lenddate = $row['lenddate'];
            $returndate = $row['returndate'];
            $quantityborrowed = $row['quantityborrowed'];
            $lendupto = $row['lendupto'];
            $item_name = $row['name'];

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
                    <th scope='row'>" . $item_name . "</th>
                    <td style='text-align: center'>" . $quantityborrowed . "</td>
                    <td style='text-align: center'>" . $formattedDate . "</td>
                </tr>";

        }

        echo "
        </tbody>
        </table></div>"; // Fecha a linha da tabela

    } else {
        echo "<div><p class='text-center'>Você não tem nenhum empréstimo ativo.</p></div>";
    }

    echo "</div>";

?>

<!-- Footer da página -->
<?php include 'footer.php' ?>