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
        exit(); // Adicionado para evitar que o código continue a ser executado

    }
} else {
    header('Location:  ../Livros.php');
    exit(); // Adicionado para evitar que o código continue a ser executado

}
?>
<script>
    function validarCampo(titulo) {
        var mensagemerro1 = document.getElementById('mensagemerro1');
        if (titulo.value.trim() === '') {
            // se o valor do campo estiver vazio, invalide o campo
            titulo.classList.add('campo-invalido');
            // titulo.classList.add('erro');
            mensagemerro1.style.display = 'block';
        } else {
            // senão, remova o campo inválido.
            titulo.classList.remove('campo-invalido');
            mensagemerro1.style.display = 'none';
        }
    }



    function validarCampo2(editora) {
        var mensagemerro2 = document.getElementById('mensagemerro2');

        if (isNaN(editora.value)) {
            // se o valor do campo estiver vazio, invalide o campo
            editora.classList.add('campo-invalido');
            // editora.classList.add('erro');
            mensagemerro2.style.display = 'block';
        } else {
            // senão, remova o campo inválido.
            editora.classList.remove('campo-invalido');
            mensagemerro2.style.display = 'none';
        }

    }

    function validarCampo3(autor) {
        var mensagemerro3 = document.getElementById('mensagemerro3');

        if (autor.value.trim() === '') {
            // se o valor do campo estiver vazio, invalide o campo
            autor.classList.add('campo-invalido');
            // autor.classList.add('erro');
            mensagemerro3.style.display = 'block';
        } else {
            // senão, remova o campo inválido.
            autor.classList.remove('campo-invalido');
            mensagemerro3.style.display = 'none';
        }
    }

    function validarCampo4(lançamento) {
        var mensagemerro4 = document.getElementById('mensagemerro4');

        if (lançamento.value.trim() === '') {
            // se o valor do campo estiver vazio, invalide o campo
            lançamento.classList.add('campo-invalido');
            // lançamento.classList.add('erro');
            mensagemerro4.style.display = 'block';
        } else {
            // senão, remova o campo inválido.
            lançamento.classList.remove('campo-invalido');
            mensagemerro4.style.display = 'none';
        }

    }

    function validarCampo5(quantidade) {
        var mensagemerro5 = document.getElementById('mensagemerro5');

        if (quantidade.value.trim() === '') {
            // se o valor do campo estiver vazio, invalide o campo
            quantidade.classList.add('campo-invalido');
            // quantidade.classList.add('erro');
            mensagemerro5.style.display = 'block';
        } else {
            // senão, remova o campo inválido.
            quantidade.classList.remove('campo-invalido');
            mensagemerro5.style.display = 'none';
        }

    }
</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EDITAR DADOS(LIVRO)</title>
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

        .mensagemerro1 {
            display: none;

        }

        .mensagemerro2 {
            display: none;

        }

        .mensagemerro3 {
            display: none;

        }

        .mensagemerro4 {
            display: none;

        }

        .mensagemerro5 {
            display: none;

        }


        span {
            font-size: 14px;
            color: red;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="form-image">
            <img src="../assets/img/Livro.svg" width="" height="">
        </div>
        <div class="form">
            <form action="./Save_livro.php" method="POST" onsubmit="return validarInput()">
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
                        <input id="titulo" type="text" name="titulo" placeholder="Digite o Titulo" value="<?php echo $titulo ?>" onblur="validarCampo(this)">
                        <span id="mensagemerro1" class="mensagemerro1">* Este campo é obrigatório</span>
                        <span id="titulo_error" class="field-error"></span>
                    </div>

                    <div class="input-box">
                        <div class="select_editora">
                            <label for="select_editora">Editora</label>
                            <select class="select_editora" name="select_editora" id="select_editora" onblur="validarCampo2(this)">
                                <option disabled selected>Selecione</option>
                                <?php
                                include_once('../Config.php');
                                $sql = "SELECT * FROM editora ORDER BY Cod_editora";
                                $res = mysqli_query($conexao, $sql);
                                while ($user_livro = mysqli_fetch_row($res)) {
                                    $cod_livro = $user_livro[0];
                                    $nome_livro = $user_livro[1];
                                    echo "<option class='editora' value='$cod_livro'" . ($cod_livro == $editora ? " selected" : "") . ">$nome_livro</option>";
                                }
                                ?>
                            </select>
                            <span id="mensagemerro2" class="mensagemerro2">* Este campo é obrigatório</span>
                            <span id="editora_error" class="field-error"></span>
                        </div>
                    </div>

                    <div class="input-box">
                        <label for="autor">Autor</label>
                        <input id="autor" type="text" name="autor" placeholder="Digite o nome do autor " value="<?php echo $autor ?>" onblur="validarCampo3(this)">
                        <span id="mensagemerro3" class="mensagemerro3">* Este campo é obrigatório</span>
                        <span id="autor_error" class="field-error"></span>
                    </div>

                    <div class="input-box">
                        <label for="lançamento">Ano de lançamento</label>
                        <input id="lançamento" type="number" max="2023" name="lançamento" placeholder="XXXX" value="<?php echo $lançamento ?>" onblur="validarCampo4(this)">
                        <span id="mensagemerro4" class="mensagemerro4">* Este campo é obrigatório</span>
                        <span id="lançamento_error" class="field-error"></span>
                    </div>

                    <div class="input-box">
                        <label for="quantidade">Quantidade</label>
                        <input id="quantidade" type="number" name="quantidade" placeholder="digite a quantidade" value="<?php echo $quantidade ?>" onblur="validarCampo5(this)">
                        <span id="mensagemerro5" class="mensagemerro5">* Este campo é obrigatório</span>
                        <span id="quantidade_error" class="field-error"></span>
                    </div>
                </div>

                <div class="continue-button">
                    <h3 id="error-message" class="error-message"></h3>
                    <input type="hidden" name="id" value=<?php echo $id; ?>>
                    <input type="hidden" name="titulo_original" value="<?php echo $titulo; ?>">
                    <input name="update" type="submit" value="Salvar">
                </div>
            </form>
        </div>
    </div>
    <script>
        function validarInput() {
            var titulo = document.getElementById('titulo');
            var editora = document.getElementById('select_editora');
            var autor = document.getElementById('autor');
            var lancamento = document.getElementById('lançamento');
            var quantidade = document.getElementById('quantidade');
            var errorMessage = document.getElementById('error-message');

            var errors = 0;

            if (titulo.value.trim() === '') {
                titulo.classList.add('error');
                displayError('titulo_error', 'Por favor, preencha o tirulo.');
                errors++;
            } else {
                titulo.classList.remove('error');
                document.getElementById('titulo_error').textContent = '';
            }

            if (editora.value.trim() === '') {
                editora.classList.add('error');
                displayError('editora_error', 'Por favor, preencha a editora.');
                errors++;
            } else {
                editora.classList.remove('error');
                document.getElementById('editora_error').textContent = '';
            }

            if (autor.value.trim() === '') {
                autor.classList.add('error');
                displayError('autor_error', 'Por favor, preencha o autor.');
                errors++;
            } else {
                autor.classList.remove('error');
                document.getElementById('autor_error').textContent = '';
            }

            if (lançamento.value.trim() === '') {
                lançamento.classList.add('error');
                displayError('lançamento_error', 'Por favor, preencha o lançamento.');
                errors++;
            } else {
                lançamento.classList.remove('error');
                document.getElementById('lançamento_error').textContent = '';

            }

            if (quantidade.value.trim() === '') {
                quantidade.classList.add('error');
                displayError('quantidade_error', 'Por favor, preencha a quantidade.');
                errors++;
            } else {
                quantidade.classList.remove('error');
                document.getElementById('quantidade_error').textContent = '';
            }

            if (errors > 0) {
                errorMessage.textContent = 'Por favor, corrija os erros no formulário.';
                return false;
            }
        }

        function displayError(errorId, errorMessage) {
            document.getElementById(errorId).textContent = errorMessage;
        }
    </script>
</body>

</html>