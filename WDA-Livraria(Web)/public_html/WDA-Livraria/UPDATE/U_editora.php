<?php
if (!empty($_GET['id'])) {
    include_once('../Config.php');
    $id = $_GET['id'];

    $sqlSelect = "SELECT * FROM editora WHERE Cod_editora=$id";

    $result = $conexao->query($sqlSelect);

    if ($result->num_rows > 0) {

        while ($user_data = mysqli_fetch_assoc($result)) {
            $nome = $user_data['Nome_editora'];
            $cidade = $user_data['Cidade'];
            $contato = $user_data['Contato'];
        }
    } else {
        header('Location: ./SISTEMA/Editoras.php');
    }
} else {
    header('Location:  ./SISTEMA/Editoras.php');
} 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EDITAR DADOS(EDITORA)</title>
    <link rel="stylesheet" href="../assets/css/Cadastro.css">
</head>
<body>

    <div class="container">
        <div class="form-image">
            <img src="../assets/img/Editora.svg" width="" height="">
        </div>
        <div class="form">
            <form action="Save_editora.php" method="POST">
                <div class="form-register">
                    <div class="title">
                        <h1>Editar Dados (Editora)</h1>
                    </div>
                    <div class="voltar-button">
                        <button><a href="../SISTEMA/Editoras.php">Voltar</a></button>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-box">
                        <label for="nome">Nome</label>
                        <input id="nome" type="text" name="nome" placeholder="Digite seu primeiro nome" value="<?php echo $nome ?>" required>
                    </div>
                    
                    <div class="input-box">
                        <label for="cidade">Cidade</label>
                        <input id="cidade" type="text" name="cidade" placeholder="Digite sua cidade" value="<?php echo $cidade ?>" required>
                    </div>
                    <div class="input-box">
                        <label for="contato">Contato</label>
                        <input id="contato" type="text" name="contato" placeholder="Digite sua contato" value="<?php echo $contato ?>" required>
                    </div>
                </div>
                <div class="continue-button">
                <input id="nome" type="hidden" name="nome_original" value="<?php echo $nome ?>"required>
                    <input type="hidden" name="id" value=<?php echo $id; ?>>
                    <input name="update" type="submit" value="Salvar">
                </div>
            </form>
        </div>
    </div>
</body>

</html>