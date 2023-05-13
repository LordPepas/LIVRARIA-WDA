<?php
    if (isset($_POST['submit'])) {
        include_once('../Config.php');
    
        $nome = $_POST['nome'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $senhaConfirma  = $_POST['confirmsenha'];
    
        if ($senha == $senhaConfirma) {
            $result = mysqli_query($conexao, "INSERT INTO acesso_admin (Nome_admin,Username_admin,Email,Senha)
            VALUES ('$nome','$username','$email','$senha')");
            if (!$result) {
                echo "<script>alert('Erro ao cadastrar usuário: " . mysqli_error($conexao) . "')</script>";
            } else {
                header('location: login.php');
            }
        } else {
            echo "<script>alert('As senhas não conferem!')</script>";
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
</head>

<body>

    <div class="container">
        <div class="form-image">
            <img src="../assets/img/Cadastro_admin.svg" width="" height="">
        </div>
        <div class="form">
            <form action="Cadastro.php" method="POST">
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
                        <input id="nome" type="text" name="nome" placeholder="Digite seu primeiro nome" required>
                    </div>

                    <div class="input-box">
                        <label for="username">Nome de usuário</label>
                        <input id="username" type="text" name="username" placeholder="Digite seu Nome de usuário " required>
                    </div>

                    <div class="input-box">
                        <label for="email">E-mail</label>
                        <input id="email" type="email" name="email" placeholder="Digite seu e-mail" required>
                    </div>

                    <div class="input-box">
                        <label for="senha">Senha</label>
                        <input id="senha" type="password" name="senha" placeholder="Digite sua senha" required>
                    </div>

                    <div class="input-box">
                        <label for="confirmsenha">Confirme sua senha</label>
                        <input id="confirmsenha" type="password" name="confirmsenha" placeholder="Digite sua senha Novamente" required>
                    </div>

                </div>

                <div class="continue-button">
                    <input name="submit" type="submit" value="Cadastrar">
                </div>
            </form>
        </div>
    </div>
</body>

</html>