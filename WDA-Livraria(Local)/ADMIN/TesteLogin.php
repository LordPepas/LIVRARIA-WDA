<?php 
session_start();
 ?>
<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php

    /* print_r($_REQUEST); */

    if (isset($_POST['submit'])) {
        //Acessa
        include_once('../Config.php');

        $username = $_POST['username'];
        $senha = $_POST['senha'];
    }
    if(!empty($username) && !empty($senha)){

        $sql = "SELECT * FROM acesso_admin WHERE Username_admin = '$username' and Senha = '$senha'";
        $result = $conexao->query($sql);
        mysqli_query($conexao, "ALTER TABLE dblocadora.acesso_admin AUTO_INCREMENT = 1;");
        /*  print_r($result);
        print_r($sql); */

        if (mysqli_num_rows($result) < 1) {

            unset($_SESSION['username']); //destruir dados
            unset($_SESSION['senha']); //destruir dados
            echo "<script type='text/javascript'>Swal.fire('Ops!', 'Usuário ou senha incorretos!', 'error').then(() => {window.location.href = './Login.php';})</script>";
        } else {
            $_SESSION['username'] = $username;
            $_SESSION['senha'] = $senha;
            echo "<script type='text/javascript'>Swal.fire('Excelente!', 'Usuário Logado!', 'success').then(() => {window.location.href = '../SISTEMA/Sistema.php';})</script>";
        }
    }
    ?>
</body>

</html>