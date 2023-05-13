<?php
if (!empty($_GET['id'])) {
    include_once('../Config.php');
    $id = $_GET['id'];

    $sqlSelect = "SELECT * FROM livro WHERE Cod_livro=$id";

    $result = $conexao->query($sqlSelect);

    if ($result->num_rows > 0) {

        while ($user_data = mysqli_fetch_assoc($result)) {
            $titulo = $user_data['Nome_livro'];
            $editora = $user_data['Editora'];
            $autor = $user_data['Autor'];
            $lançamento = $user_data['Lançamento'];
            $quantidade = $user_data['Quantidade'];
        }
    } else {
        header('Location: ../Livros.php');
    }
} else {
    header('Location:  ../Livros.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EDITAR DADOS(LIVRO)</title>
    <link rel="stylesheet" href="../assets/css/Cadastro.css">
    <style>

    </style>
</head>

<body>

    <div class="container">
        <div class="form-image">
            <img src="../assets/img/Livro.svg" width="" height="">
        </div>
        <div class="form">
            <form action="./Save_livro.php" method="POST">
                <div class="form-register">
                    <div class="title">
                        <h1>Editar Dados (Livro)</h1>
                    </div>
                    <div class="voltar-button">
                        <button><a href="../SISTEMA/Livros.php">Voltar</a></button>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-box">
                        <label for="titulo">Titulo</label>
                        <input id="titulo" type="text" name="titulo" placeholder="Digite o Titulo" value="<?php echo $titulo ?>" required>
                    </div>

                    <div class="input-box">
                        <div class="select">
                            <label for="Editora">Editora</label>
                            <select class="select" name="editora">
                                <option disabled selected>Selecioneㅤㅤㅤㅤㅤㅤㅤ</option>
                                <?php
                                include_once('../Config.php');
                                $sql = "SELECT * FROM editora ORDER BY Cod_editora";
                                $res = mysqli_query($conexao, $sql);
                                while ($user_livro = mysqli_fetch_row($res)) {
                                    //puxar dados pelo id
                                    $cod_livro = $user_livro[0];
                                    //
                                    $nome_livro = $user_livro[1];
                                    echo "<option class='editora' value='$cod_livro'" . ($cod_livro == $editora ? " selected" : "") . ">$nome_livro</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="input-box">
                        <label for="autor">Autor</label>
                        <input id="autor" type="text" name="autor" placeholder="Digite o nome do autor " value="<?php echo $autor ?>" required>
                    </div>

                    <div class="input-box">
                        <label for="lançamento">Ano de lançamento</label>
                        <input id="lançamento" type="number" max="2023" name="lançamento" placeholder="XXXX" value="<?php echo $lançamento ?>" required>
                    </div>

                    <div class="input-box">
                        <label for="quantidade">Quantidade</label>
                        <input id="quantidade" type="number" name="quantidade" placeholder="digite a quantidade" value="<?php echo $quantidade ?>" required>
                    </div>
                </div>

                <div class="continue-button">
                    <input type="hidden" name="id" value=<?php echo $id; ?>>
                    <input type="hidden" name="titulo_original" value="<?php echo $titulo; ?>">
                    <input name="update" type="submit" value="Salvar">
                </div>
            </form>
        </div>
    </div>
</body>

</html>