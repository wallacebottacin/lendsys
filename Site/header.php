<?php include 'code.php'; ?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pageName; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow p-3 mb-3 rounded sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><img src="img/LendSys_logo.png" alt="LendSys by Wallace Bottacin"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

    <?php

    // Verifica se existe uma sessão
    if (isset($_SESSION["userid"])) {

        // Se for um admin, aparecerá esse menu
        if ($_SESSION["userrole"] == "1") {
            
            echo "<li class='nav-item'>
                     <a class='nav-link active' aria-current='page' href='index.php'>Início</a>
                 </li>";
            
            
            echo "<li class='nav-item'>
                    <a class='nav-link active' aria-current='page' href='profile.php'>Perfil</a>
                  </li>";

            echo "<li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink2' role='button' data-bs-toggle='dropdown' aria-expanded='false'>Endereços</a>
                        <ul class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink2'>
                            <li><a class='dropdown-item' href='displayaddress.php'>Meus edereços</a></li>
                            <li><a class='dropdown-item' href='addaddress.php'>Adicionar endereço</a></li>
                        </ul>
                    </li>";


            echo "<li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink1' role='button' data-bs-toggle='dropdown' aria-expanded='false'>Produtos</a>
                        <ul class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink1'>
                            <li><a class='dropdown-item' href='displayproducts.php'>Lista de produtos</a></li>
                            <li><a class='dropdown-item' href='addproduct.php'>Cadastrar produto</a></li>
                            <li><a class='dropdown-item' href='displayproducts.php?edit=startlending'>Novo empréstimo</a></li>
                            <li><a class='dropdown-item' href='displayproducts.php?edit=startreturning'>Nova devolução</a></li>
                        </ul>
                    </li>";
            

            echo "<li class='nav-item'>
                   <a class='nav-link active' aria-current='page' href='includes/logout.inc.php'>Sair</a>
                  </li>"; 

        }
        
        // Se for um usuário normal, aparecerá esse menu
        else if ($_SESSION["userrole"] == "2") {

            echo "<li class='nav-item'>
                     <a class='nav-link active' aria-current='page' href='index.php'>Início</a>
                 </li>";
            
            
            echo "<li class='nav-item'>
                    <a class='nav-link active' aria-current='page' href='profile.php'>Perfil</a>
                  </li>";

            echo "<li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink' role='button' data-bs-toggle='dropdown' aria-expanded='false'>Endereços</a>
                        <ul class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'>
                            <li><a class='dropdown-item' href='displayaddress.php'>Meus edereços</a></li>
                            <li><a class='dropdown-item' href='addaddress.php'>Adicionar endereço</a></li>
                        </ul>
                    </li>";

            echo "<li class='nav-item'>
                  <a class='nav-link active' aria-current='page' href='displayproducts.php'>Produtos disponíveis</a>
                </li>";


            echo "<li class='nav-item'>
                  <a class='nav-link active' aria-current='page' href='myborrows.php'>Meus emprestimos</a>
                 </li>";


            echo "<li class='nav-item'>
                   <a class='nav-link active' aria-current='page' href='includes/logout.inc.php'>Sair</a>
                  </li>"; 

        }

        else {
            echo "Função do usuário ainda não cadastrada no sistema.";
        }

    }

    // Se não existir uma sessão (o usuário não estiver logado), aparecerá esse menu
    else {

        echo "<li class='nav-item'>
                <a class='nav-link active' aria-current='page' href='signup.php'>Cadastro</a>
                </li>";


        echo "<li class='nav-item'>
                <a class='nav-link active' aria-current='page' href='login.php'>Login</a>
                </li>"; 

    }

    ?>

      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">