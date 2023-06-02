<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php
    if (isset($_POST['submit'])) {
        include_once('../Config.php'); // inclui o arquivo de configuração do banco de dados

        $titulo = $_POST['titulo'];

        if (!empty($_POST['select_editora'])) {
            $editora =  $_POST['select_editora'];
        } else {
            $editora = '';
        }
        $autor = $_POST['autor'];
        $lançamento = $_POST['lançamento'];
        $quantidade = $_POST['quantidade'];
    }
    if (!empty($titulo) && !empty($editora) && !empty($autor) && !empty($lançamento) && !empty($quantidade)) { // verifica se o formulário foi submetido
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
    <script>
        function validarCampo(titulo) {
            var mensagemerro1 = document.getElementById('mensagemerro1');
            if (titulo.value.trim() === '') {
                // se o valor do campo estiver vazio, invalide o campo
                titulo.classList.add('campo-invalido');
                //  titulo.classList.add('erro');
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
                //  editora.classList.add('erro');
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
                //  autor.classList.add('erro');
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
                //  lançamento.classList.add('erro');
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
                //  quantidade.classList.add('erro');
                mensagemerro5.style.display = 'block';
            } else {
                // senão, remova o campo inválido. 
                quantidade.classList.remove('campo-invalido');
                mensagemerro5.style.display = 'none';
            }

        }
    </script>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CADASTRO LIVRO</title>
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
            <form action="C_livro.php" method="POST" onsubmit="return validarInput()">
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
                        <input id="titulo" type="text" name="titulo" placeholder="Digite o Titulo" onblur="validarCampo(this)">
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
                                    echo "<option name ='editora' value='$cod_livro'>$nome_livro</option>";
                                }
                                ?>
                            </select>
                            <span id="mensagemerro2" class="mensagemerro2">* Este campo é obrigatório</span>
                            <span id="editora_error" class="field-error"></span>
                        </div>
                    </div>

                    <div class="input-box">
                        <label for="autor">Autor</label>
                        <input id="autor" type="text" name="autor" placeholder="Digite o nome do autor" onblur="validarCampo3(this)">
                        <span id="mensagemerro3" class="mensagemerro3">* Este campo é obrigatório</span>

                        <span id="autor_error" class="field-error"></span>
                    </div>

                    <div class="input-box">
                        <label for="lançamento">Ano de lançamento</label>
                        <input id="lançamento" type="number" max="2023" name="lançamento" placeholder="XXXX" onblur="validarCampo4(this)">
                        <span id="mensagemerro4" class="mensagemerro4">* Este campo é obrigatório</span>

                        <span id="lançamento_error" class="field-error"></span>
                    </div>

                    <div class="input-box">
                        <label for="quantidade">Quantidade de livros</label>
                        <input id="quantidade" type="number" name="quantidade" placeholder="Digite o estoque" onblur="validarCampo5(this)">
                        <span id="mensagemerro5" class="mensagemerro5">* Este campo é obrigatório</span>
                        <span id="quantidade_error" class="field-error"></span>
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
        function validarInput() {
            var titulo = document.getElementById("titulo");
            var editora = document.getElementById("select_editora");
            var autor = document.getElementById("autor");
            var quantidade = document.getElementById("quantidade");
            var lançamento = document.getElementById("lançamento");
            var errorMessage = document.getElementById("error-message");

            var errors = 0;

            if (titulo.value === "") {
                titulo.classList.add("error");
                document.getElementById("titulo_error").textContent = "Por favor, preencha o título.";
                errors++;
            } else {
                titulo.classList.remove("error");
                document.getElementById("titulo_error").textContent = "";
            }

            if (isNaN(editora.value)) {
                editora.classList.add("error");
                document.getElementById("editora_error").textContent = "Por favor, selecione uma editora.";
                errors++;
            } else {
                editora.classList.remove("error");
                document.getElementById("editora_error").textContent = "";
            }

            if (autor.value === "") {
                autor.classList.add("error");
                document.getElementById("autor_error").textContent = "Por favor, preencha o autor.";
                errors++;
            } else {
                autor.classList.remove("error");
                document.getElementById("autor_error").textContent = "";
            }

            if (lançamento.value === "") {
                lançamento.classList.add("error");
                document.getElementById("lançamento_error").textContent = "Por favor, preencha o ano de lançamento.";
                errors++;
            } else {
                lançamento.classList.remove("error");
                document.getElementById("lançamento_error").textContent = "";
            }

            if (quantidade.value === "") {
                quantidade.classList.add("error");
                document.getElementById("quantidade_error").textContent = "Por favor, preencha a quantidade de livros.";
                errors++;
            } else {
                quantidade.classList.remove("error");
                document.getElementById("quantidade_error").textContent = "";
            }

            if (errors > 0) {
                errorMessage.textContent = "Por favor, corrija os erros no formulário.";
                return false;
            }
        }
    </script>
</body>

</html>