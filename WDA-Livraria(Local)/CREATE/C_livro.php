<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>;
</head>
<?php
if (isset($_POST['submit'])) { // verifica se o formulário foi submetido
    include_once('../Config.php'); // inclui o arquivo de configuração do banco de dados

    $titulo = $_POST['titulo'];
    $editora = $_POST['editora'];
    $autor = $_POST['autor'];
    $lançamento = $_POST['lançamento'];
    $quantidade = $_POST['quantidade'];

    $sqcliente = "SELECT * FROM livro WHERE Nome_livro ='$titulo'"; // consulta para verificar se o usuário já existe
    mysqli_query($conexao, "ALTER TABLE dblocadora.livro AUTO_INCREMENT = 1;");

    $resultado = $conexao->query($sqcliente); // executa a consulta

    if (mysqli_num_rows($resultado) == 1) { // verifica se encontrou algum registro
        $mensagem = 'Livro já existe'; // define a mensagem de erro
    } else {
        $result = mysqli_query($conexao, "INSERT INTO livro (Nome_livro,Editora,Autor,Lançamento,Quantidade)
        VALUES ('$titulo','$editora','$autor','$lançamento','$quantidade')"); // insere o novo usuário no banco de dados
        if (!$result) { // verifica se ocorreu algum erro ao inserir o registro
            $mensagem = "Erro ao cadastrar livro: " . mysqli_error($conexao); // define a mensagem de erro
        } else {
            echo "<script type='text/javascript'>Swal.fire('Exelente!', 'Livro adicionado', 'success').then(() => {window.location.href = '../SISTEMA/Livros.php';})</script>"; // exibe a mensagem de erro
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
    <title>CADASTRO LIVRO</title>
    <link rel="stylesheet" href="../assets/css/Cadastro.css">
    <style>
        /* Cadastro Livros */

        /* Define o estilo da div que contém o label e o select */
        .select {
            display: flex;
            flex-direction: column;
            margin-bottom: 18px;
        }

        /* Define o estilo do select */
        .select select {
            margin: 10px 0;
            padding: 13px 19px;
            border: none;
            border-radius: 10px;
            box-shadow: 1px 1px 6px #0000001c;
            font-size: 13px;
        }

        /* Define o estilo do efeito de hover sobre o select */
        .select select:hover {
            background-color: rgba(238, 238, 238, 0.459);
        }

        /* Define o estilo do foco visível no select */
        .select select:focus-visible {
            outline: 1px solid rgb(108, 99, 255);
        }

        /* Define o estilo da label associada ao select */
        .select label {
            font-size: 12px;
            font-weight: 600;
            color: rgb(0, 0, 0, 0.753);
        }

        /* Define o estilo do placeholder do select */
        .select select::placeholder {
            color: rgb(0, 0, 0, 0.745);
        }

        /* Define o estilo dos options */
        .select select option {
            font-size: 13px;
            color: rgb(0, 0, 0, 0.753);
        }

        /* Define o estilo dos options quando selecionados */
        .select select option:checked {
            background-color: rgb(108, 99, 255);
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="form-image">
            <img src="../assets/img/Livro.svg" width="" height="">
        </div>
        <div class="form">
            <form action="C_livro.php" method="POST">
                <div class="form-register">
                    <div class="title">
                        <h1>ADICIONAR LIVRO</h1>
                    </div>
                    <div class="voltar-button">
                        <button><a href="../SISTEMA/Livros.php">Voltar</a></button>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-box">
                        <label for="titulo">Titulo</label>
                        <input id="titulo" type="text" name="titulo" placeholder="Digite o Titulo" required>
                    </div>

                    <div class="input-box">
                        <div class="select">
                            <label for="Editora">Editora</label>
                            <select class="select" name="editora">
                                <option>Selecioneㅤㅤㅤㅤㅤㅤㅤ</option>
                                <?php
                                include_once('../Config.php');
                                $sql = "SELECT * FROM editora ORDER BY Cod_editora";
                                $res = mysqli_query($conexao, $sql);
                                while ($user_livro = mysqli_fetch_row($res)) {
                                    //puxar dados pelo id
                                    $cod_livro = $user_livro[0];
                                    //
                                    $nome_livro = $user_livro[1];

                                    echo "<option class='editora' value='$cod_livro'>$nome_livro</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="input-box">
                        <label for="autor">Autor</label>
                        <input id="autor" type="text" name="autor" placeholder="Digite o nome do autor " required>
                    </div>

                    <div class="input-box">
                        <label for="lançamento">Ano de lançamento</label>
                        <input id="lançamento" type="number" max="2023" name="lançamento" placeholder="XXXX" required>
                    </div>

                    <div class="input-box">
                        <label for="quantidade">Quantidade de livros</label>
                        <input id="quantidade" type="number" name="quantidade" required>
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