<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    
    
<?php
if (isset($_POST['submit'])) { // verifica se o formulário foi submetido
    include_once('../Config.php'); // inclui o arquivo de configuração do banco de dados

    $nome = $_POST['nome'];
    $cidade = $_POST['cidade'];
    $contato = $_POST['contato'];
    
    if (!empty($nome) && !empty($cidade) && !empty($contato)) {
        $sqcliente = "SELECT * FROM editora WHERE Nome_editora ='$nome'"; // consulta para verificar se o usuário já existe
        
        $resultado = $conexao->query($sqcliente); // executa a consulta
        mysqli_query($conexao, "ALTER TABLE dblocadora.editora AUTO_INCREMENT = 1;");
        
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
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CADASTRO EDITORA</title>
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
        span {
            font-size: 14px;
            color: red;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="form-image">
            <img src="../assets/img/Editora.svg" width="" height="" alt="Imagem da editora">
        </div>
        <div class="form">
            <form action="./C_editora.php" method="POST" onsubmit="return validarInput()">
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
                        <input id="nome" type="text" name="nome" placeholder="Digite o nome da editora" onblur="validarCampo(this)">
                        <p id="nome_error" class="field-error"></p>
                        <span id="mensagemerro1" class="mensagemerro1">* Este campo é obrigatório</span>
                    </div>

                    <div class="input-box">
                        <label for="username">Cidade</label>
                        <input id="cidade" type="text" name="cidade" placeholder="Digite a cidade" onblur="validarCampo2(this)">
                        <p id="cidade_error" class="field-error"></p>
                        <span id="mensagemerro2" class="mensagemerro2">* Este campo é obrigatório</span>
                    </div>

                    <div class="input-box">
                        <label for="contato">Contato</label>
                        <input id="contato" type="text" name="contato" placeholder="Digite seu contato" onblur="validarCampo3(this)">
                        <p id="contato_error" class="field-error"></p>
                        <span id="mensagemerro3" class="mensagemerro3">* Este campo é obrigatório</span>
                    </div>
                </div>

                <div class="continue-button">
                    <h3 id="error-message" class="error-message"></h3>
                    <input name="submit" type="submit" value="Cadastrar">
                </div>
            </form>
        </div>
    </div>
    <script>
        function displayError(errorId, errorMessage) {
            document.getElementById(errorId).textContent = errorMessage;
        }

        function validarInput() {
            var nome = document.getElementById("nome");
            var cidade = document.getElementById("cidade");
            var contato = document.getElementById("contato");
            var errorMessage = document.getElementById("error-message");

            var errors = 0;

            if (nome.value === "") {
                nome.classList.add("error");
                displayError("nome_error", "Por favor, preencha o nome.");
                errors++;
            } else {
                nome.classList.remove("error");
                document.getElementById("nome_error").textContent = "";
            }

            if (cidade.value === "") {
                cidade.classList.add("error");
                displayError("cidade_error", "Por favor, preencha a cidade.");
                errors++;
            } else {
                cidade.classList.remove("error");
                document.getElementById("cidade_error").textContent = "";
            }

            if (contato.value === "") {
                contato.classList.add("error");
                displayError("contato_error", "Por favor, preencha o contato.");
                errors++;
            } else {
                contato.classList.remove("error");
                document.getElementById("contato_error").textContent = "";
            }
            if (errors > 0) {
                errorMessage.textContent = "Por favor, corrija os erros no formulário.";
                return false;
            }
        }
    </script>

</body>

</html>