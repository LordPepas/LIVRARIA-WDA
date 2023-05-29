<head>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

<body>

    <?php
    if (isset($_POST['submit'])) {
        include_once('../Config.php');
        //Período máximo de aluguel
        $entrada = new DateTime($_POST['data_aluguel']);
        $saida = new DateTime($_POST['data_previsão']);
        $intervalo = $entrada->diff($saida);
        $dias = $intervalo->format('%a');

        // Verifica se a data de entrada é maior que a data de saída
        if ($entrada > $saida) {
            echo "<script type='text/javascript'>Swal.fire('Ops!', 'A data de aluguel não pode ser superior à data de devolução.', 'error')</script>";
            // Verifica se o aluguel excede 30 dias
        } elseif ($dias >= 30) {
            echo "<script type='text/javascript'>Swal.fire('Ops!', 'Devido às políticas da empresa, o aluguel não pode exceder 30 dias.', 'error')</script>";
        } else {
            // Obtém os dados de entrada do formulário
            if (!empty($_POST['livro'])) {
                $livro = $_POST['livro'];
            } else {
                $livro = '';
            }
            if (!empty($_POST['cliente'])) {
                $cliente = $_POST['cliente'];
            } else {
                $cliente = '';
            }
            $data_aluguel = $_POST['data_aluguel'];
            $data_previsão = $_POST['data_previsão'];
            $quantidade_alugada = 1;


            if (!empty($livro) && !empty($cliente) && !empty($data_aluguel) && !empty($data_previsão)) {

                // Verifica se o usuário já tem um livro em atraso
                $sql = "SELECT * FROM aluguel WHERE Usuário = '$cliente' AND Data_previsão < CURDATE()";
                $result = $conexao->query($sql);
                mysqli_query($conexao, "ALTER TABLE dblocadora.aluguel AUTO_INCREMENT = 1;");
                if ($result && $result->num_rows > 0) {
                    echo "<script type='text/javascript'>Swal.fire('Ops!', 'Você já tem um livro em atraso e não pode alugar outro.', 'error')</script>";
                } else {
                    // Continua com a operação de aluguel normalmente
                    $sql = "SELECT * FROM livro WHERE Cod_livro = '$livro' ORDER BY Cod_livro DESC";
                    $result = $conexao->query($sql);
                    // Obtém a quantidade total de livros disponíveis
                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $quantidade_total = $row['Quantidade'];
                        // Verifica se a quantidade solicitada está disponível
                        if ($quantidade_total >= $quantidade_alugada) {
                            $disponivel = ($quantidade_total - $quantidade_alugada);
                            $result_livro = mysqli_query($conexao, "UPDATE livro SET Quantidade = $disponivel WHERE Cod_livro = '$livro'");
                            $result_aluguel = mysqli_query($conexao, "INSERT INTO aluguel (Livro, Usuário, Data_aluguel, Data_previsão, Quantidade_alugada) VALUES ('$livro','$cliente','$data_aluguel','$data_previsão','$quantidade_alugada')");
                            if ($result_livro && $result_aluguel) {
                                echo "<script type='text/javascript'>Swal.fire('Excelente!','Aluguel adicionado com sucesso!','success').then(() => {window.location.href = '../SISTEMA/Aluguel.php'})</script>";
                            } else {
                                echo "<script type='text/javascript'>Swal.fire('Ops!', 'Erro ao cadastrar aluguel: " . mysqli_error($conexao) . "', 'error')</script>";
                            }
                        } else {
                            echo "<script type='text/javascript'>Swal.fire('Ops!', 'Quantidade de livros insuficiente', 'error')</script>"; //
                        }
                    } else {
                        echo "<script type='text/javascript'>Swal.fire('Ops!', 'Livro não encontrado', 'error')</script>"; // exibe a mensagem de erro
                    }
                }
            }
        }
    }
    ?>
    <script>
        function validarCampo(livro) {
            var mensagemerro = document.getElementById('mensagemerro1');

            if (isNaN(livro.value)) {
                // se o valor do campo estiver vazio, invalide o campo
                livro.classList.add('campo-invalido');
                mensagemerro.style.display = 'block';
            } else {
                // senão, remova o campo inválido. 
                livro.classList.remove('campo-invalido');
                mensagemerro.style.display = 'none';
            }

        }

        function validarCampo2(cliente) {
            var mensagemerro2 = document.getElementById('mensagemerro2');

            if (isNaN(cliente.value)) {
                // se o valor do campo estiver vazio, invalide o campo
                cliente.classList.add('campo-invalido');
                mensagemerro2.style.display = 'block';
            } else {
                // senão, remova o campo inválido. 
                cliente.classList.remove('campo-invalido');
                mensagemerro2.style.display = 'none';
            }

        }

        function validarCampo3(data_aluguel) {
            var mensagemerro3 = document.getElementById('data_aluguel_error');

            if (data_aluguel.value === "") {
                mensagemerro3.textContent = 'Por favor, preencha a data de aluguel.';
            } else {
                data_aluguel.classList.remove('error');
                mensagemerro3.textContent = '';
            }
        }

        function validarCampo4(data_previsão) {
            var mensagemerro4 = document.getElementById('data_previsão_error');

            if (data_previsão.value === "") {
                mensagemerro4.textContent = 'Por favor, preencha a data de previsão.';
            } else {
                data_previsão.classList.remove('error');
                mensagemerro4.textContent = '';
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
    <title>CADASTRO ALUGUEL</title>
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

        .select_livro select.error {
            border: 1px solid red;
        }

        .select_cliente select.error {
            border: 1px solid red;
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
            <img src="../assets/img/Aluguel.svg" width="" height="">
        </div>
        <div class="form">
            <form action="C_aluguel.php" method="POST" onsubmit="return validarInput()">
                <div class="form-register">
                    <div class="title">
                        <h1>ADICIONAR ALUGUEL</h1>
                    </div>
                    <div class="voltar-button">
                        <button><a href="../SISTEMA/Aluguel.php">Voltar</a></button>
                    </div>
                </div>
                <div class="input-group">

                    <div class="input-box">
                        <div class="select_livro">
                            <label for="select_livro">Livro</label>
                            <select id="select_livro" name="livro" class="select_livro" onblur="validarCampo(this)">
                                <option disabled selected>Selecione</option>
                                <?php
                                include_once('../Config.php');
                                $sql = "SELECT * FROM livro ORDER BY Cod_livro";
                                $res = mysqli_query($conexao, $sql);
                                while ($user_livro = mysqli_fetch_row($res)) {
                                    $cod_livro = $user_livro[0];
                                    $livros = $user_livro[1];

                                    echo "<option class='livro' name='livro' value='$cod_livro'>$livros</option>";
                                }
                                ?>
                            </select>
                            <span id="select_livro_error" class="field-error"></span>
                            <span id="mensagemerro1" class="mensagemerro1">* Este campo é obrigatório</span>
                        </div>
                    </div>

                    <div class="input-box">
                        <div class="select_cliente">
                            <label for="select_cliente">Cliente</label>
                            <select id="select_cliente" name="cliente" class="select_cliente" onblur="validarCampo2(this)">
                                <option disabled selected>Selecione</option>
                                <?php
                                include_once('../Config.php');
                                $sql = "SELECT * FROM usuario ORDER BY Cod_usuario";
                                $res = mysqli_query($conexao, $sql);
                                while ($user_user = mysqli_fetch_row($res)) {
                                    $Cod_usuario = $user_user[0];
                                    $usuarios = $user_user[1];

                                    echo "<option class='usuario' name='cliente' value='$Cod_usuario'>$usuarios</option>";
                                }
                                ?>
                            </select>
                            <span id="select_cliente_error" class="field-error"></span>
                            <span id="mensagemerro2" class="mensagemerro2">* Este campo é obrigatório</span>
                        </div>
                    </div>


                    <div class="input-box">
                        <label for="data_aluguel">Data de Aluguel</label>
                        <input id="data_aluguel" type="date" name="data_aluguel" onblur="validarCampo3(this)">
                        <span id="data_aluguel_error" class="field-error"></span>
                        <span id="mensagemerro3" class="mensagemerro3">* Este campo é obrigatório</span>
                    </div>

                    <div class="input-box">
                        <label for="data_previsão">Previsão de Devolução</label>
                        <input id="data_previsão" type="date" name="data_previsão" onblur="validarCampo4(this)">
                        <span id="data_previsão_error" class="field-error"></span>
                        <span id="mensagemerro4" class="mensagemerro4">* Este campo é obrigatório</span>
                    </div>

                    <div class="input-box">
                        <input id="quantidade" type="hidden" name="quantidadeL" min="1" max="10">
                    </div>

                </div>
                <div class="continue-button">
                    <h3 id="error-message" class="error-message"></h3>
                    <input name="submit" type="submit" value="Cadastrar">
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function validarInput() {
            var livro = document.getElementById("select_livro");
            var cliente = document.getElementById("select_cliente");
            var data_aluguel = document.getElementById("data_aluguel");
            var data_previsão = document.getElementById("data_previsão");
            var errorMessage = document.getElementById("error-message");

            var errors = 0;

            if (isNaN(livro.value)) {
                livro.classList.add("error");
                document.getElementById("select_livro_error").textContent = "Por favor, selecione um livro.";
                errors++;
            } else {
                livro.classList.remove("error");
                document.getElementById("select_livro_error").textContent = "";
            }

            if (isNaN(cliente.value)) {
                cliente.classList.add("error");
                document.getElementById("select_cliente_error").textContent = "Por favor, selecione um cliente.";
                errors++;
            } else {
                cliente.classList.remove("error");
                document.getElementById("select_cliente_error").textContent = "";
            }

            if (data_aluguel.value.trim() === "") {
                data_aluguel.classList.add("error");
                document.getElementById("data_aluguel_error").textContent = "Por favor, preencha a data de aluguel.";
                errors++;
            } else {
                data_aluguel.classList.remove("error");
                document.getElementById("data_aluguel_error").textContent = "";
            }

            if (data_previsão.value.trim() === "") {
                data_previsão.classList.add("error");
                document.getElementById("data_previsão_error").textContent = "Por favor, preencha a data de previsão.";
                errors++;
            } else {
                data_previsão.classList.remove("error");
                document.getElementById("data_previsão_error").textContent = "";
            }

            if (errors > 0) {
                errorMessage.textContent = "Por favor, corrija os erros no formulário.";
                return false;
            }
        }
    </script>

</body>

</html>