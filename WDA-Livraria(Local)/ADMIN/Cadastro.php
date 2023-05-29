<?php
if (isset($_POST['submit'])) {
    include_once('../Config.php');

    $nome = $_POST['nome'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $senhaConfirma  = $_POST['confirmsenha'];

    if (!empty($nome) && !empty($username) && !empty($email) && !empty($senha) && !empty($senhaConfirma)) {
        if ($senha == $senhaConfirma) {
            $result = mysqli_query($conexao, "INSERT INTO acesso_admin (Nome_admin,Username_admin,Email,Senha)
            VALUES ('$nome','$username','$email','$senha')");
            if (!$result) {
                echo "<script>alert('Ops! Erro ao cadastrar usuário: " . mysqli_error($conexao) . "')</script>";
            } else {
                header('Location: login.php');
                exit(); // Add this line to stop script execution
            }
        } else {
            echo "<script>alert('As senhas não conferem')</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CADASTRO ADMINISTRADOR</title>
    <link rel="stylesheet" href="../assets/css/Cadastro.css">
    <style>
        .input-box input.error {
            border: 1px solid red;
        }

        .select_editora select.error {
            border: 1px solid red;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .field-error {
            font-size: 14px;
            color: red;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="form-image">
            <img src="../assets/img/Cadastro_admin.svg" width="" height="">
        </div>

        <div class="form">
            <form action="Cadastro.php" method="POST" onsubmit="return validarInput()">
                <div class="form-register">
                    <div class="title">
                        <h1>Cadastre-se (ADMIN)</h1>
                    </div>
                    <div class="voltar-button">
                        <button><a href="../Home.php">Voltar</a></button>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-box">
                        <label for="nome">Nome</label>
                        <input id="nome" type="text" name="nome" placeholder="Digite seu primeiro nome">
                        <span id="nome_error" class="field-error"></span>
                    </div>

                    <div class="input-box">
                        <label for="username">Nome de usuário</label>
                        <input id="username" type="text" name="username" placeholder="Digite seu Nome de usuário ">
                        <span id="username_error" class="field-error"></span>
                    </div>

                    <div class="input-box">
                        <label for="email">E-mail</label>
                        <input id="email" type="email" name="email" placeholder="Digite seu e-mail">
                        <span id="email_error" class="field-error"></span>
                    </div>

                    <div class="input-box">
                        <label for="senha">Senha</label>
                        <input id="senha" type="password" name="senha" placeholder="Digite sua senha">
                        <span id="senha_error" class="field-error"></span>
                    </div>

                    <div class="input-box">
                        <label for="confirmsenha">Confirme sua senha</label>
                        <input id="confirmsenha" type="password" name="confirmsenha" placeholder="Digite sua senha Novamente">
                        <span id="confirmsenha_error" class="field-error"></span>
                    </div>

                </div>

                <div class="continue-button">
                    <h3 id="error-message" class="error-message"></h3>
                    <input name="submit" type="submit" id="submit" value="Cadastrar">
                </div>
            </form>
        </div>
    </div>
    <script>
        function validarInput() {
            var nome = document.getElementById("nome");
            var username = document.getElementById("username");
            var email = document.getElementById("email");
            var senha = document.getElementById("senha");
            var confirmsenha = document.getElementById("confirmsenha");
            var errorMessage = document.getElementById("error-message");
            var errors = 0;

            if (nome.value === "") {
                nome.classList.add("error");
                document.getElementById("nome_error").textContent = "Por favor, preencha o nome.";
                errors++;
            } else {
                nome.classList.remove("error");
                document.getElementById("nome_error").textContent = "";
            }

            if (username.value === "") {
                username.classList.add("error");
                document.getElementById("username_error").textContent = "Por favor, preencha o usuário.";
                errors++;
            } else {
                username.classList.remove("error");
                document.getElementById("username_error").textContent = "";
            }

            if (email.value === "") {
                email.classList.add("error");
                document.getElementById("email_error").textContent = "Por favor, preencha o E-mail.";
                errors++;
            } else {
                email.classList.remove("error");
                document.getElementById("email_error").textContent = "";
            }

            if (senha.value === "") {
                senha.classList.add("error");
                document.getElementById("senha_error").textContent = "Por favor, preencha a senha.";
                errors++;
            } else {
                senha.classList.remove("error");
                document.getElementById("senha_error").textContent = "";
            }
            if (confirmsenha.value === "") {
                confirmsenha.classList.add("error");
                document.getElementById("confirmsenha_error").textContent = "Por favor, preencha a senha novamente.";
                errors++;
            } else {
                confirmsenha.classList.remove("error");
                document.getElementById("confirmsenha_error").textContent = "";
            }

            if (errors > 0) {
                errorMessage.textContent = "Por favor, corrija os erros no formulário.";
                return false;
            }
        }
    </script>
</body>

</html>