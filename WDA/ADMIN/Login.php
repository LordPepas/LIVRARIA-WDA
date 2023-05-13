<?php
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
    <link rel="stylesheet" href="../assets/css/Log.css">
</head>

<body>
    <div>
        <h2>SISTEMA BIBLIOTECA</h2><br>
        <form action="TesteLogin.php" method="POST">
            <label><img src="../assets/img/user.jpg" height="30px" width="30px"> Usuário</label>
            <input type="text" name="username" placeholder="Username" value="<?php echo $username ?>" required>
            <br><br>
            <label><img src="../assets/img/chave.jpg" height="30px" width="30px">Senhaㅤ</label>
            <input type="password" name="senha" placeholder="Password" value="<?php echo $senha ?>" required>
            <br><br>

            <input type="submit" class="inputSubmit" name="submit" value="Acessar"><br><br>
        </form>
        <a href="Cadastro.php">Cadastra-se</a>
    </div>
</body>

</html>