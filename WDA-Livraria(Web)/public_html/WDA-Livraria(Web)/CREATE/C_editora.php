<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>;
</head>
<?php
if(isset($_POST['submit'])) { // verifica se o formulário foi submetido
    include_once('../Config.php'); // inclui o arquivo de configuração do banco de dados

    $nome = $_POST['nome'];
    $cidade = $_POST['cidade'];
    $contato = $_POST['contato'];

    $sqcliente = "SELECT * FROM editora WHERE Nome_editora ='$nome'"; // consulta para verificar se o usuário já existe

    $resultado = $conexao->query($sqcliente); // executa a consulta
    mysqli_query($conexao, "ALTER TABLE id20742095_bdlocadora.editora AUTO_INCREMENT = 1;");

    if (mysqli_num_rows($resultado) == 1) { // verifica se encontrou algum registro
        $mensagem = 'Editora já existe'; // define a mensagem de erro
    } else {
        $result = mysqli_query($conexao, "INSERT INTO editora (Nome_editora,Cidade,Contato)
        VALUES ('$nome','$cidade','$contato')"); // insere o novo usuário no banco de dados
        if (!$result) { // verifica se ocorreu algum erro ao inserir o registro
            $mensagem = "Erro ao cadastrar usuário: " . mysqli_error($conexao); // define a mensagem de erro
        } else {
            echo "<script type='text/javascript'>Swal.fire('Excelente!', 'Editora adicionada com sucesso', 'success').then(() => {window.location.href = '../SISTEMA/Editoras.php';})</script>"; // exibe a mensagem de erro
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
    <title>Cadastro Aluno</title>
    <link rel="stylesheet" href="../assets/css/Cadastro.css">
</head>

<body>

    <div class="container">
        <div class="form-image">
            <img src="../assets/img/Editora.svg" width="" height="">
        </div>
        <div class="form">
            <form action="./C_editora.php" method="POST">
                <div class="form-register">
                    <div class="title">
                        <h1>ADICIONAR EDITORA</h1>
                    </div>
                    <div class="voltar-button">
                        <button><a href="../SISTEMA/Editoras.php">Voltar</a></button>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-box">
                        <label for="nome">Editora</label>
                        <input id="nome" type="text" name="nome" placeholder="Digite o nome da editora" required>
                    </div>

                    <div class="input-box">
                        <label for="username">Cidade</label>
                        <input id="cidade" type="text" name="cidade" placeholder="Digite a cidade" required>
                    </div>

                    <div class="input-box">
                        <label for="Contato">Contato</label>
                        <input id="contato" type="text" name="contato" placeholder="unknown@unknown.com" required>
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