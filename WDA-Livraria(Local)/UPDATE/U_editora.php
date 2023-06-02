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
<script>
    function validarCampo(nome) {
        var mensagemerro1 = document.getElementById('mensagemerro1');
        if (nome.value.trim() === '') {
            // se o valor do campo estiver vazio, invalide o campo
            nome.classList.add('campo-invalido');
            mensagemerro1.style.display = 'block';
        } else {
            // senão, remova o campo inválido. 
            nome.classList.remove('campo-invalido');
            mensagemerro1.style.display = 'none';
        }
    }

    function validarCampo2(cidade) {
        var mensagemerro2 = document.getElementById('mensagemerro2');

        if (cidade.value.trim() === '') {
            // se o valor do campo estiver vazio, invalide o campo
            cidade.classList.add('campo-invalido');
            mensagemerro2.style.display = 'block';
        } else {
            // senão, remova o campo inválido. 
            cidade.classList.remove('campo-invalido');
            mensagemerro2.style.display = 'none';
        }
    }

    function validarCampo3(contato) {
        var mensagemerro3 = document.getElementById('mensagemerro3');

        if (contato.value.trim() === '') {
            // se o valor do campo estiver vazio, invalide o campo
            contato.classList.add('campo-invalido');
            mensagemerro3.style.display = 'block';
        } else {
            // senão, remova o campo inválido. 
            contato.classList.remove('campo-invalido');
            mensagemerro3.style.display = 'none';
        }
    }
</script>
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
            <img src="../assets/img/Livro.svg" width="" height="">
        </div>
        <div class="form">
            <form action="Save_editora.php" method="POST" onsubmit="return validarInput()">
                <div class="form-register">
                    <div class="title">
                        <h1>Editar Dados (Livro)</h1>
                    </div>
                    <div class="voltar-button">
                        <button><a href="../SISTEMA/Editoras.php">Voltar</a></button>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-box">
                        <label for="nome">Nome</label>
                        <input id="nome" type="text" name="nome" placeholder="Digite o título do livro" value="<?php echo $nome ?>" onblur="validarCampo(this)">
                        <p id="nome_error" class="field-error"></p>
                        <span id="mensagemerro1" class="mensagemerro1">* Este campo é obrigatório</span>
                    </div>
                    <div class="input-box">
                        <label for="cidade">Cidade</label>
                        <input id="cidade" type="text" name="cidade" placeholder="Digite o cidade do livro" value="<?php echo $cidade ?>" onblur="validarCampo2(this)">
                        <p id="cidade_error" class="field-error"></p>
                        <span id="mensagemerro2" class="mensagemerro2">* Este campo é obrigatório</span>
                    </div>
                    <div class="input-box">
                        <label for="contato">Contato</label>
                        <input id="contato" type="text" name="contato" placeholder="Digite a contato do livro" value="<?php echo $contato ?>" onblur="validarCampo3(this)">
                        <p id="contato_error" class="field-error"></p>
                        <span id="mensagemerro3" class="mensagemerro3">* Este campo é obrigatório</span>
                    </div>
                </div>
                <div class="continue-button">
                    <h3 id="error-message" class="error-message"></h3>
                    <input id="titulo" type="hidden" name="nome_original" value="<?php echo $nome ?>">
                    <input type="hidden" name="id" value=<?php echo $id; ?>>
                    <input name="update" type="submit" value="Salvar">
                </div>
            </form>
        </div>
    </div>
    <script>
        function validarInput() {
            var nome = document.getElementById('nome');
            var cidade = document.getElementById('cidade');
            var contato = document.getElementById('contato');
            var errorMessage = document.getElementById('error-message');

            var errors = 0;

            if (nome.value.trim() === '') {
                nome.classList.add('error');
                displayError('nome_error', 'Por favor, preencha o nome.');
                errors++;
            } else {
                nome.classList.remove('error');
                document.getElementById('nome_error').textContent = '';
            }

            if (cidade.value.trim() === '') {
                cidade.classList.add('error');
                displayError('cidade_error', 'Por favor, preencha o cidade.');
                errors++;
            } else {
                cidade.classList.remove('error');
                document.getElementById('cidade_error').textContent = '';
            }

            if (contato.value.trim() === '') {
                contato.classList.add('error');
                displayError('contato_error', 'Por favor, preencha a contato.');
                errors++;
            } else {
                contato.classList.remove('error');
                document.getElementById('contato_error').textContent = '';
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