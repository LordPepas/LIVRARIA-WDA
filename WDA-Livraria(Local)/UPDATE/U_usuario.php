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
        header('Location: ../Usuario.php');
        exit(); // Adicionado para evitar que o código continue a ser executado
    }
} else {
    header('Location:  ../Usuario.php');
    exit(); // Adicionado para evitar que o código continue a ser executado
}
$nome_original = $nome;
?>
<script>
    function validarCampo(nome) {
        var mensagemerro1 = document.getElementById('mensagemerro1');
        if (nome.value.trim() === '') {
            // se o valor do campo estiver vazio, invalide o campo
            nome.classList.add('campo-invalido');
            //  nome.classList.add('erro');
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
            //  cidade.classList.add('erro');
            mensagemerro2.style.display = 'block';
        } else {
            // senão, remova o campo inválido. 
            cidade.classList.remove('campo-invalido');
            mensagemerro2.style.display = 'none';
        }

    }

    function validarCampo3(endereco) {
        var mensagemerro3 = document.getElementById('mensagemerro3');

        if (endereco.value.trim() === '') {
            // se o valor do campo estiver vazio, invalide o campo
            endereco.classList.add('campo-invalido');
            //  endereco.classList.add('erro');
            mensagemerro3.style.display = 'block';
        } else {
            // senão, remova o campo inválido. 
            endereco.classList.remove('campo-invalido');
            mensagemerro3.style.display = 'none';
        }

    }

    function validarCampo4(email) {
        var mensagemerro4 = document.getElementById('mensagemerro4');

        if (email.value.trim() === '') {
            // se o valor do campo estiver vazio, invalide o campo
            email.classList.add('campo-invalido');
            //  email.classList.add('erro');
            mensagemerro4.style.display = 'block';
        } else {
            // senão, remova o campo inválido. 
            email.classList.remove('campo-invalido');
            mensagemerro4.style.display = 'none';
        }

    }
</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDITAR DADOS(LIVRO)</title>
    <link rel="stylesheet" href="../assets/css/Cadastro.css?<?php echo rand(1, 1000); ?>">
</head>

<body>

    <div class="container">
        <div class="form-image">
            <img src="../assets/img/Cadastro_cliente.svg">
        </div>
        <div class="form">
            <form action="Save_usuario.php" method="POST" onsubmit="return validarInput()">
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
                        <input id="nome" type="text" name="nome" placeholder="Digite seu primeiro nome" value="<?php echo $nome ?>" onblur="validarCampo(this)">
                        <p id="nome_error" class="field-error"></p>
                        <span id="mensagemerro1" class="mensagemerro1">* Este campo é obrigatório</span>
                    </div>

                    <div class="input-box">
                        <label for="cidade">Cidade</label>
                        <input id="cidade" type="text" name="cidade" placeholder="Digite sua cidade" value="<?php echo $cidade ?>" onblur="validarCampo2(this)">
                        <p id="cidade_error" class="field-error"></p>
                        <span id="mensagemerro2" class="mensagemerro2">* Este campo é obrigatório</span>
                    </div>

                    <div class="input-box">
                        <label for="endereço">Endereço</label>
                        <input id="endereço" type="text" name="endereço" placeholder="Digite seu endereço" value="<?php echo $endereco ?>" onblur="validarCampo3(this)">
                        <p id="endereço_error" class="field-error"></p>
                        <span id="mensagemerro3" class="mensagemerro3">* Este campo é obrigatório</span>
                    </div>

                    <div class="input-box">
                        <label for="email">E-mail</label>
                        <input id="email" type="email" name="email" placeholder="Digite seu e-mail" value="<?php echo $email ?>" onblur="validarCampo4(this)">
                        <p id="email_error" class="field-error"></p>
                        <span id="mensagemerro4" class="mensagemerro4">* Este campo é obrigatório</span>
                    </div>
                </div>
                <div class="continue-button">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input id="nome_original" type="hidden" name="nome_original" value="<?php echo $nome_original ?>">
                    <h3 id="error-message" class="error-message"></h3>
                    <input name="update" type="submit" value="Salvar">
                </div>
            </form>
        </div>
    </div>
    <script>
        function validarInput() {
            var nome = document.getElementById('nome');
            var cidade = document.getElementById('cidade');
            var endereço = document.getElementById('endereço');
            var email = document.getElementById('email');
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
                displayError('cidade_error', 'Por favor, preencha a cidade.');
                errors++;
            } else {
                cidade.classList.remove('error');
                document.getElementById('cidade_error').textContent = '';
            }

            if (endereço.value.trim() === '') {
                endereço.classList.add('error');
                displayError('endereço_error', 'Por favor, preencha o endereço.');
                errors++;
            } else {
                endereço.classList.remove('error');
                document.getElementById('endereço_error').textContent = '';
            }

            if (email.value.trim() === '') {
                email.classList.add('error');
                displayError('email_error', 'Por favor, preencha o e-mail.');
                errors++;
            } else {
                email.classList.remove('error');
                document.getElementById('email_error').textContent = '';
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