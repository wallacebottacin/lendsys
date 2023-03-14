<?php

require_once 'dbh.inc.php';

// Função que faz a checagem de segurança dos dados do form
function securityDataValidation ($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = filter_var($data, FILTER_SANITIZE_STRING);
    return $data;
}

// Função que verifica se não tem campos vazios no form
function emptyInputSignup($email, $password, $name, $surname, $phone) {
    
    $result;

    if (empty($email) ||  empty($password) ||  empty($name) ||  empty($surname) ||  empty($phone)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}


// Função que limpa e verifica se o e-mail é válido
function invalidEmail($email) {

    $result;

    if (!filter_var($email, FILTER_SANITIZE_EMAIL)) {
        $result = true;
    }
    
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    
    else {
        $result = false;
    }

    return $result;
}


// Função que verifica se as senhas repetidas são identicas
function passwordMatch($password, $passwordRepeat) {
    $result;
    if ($password !== $passwordRepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}


// Função que verifica se o usuário já está cadastrado
function userExists($conn, $email) {

    $sql = "SELECT * FROM user WHERE email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ../signup.php?error=stmtfailed");
        exit();

    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {

        return $row;

    } else {
        $result = false;
    }

    return $result;

    mysqli_stmt_close($stmt);
}


// Função que cadastra o usuário na base de dados
function createUser($conn, $email, $password, $name, $surname, $phone, $role) {

    $sql = "INSERT INTO user (email, password, name, surname, phone, role) 
            VALUES (?, ?, ?, ?, ?, ?);"; /* Cria a query Sql */

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ../signup.php?error=stmtfailed");
        exit();

    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssssss", $email, $hashedPassword, $name, $surname, $phone, $role); // Is used to bind variables to the parameter markers of a prepared statement
    mysqli_stmt_execute($stmt); // Accepts a prepared statement object (created using the prepare() function) as a parameter, and executes it
    mysqli_stmt_close($stmt);

    // Já realiza o login do usuário para ele não ter que logar
    loginUser($conn, $email, $password);

}


// Função que verifica se os campos do login estão preenchidos
function emptyInputLogin($email, $password) {
    $result;
    if (empty($email) ||  empty($password)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}


// Função que realiza o login do usuário
function loginUser($conn, $email, $password) {

    $grabUser = userExists($conn, $email);

    if ($grabUser === false) {
        header("Location: ../login.php?error=wronglogin");
        exit();
    }

    $passwordHashed = $grabUser["password"];
    $checkPassword = password_verify($password, $passwordHashed);
    
    if ($checkPassword === false) {
        header("Location: ../login.php?error=wronglogin");
        exit();
    }
    else if ($checkPassword === true) { 
        session_start();
        $_SESSION["userid"] = $grabUser["id"];
        $_SESSION["username"] = $grabUser["name"];
        $_SESSION["usersurname"] = $grabUser["surname"];
        $_SESSION["useremail"] = $grabUser["email"];
        $_SESSION["userrole"] = $grabUser["role"];
        header("Location: ../index.php");
        exit();
    }
}

// Função que verifica se os campos do cadastro de produtos estão preenchidos
function emptyInputAddProduct($name, $description, $category, $quantity) {
    
    $result;

    if (empty($name) ||  empty($description) ||  empty($category) ||  empty($quantity)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}


// Função que cadastra o produto na base de dados
function addProduct($conn, $name, $description, $category, $quantity, $totalborrowed) {

    $sql = "INSERT INTO item (name, description, category, quantity, totalborrowed) 
            VALUES (?, ?, ?, ?, ?);"; /* Cria a query Sql */

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ../addproduct.php?error=stmtfailed");
        exit();

    }

    mysqli_stmt_bind_param($stmt, "sssss", $name, $description, $category, $quantity, $totalborrowed); // Is used to bind variables to the parameter markers of a prepared statement
    mysqli_stmt_execute($stmt); // Accepts a prepared statement object (created using the prepare() function) as a parameter, and executes it
    mysqli_stmt_close($stmt);
    header("Location: ../addproduct.php?addproduct=success");

}

// Função que cadastra um novo endereço na base de dados
function addAddress($conn, $street, $number, $complement, $neighborhood, $city, $state, $country, $postalcode, $user_id) {

    $sql = "INSERT INTO address (street, number, complement, neighborhood, city, state, country, postalcode, user_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);"; /* Cria a query Sql */

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ../addaddress.php?error=stmtfailed");
        exit();

    }

    mysqli_stmt_bind_param($stmt, "sssssssss", $street, $number, $complement, $neighborhood, $city, $state, $country, $postalcode, $user_id); // Is used to bind variables to the parameter markers of a prepared statement
    mysqli_stmt_execute($stmt); // Accepts a prepared statement object (created using the prepare() function) as a parameter, and executes it
    mysqli_stmt_close($stmt);
    header("Location: ../displayaddress.php?add=success");

}

// Função que verifica se os campos do cadastro de produtos estão preenchidos
function emptyInputAddAddress($street, $city, $postalcode) {
    
    $result;

    if (empty($street) ||  empty($city) ||  empty($postalcode)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

//
function returnAllProducts($conn) {

    $sql = "SELECT * FROM item;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ../displayproducts.php?error=stmtfailed");
        exit();

    }

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {

        return $row;

    } else {
        $result = false;
    }

    return $result;

    mysqli_stmt_close($stmt);
}


// Função para deletar produto
function deleteProduct($conn, $productId) {

        //Verifica se não existem empréstimos ativos antes de deletar
    $sql = "SELECT * FROM user_has_item WHERE item_id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ../displayproducts.php?error=stmtfailed");
        exit();

    }

    mysqli_stmt_bind_param($stmt, "s", $productId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    $resultCheck = false;

    if ($row = mysqli_fetch_assoc($resultData)) {
        
        $resultCheck = true;

    }

    if ($resultCheck == true) {
        header("Location: ../displayproducts.php?error=deleteforbbiden");
        exit();
    }

    mysqli_stmt_close($stmt);


    //Deleta o produto se não existirem empréstimos ativos
    $sql = "DELETE FROM item WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ../displayproducts.php?error=stmtfailed");
        exit();

    }

    mysqli_stmt_bind_param($stmt, "s", $productId); // Is used to bind variables to the parameter markers of a prepared statement
    mysqli_stmt_execute($stmt); // Accepts a prepared statement object (created using the prepare() function) as a parameter, and executes it
    mysqli_stmt_close($stmt);
    header("Location: ../displayproducts.php?delete=success");

}



// Função para edit produto
function editProduct($conn, $id, $name, $description, $category, $quantity, $totalborrowed) {

        //Verifica se não está alterando as quantidades disponíveis
        if ($quantity < $totalborrowed) {
            header("Location:  ../displayproducts.php?error=availabilityerror");
            exit();
        }

        $sql = "UPDATE item SET name = ?, description = ?, category = ?, quantity = ? WHERE id = ?;";

        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location:  ../displayproducts.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sssis", $name, $description, $category, $quantity, $id); // Is used to bind variables to the parameter markers of a prepared statement
        mysqli_stmt_execute($stmt); // Accepts a prepared statement object (created using the prepare() function) as a parameter, and executes it
        mysqli_stmt_close($stmt);
        header("Location:  ../displayproducts.php?edit=success");

    }


// Função para deletar endereço
function deleteAddress($conn, $addressId) {

    $addressId = mysqli_real_escape_string($conn, securityDataValidation($_POST['aid']));

    $sql = "DELETE FROM address WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ../displayaddress.php?error=stmtfailed");
        exit();

    }

    mysqli_stmt_bind_param($stmt, "s", $addressId); // Is used to bind variables to the parameter markers of a prepared statement
    mysqli_stmt_execute($stmt); // Accepts a prepared statement object (created using the prepare() function) as a parameter, and executes it
    mysqli_stmt_close($stmt);
    header("Location: ../displayaddress.php?delete=success");

}


// Função para detecção de erros
function printHiThere() {
    echo "Hi There";
}


// Função para realizar um empréstimo gerido pelo admin
function makeLending($conn, $id, $name, $description, $category, $quantity, $totalborrowed, $quantityborrowed, $emailuser) {

    //Verifica quantas unidades estão disponíveis para emprestimo
    $availability = $quantity - $totalborrowed;

    if ($quantityborrowed > $availability) {
        header("Location: ../displayproducts.php?error=notavailable");
        exit();
    }

    //Localiza o usuário que receberá o empréstimo na base de dados
    $sql = "SELECT * FROM user WHERE email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ../displayproducts.php?error=stmtfailed");
        exit();

    }

    mysqli_stmt_bind_param($stmt, "s", $emailuser);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        
        $userid = $row['id'];

    } else {
        header("Location: ../displayproducts.php?error=usernotfound");
        exit();
    }

    mysqli_stmt_close($stmt);

    //Cria datas  
    $dateNow = date('Y-m-d H:i:s');
    $dueDate = date('Y-m-d H:i:s', strtotime($date . '+ 5 days'));

    // Identifica quantas unidades estão emprestadas para o usuário
    $sql = "SELECT * FROM user_has_item WHERE user_id = ? AND item_id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ../displayproducts.php?error=stmtfailed");
        exit();

    }

    mysqli_stmt_bind_param($stmt, "ss", $userid, $id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {

        // Se encontrar um registro ativo de empréstimo, pega a variável de quantas unid estão emprestadas
        $quantityStored = $row['quantityborrowed'];

        //Fecha a conexão anterior
        mysqli_stmt_close($stmt);

        $newQuantity = $quantityborrowed + $quantityStored;

        // Realiza a atualização do empréstimo
        $sql = "UPDATE user_has_item SET lenddate = ?, lendupto = ?, quantityborrowed = ? WHERE user_id = ? AND item_id = ?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            
            header("Location: ../displayproducts.php?error=stmtfailed");
            exit();

        }

        mysqli_stmt_bind_param($stmt, "sssss", $dateNow, $dueDate, $newQuantity, $userid, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    } else {
        // Fecha a conexão anterior
        mysqli_stmt_close($stmt);

        // Se não encontrar nenhum registro, realiza um empréstimo do zero
        $sql = "INSERT INTO user_has_item (user_id, item_id, lenddate, quantityborrowed, lendupto) VALUES (?, ?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            
            header("Location: ../displayproducts.php?error=stmtfailed");
            exit();

        }

        mysqli_stmt_bind_param($stmt, "sssss", $userid, $id, $dateNow, $quantityborrowed, $dueDate);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    }


// Realiza a adequação das quantidades disponíveis dos produtos emprestados
    $newQuantityBorrowed = $totalborrowed + $quantityborrowed;

    $sql = "UPDATE item SET totalborrowed = ? WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ../displayproducts.php?error=stmtfailed");
        exit();

    }

    mysqli_stmt_bind_param($stmt, "ss", $newQuantityBorrowed, $id);
    mysqli_stmt_execute($stmt); // Accepts a prepared statement object (created using the prepare() function) as a parameter, and executes it
    mysqli_stmt_close($stmt);

    // Finaliza direcionando o usuário para a página de sucesso
    header("Location: ../displayproducts.php?edit=lendsuccess");
}


// Função para realizar uma devolução gerida pelo admin
function makeReturn($conn, $id, $name, $description, $category, $quantity, $totalborrowed, $returnedQuantity, $emailuser) {

    //Localiza o usuário que receberá o empréstimo na base de dados
    $sql = "SELECT * FROM user WHERE email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ../displayproducts.php?error=stmtfailed");
        exit();

    }

    mysqli_stmt_bind_param($stmt, "s", $emailuser);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        
        $userid = $row['id'];

    } else {
        header("Location: ../displayproducts.php?error=usernotfound");
        exit();
    }

    mysqli_stmt_close($stmt);


    // Identifica quantas unidades estão emprestadas para o usuário
    $sql = "SELECT * FROM user_has_item WHERE user_id = ? AND item_id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ../displayproducts.php?error=stmtfailed");
        exit();

    }

    mysqli_stmt_bind_param($stmt, "ss", $userid, $id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        
        $quantityborrowed = $row['quantityborrowed'];

    } else {
        header("Location: ../displayproducts.php?error=usernotfound");
        exit();
    }

    mysqli_stmt_close($stmt);


    //Verifica quantas unidades estão disponíveis para devolução
    if ($returnedQuantity > $quantityborrowed) {
        header("Location: ../displayproducts.php?error=overreturn");
        exit();
    }

    //Verifica se não está tentando devolver um número negativo
    if ($returnedQuantity < 0) {
        header("Location: ../displayproducts.php?error=zeronotvalid");
        exit();
    }

    // Verifica a quantidade de itens que devem ficar na base de dados após a devolução

    $newQuantity = $quantityborrowed - $returnedQuantity;

    //Cria data de devolução
    $dateNow = date('Y-m-d H:i:s');

    // Realiza a devolução
    $sql = "UPDATE user_has_item SET returndate = ?, quantityborrowed = ? WHERE user_id = ? AND item_id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ../displayproducts.php?error=stmtfailed");
        exit();

    }

    mysqli_stmt_bind_param($stmt, "ssss", $dateNow, $newQuantity, $userid, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Verifica se a quantidade restante emprestada na base de dados é igual a zero,
    // deleta a entrada se for igual a zero, liberando deletar o item em outra função
    $sql = "SELECT * FROM user_has_item WHERE user_id = ? AND item_id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ../displayproducts.php?error=stmtfailed");
        exit();

    }

    mysqli_stmt_bind_param($stmt, "ss", $userid, $id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        
        $quantityborrowed = $row['quantityborrowed'];

        if ($quantityborrowed == 0) {
            mysqli_stmt_close($stmt);

            $sql = "DELETE FROM user_has_item WHERE user_id = ? AND item_id = ?;";
            $stmt = mysqli_stmt_init($conn);
        
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                
                header("Location: ../displayproducts.php?error=stmtfailed");
                exit();
        
            }
        
            mysqli_stmt_bind_param($stmt, "ss", $userid, $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

    } else {
        mysqli_stmt_close($stmt);
    }


// Realiza a adequação das quantidades disponíveis dos produtos emprestados
    $newQuantityBorrowed = $totalborrowed - $returnedQuantity;

    $sql = "UPDATE item SET totalborrowed = ? WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ../displayproducts.php?error=stmtfailed");
        exit();

    }

    mysqli_stmt_bind_param($stmt, "ss", $newQuantityBorrowed, $id);
    mysqli_stmt_execute($stmt); // Accepts a prepared statement object (created using the prepare() function) as a parameter, and executes it
    mysqli_stmt_close($stmt);

    // Finaliza direcionando o usuário para a página de sucesso
    header("Location: ../displayproducts.php?edit=returnsuccess");

}


// Função que edita o usuário na base de dados
function editUser($conn, $id, $name, $surname, $email, $phone, $password) {

    $sql = "UPDATE user SET email = ?, password = ?, name = ?, surname = ?, phone = ? WHERE id = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ../editprofile.php?error=stmtfailed");
        exit();

    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssssss", $email, $hashedPassword, $name, $surname, $phone, $id); // Is used to bind variables to the parameter markers of a prepared statement
    mysqli_stmt_execute($stmt); // Accepts a prepared statement object (created using the prepare() function) as a parameter, and executes it
    mysqli_stmt_close($stmt);
    header("Location: ../profile.php?edituser=success");

}

// Função que verifica se o usuário que está editando o perfil está usando o mesmo e-mail ou e-mail já usado por outro usuário
function userExistsOrSame($conn, $email, $id) {

    $sql = "SELECT * FROM user WHERE email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("Location: ../editprofile.php?error=stmtfailed");
        exit();

    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {

        if ($row['email'] == $email and $row['id'] == $id) {

            $result = false;
            return $result;

        } else {

            return $row['email'];

        }

    } else {
        $result = false;
    }

    return $result;

    mysqli_stmt_close($stmt);
}


// Mensagem personalizada de erros
function popError($message) {

    $personalizedMessageError = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            
    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-exclamation-triangle-fill' viewBox='0 0 16 16'>
        <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
    </svg>  " . $message . " 
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Fechar'></button>
    </div><br>";

    return $personalizedMessageError;

}


// Mensagem personalizada de sucesso
function popSuccess($message) {

    $personalizedMessageError = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            
    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-check-circle-fill' viewBox='0 0 16 16'>
        <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
    </svg>  " . $message . " 
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Fechar'></button>
    </div><br>";

    return $personalizedMessageError;

}


// Mensagem personalizada de sucesso
function popInfo($message) {

    $personalizedMessageError = "<div class='alert alert-info alert-dismissible fade show' role='alert'>
    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-info-circle-fill' viewBox='0 0 16 16'>
        <path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'/>
    </svg>       " . $message . "
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div><br>";

    return $personalizedMessageError;

}