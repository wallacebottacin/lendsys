<?php
    include 'header.php'; ?>

<!-- Continuação do body da página -->
<section>
<div class="container-fluid">

<br>
<br>

<div class="container-sm" style="text-align: center">
    <h2>Login</h2>
</div>


<div class="container-sm">
<form action="includes/login.inc.php" method="POST">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">E-mail</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="E-mail">
    <div id="emailHelp" class="form-text">Nós não compartilhamos o seu e-mail com ninguém.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Senha</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Senha">
  </div>
  <button type="submit" class="btn btn-primary" name="submit">Entrar</button>
</form>
</div>

<?php

    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo "<p style='color:red;'><b>Todos os campos são obrigatórios!</b></p>";
        }
        else if ($_GET["error"] == "wronglogin") {
            echo "<p style='color:red;'><b>Dados incorretos. Tente novamente!</b></p>";
        }
    }

?>

</div>
</section>

<!-- Footer da página -->
<?php include 'footer.php' ?>