<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    include_once('../Config.php');
    $id = $_GET['id'];

    $sqlSelect = "SELECT * FROM usuario WHERE Cod_usuario=$id";

    $result = $conexao->query($sqlSelect);

    if ($result->num_rows > 0) {
        while ($user_data = mysqli_fetch_assoc($result)) {
            $nome = $user_data['Nome_usuario'];
            $cidade = $user_data['Cidade'];
            $endereco = $user_data['Endereço'];
            $email = $user_data['Email'];
        }
    } else {
        // header('Location: ../Usuario.php');
    }
} else {
    // header('Location:  ../Usuario.php');
}
$nome_original = $nome;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EDITAR DADOS(LIVRO)</title>
    <link rel="stylesheet" href="../assets/css/Cadastro.css">
</head>

<body>

    <div class="container">
        <div class="form-image">
            <img src="../assets/img/Cadastro_cliente.svg" width="" height="">
        </div>
        <div class="form">
            <form action="Save_usuario.php" method="POST">
                <div class="form-register">
                    <div class="title">
                        <h1>Editar Dados (Cliente)</h1>
                    </div>
                    <div class="voltar-button">
                        <button><a href="../SISTEMA/Usuarios.php">Voltar</a></button>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-box">
                        <label for="nome">Nome</label>
                        <input id="nome" type="text" name="nome" placeholder="Digite seu primeiro nome" value="<?php echo $nome ?>" required>
                    </div>

                    <div class="input-box">
                        <label for="number">Cidade</label>
                        <input id="cidade" type="text" name="cidade" placeholder="Digite sua cidade" value="<?php echo $cidade ?>" required>
                    </div>

                    <div class="input-box">
                        <label for="number">Endereço</label>
                        <input id="endereoo" type="text" name="endereco" placeholder="Digite seu endereço" value="<?php echo $endereco ?>" required>
                    </div>

                    <div class="input-box">
                        <label for="email">E-mail</label>
                        <input id="email" type="email" name="email" placeholder="Digite seu e-mail" value="<?php echo $email ?>" required>
                    </div>
                </div>
                <div class="continue-button">
                    <input type="hidden" name="id" value=<?php echo $id; ?>>
                    <input id="nome" type="hidden" name="nome_original" value="<?php echo $nome ?>" required>
                    <input name="update" type="submit" value="Salvar">
                </div>
            </form>
        </div>
    </div>
</body>

</html>