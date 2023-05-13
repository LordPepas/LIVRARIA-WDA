<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>;
</head>
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
        $livro = $_POST['livro'];
        $cliente = $_POST['cliente'];
        $data_aluguel = $_POST['data_aluguel'];
        $data_previsão = $_POST['data_previsão'];
        $quantidade_alugada = 1;

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
                        echo "<script type='text/javascript'>Swal.fire('Excelente!','Aluguel adicionado com sucesso!','success').then(() => {window.location.href = '../SISTEMA/Aluguel.php';});</script>";
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CADASTRO ALUGUEL</title>
    <link rel="stylesheet" href="../assets/css/Cadastro.css">
    <style>
        /* Cadastro ALUGUEL */

        /* Define o estilo da div que contém o label e o select */
        .select {
            display: flex;
            flex-direction: column;
            margin-bottom: 18px;
            margin-left: 10px;
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
            <img src="../assets/img/Aluguel.svg" width="" height="">
        </div>
        <div class="form">
            <form action="C_aluguel.php" method="POST">
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
                        <div class="select">
                            <label for="livro">Livro</label>
                            <select class="select" name="livro">
                                <option disabled selected>Selecioneㅤㅤㅤㅤㅤㅤㅤ</option>
                                <?php
                                include_once('../Config.php');
                                $sql = "SELECT * FROM livro ORDER BY Cod_livro";
                                $res = mysqli_query($conexao, $sql);
                                while ($user_livro = mysqli_fetch_row($res)) {
                                    $cod_livro = $user_livro[0];
                                    $livros = $user_livro[1];

                                    echo "<option class='livro' value='$cod_livro'>$livros</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="input-box">
                        <div class="select">
                            <label for="Cliente">Cliente</label>
                            <select class="select" name="cliente">
                                <option disabled selected>Selecioneㅤㅤㅤㅤㅤㅤㅤ</option>
                                <?php
                                include_once('../Config.php');
                                $sql = "SELECT * FROM usuario ORDER BY Cod_usuario";
                                $res = mysqli_query($conexao, $sql);
                                while ($user_user = mysqli_fetch_row($res)) {
                                    $Cod_livro = $user_user[0];
                                    $usuários = $user_user[1];

                                    echo "<option class='livro' value='$Cod_livro'>$usuários</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>


                    <div class="input-box">
                        <label for="data_aluguel">Data de Aluguel</label>
                        <input id="data_aluguel" type="date" name="data_aluguel" required>
                    </div>

                    <div class="input-box">
                        <label for="data_previsão">Provisão de Devolução</label>
                        <input id="data_previsão" type="date" name="data_previsão" required>
                    </div>

                    <div class="input-box">
                        <input id="quantidade" type="hidden" name="quantidadeL" min="1" max="10" required>
                    </div>

                </div>
                <div class="continue-button">
                    <input name="submit" type="submit" value="Cadastrar">
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>