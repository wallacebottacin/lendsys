<?php
    include 'header.php';
    include 'includes/functions.inc.php'; ?>

<!-- Continuação do body da página -->

<div class="container-sm" style="text-align: center">
    <br>
    <h2>LendSys</h2>
    <p>Sistema para empréstimo de produtos</p>
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
        if ($_GET["error"] == "stmtfailed") {
            echo popError("Problema de conexão com a base de dados.");
        }
    }

    echo "</div>";

    echo "<div class='container-lg'>";

    if ($_SESSION["userrole"] == "1") {

        echo "<div class='container-lg' style='text-align: center'><p>Olá, ". $_SESSION["username"] . "! &#128075</p></div>";   

        echo "<div class='d-flex justify-content-center'>";

        echo "<a href='displayproducts.php'><img src='img/1.png' class='rounded float-start m-2' width='150' height='150'></a>";
        echo "<a href='addproduct.php'><img src='img/6.png' class='rounded float-start m-2' width='150' height='150'></a>";
        echo "<a href='displayproducts.php?edit=startlending'><img src='img/5.png' class='rounded float-start m-2' width='150' height='150'></a>";

        echo "</div>";

        echo "<div class='d-flex justify-content-center'>";
        
        echo "<a href='profile.php'><img src='img/2.png' class='rounded float-start m-2' width='150' height='150'></a>";
        echo "<a href='displayaddress.php'><img src='img/3.png' class='rounded float-start m-2' width='150' height='150'></a>";
        echo "<a href='includes/logout.inc.php'><img src='img/4.png' class='rounded float-start m-2' width='150' height='150'></a>";

        echo "</div>";


        echo "</div></div>";

    }
    
    else if ($_SESSION["userrole"] == "2") {

        echo "<div class='container-lg' style='text-align: center'><p>Olá, ". $_SESSION["username"] . "! &#128075</p></div>";   

        echo "<div class='d-flex justify-content-center'>";

        echo "<a href='displayproducts.php'><img src='img/1.png' class='rounded float-start m-2' width='150' height='150'></a>";
        echo "<a href='myborrows.php?edit=startlending'><img src='img/9.png' class='rounded float-start m-2' width='150' height='150'></a>";

        echo "</div>";

        echo "<div class='d-flex justify-content-center'>";
        
        echo "<a href='profile.php'><img src='img/2.png' class='rounded float-start m-2' width='150' height='150'></a>";
        echo "<a href='displayaddress.php'><img src='img/3.png' class='rounded float-start m-2' width='150' height='150'></a>";
        echo "<a href='includes/logout.inc.php'><img src='img/4.png' class='rounded float-start m-2' width='150' height='150'></a>";

        echo "</div>";


        echo "</div></div>";

    } else {

        
        echo "<div class='container-lg'>";

        echo "<div class='d-flex justify-content-center'>";

        echo "<a href='login.php'><img src='img/7.png' class='rounded float-start m-2' width='150' height='150'></a>";
        echo "<a href='signup.php'><img src='img/8.png' class='rounded float-start m-2' width='150' height='150'></a>";
            
        echo "</div>";


        echo "</div>";


    }

?>

<!-- Footer da página -->
<?php include 'footer.php' ?>