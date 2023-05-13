<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>;
</head>
<?php
if (isset($_POST['submit'])) { // verifica se o formulário foi submetido
    include_once('../Config.php'); // inclui o arquivo de configuração do banco de dados

    $nome = $_POST['nome'];
    $cidade = $_POST['cidade'];
    $endereço = $_POST['endereço'];
    $email = $_POST['email'];

    $sqlcliente = "SELECT * FROM usuario WHERE Nome_usuario ='$nome'"; // consulta para verificar se o usuário já existe

    $resultado = $conexao->query($sqlcliente); // executa a consulta
    mysqli_query($conexao, "ALTER TABLE dblocadora.usuario AUTO_INCREMENT = 1;");

    if (mysqli_num_rows($resultado) == 1) { // verifica se encontrou algum registro
        $mensagem = 'Usuário já existe'; // define a mensagem de erro
    } else {
        $result = mysqli_query($conexao, "INSERT INTO usuario (Nome_usuario,Cidade,Endereço,Email)
        VALUES ('$nome','$cidade','$endereço','$email')"); // insere o novo usuário no banco de dados
        if (!$result) { // verifica se ocorreu algum erro ao inserir o registro
            $mensagem = "Erro ao cadastrar usuário: " . mysqli_error($conexao); // define a mensagem de erro
        } else {
            echo "<script type='text/javascript'>Swal.fire('Excelente!','Aluguel adicionado com sucesso!','success').then(() => {window.location.href = '../SISTEMA/Usuarios.php';})</script>";
        }
    }


    if (isset($mensagem)) { // verifica se há alguma mensagem de erro
        echo "<script type='text/javascript'>Swal.fire('Ops!', '$mensagem', 'error')</script>"; // exibe a mensagem de erro
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CADASTRO USUÁRIO</title>
    <link rel="stylesheet" href="../assets/css/Cadastro.css">
</head>

<body>

    <div class="container">
        <div class="form-image">
            <img src="../assets/img/Cadastro_cliente.svg" width="" height="">
        </div>
        <div class="form">
            <form action="C_usuario.php" method="POST">
                <div class="form-register">
                    <div class="title">
                        <h1>ADICIONAR CLIENTE</h1>
                    </div>
                    <div class="voltar-button">
                        <button><a href="../SISTEMA/Usuarios.php">Voltar</a></button>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-box">
                        <label for="nome">Nome</label>
                        <input id="nome" type="text" name="nome" placeholder="Digite seu nome" required>
                    </div>

                    <div class="input-box">
                        <label for="username">Cidade</label>
                        <input id="cidade" type="text" name="cidade" placeholder="Digite sua cidade " required>
                    </div>


                    <div class="input-box">
                        <label for="endereço">Endereço</label>
                        <input id="endereço" type="text" name="endereço" placeholder="Digite seu Endereço" required>
                    </div>

                    <div class="input-box">
                        <label for="email">E-mail</label>
                        <input id="email" type="email" name="email" placeholder="Digite seu e-mail" required>
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