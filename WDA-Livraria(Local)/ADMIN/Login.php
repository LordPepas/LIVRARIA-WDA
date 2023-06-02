<?php
session_start();
include_once('../Config.php');
$sqlSelect = "SELECT * FROM acesso_admin WHERE Cod_admin";
$result = $conexao->query($sqlSelect);

$user_data = mysqli_fetch_assoc($result);

$username = $user_data['Username_admin'];
$senha = $user_data['Senha'];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN LIVRARIA</title>
    <link rel="stylesheet" href="../assets/css/Login.css">
</head>

<body>
    <div>
        <h2>SISTEMA BIBLIOTECA</h2><br>
        <form action="TesteLogin.php" method="POST" onsubmit="return validarInput()">
            <label><img src="../assets/img/user.jpg" height="30px" width="30px"> Usuário</label>
            <input type="text" name="username" id="username" placeholder="Username" value="<?php echo $username ?>">
            <br><br>
            <label><img src="../assets/img/chave.jpg" height="30px" width="30px"> Senha</label>
            <input type="password" name="senha" id="senha" placeholder="Password" value="<?php echo $senha ?>">
            <br><br>
            <h3 id="error-message" class="error-message"></h3>
            <input type="submit" class="inputSubmit" name="submit" value="Acessar"><br><br>
        </form>
        <a href="Cadastro.php">Cadastrar-se</a>
    </div>
    <script>
        function displayError(errorId, errorMessage) {
            document.getElementById(errorId).textContent = errorMessage;
        }

        function validarInput() {
            var username = document.getElementById("username");
            var senha = document.getElementById("senha");
            var errorMessage = document.getElementById("error-message");
            var errors = [];

            errorMessage.textContent = ""; // Limpa a mensagem de erro anterior

            if (username.value.trim() === "") {
                username.classList.add("error");
                errors.push("Usuário");
            } else {
                username.classList.remove("error");
            }

            if (senha.value.trim() === "") {
                senha.classList.add("error");
                errors.push("Senha");
            } else {
                senha.classList.remove("error");
            }

            if (errors.length > 0) {
                errorMessage.textContent = "Preencha os seguintes campos: " + errors.join(", ");
                return false;
            }
        }
    </script>
</body>

</html>