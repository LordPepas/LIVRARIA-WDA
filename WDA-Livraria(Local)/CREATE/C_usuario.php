<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>;
</head>
<?php
if (isset($_POST['submit'])) { // verifica se o formulário foi submetido
    include_once('../Config.php'); // inclui o arquivo de configuração do banco de dados

    $nome = $_POST['nome'];
    $cidade = $_POST['cidade'];
    $endereço = $_POST['endereço'];
    $email = $_POST['email'];

    $sqlcliente = "SELECT * FROM usuario WHERE Nome_usuario ='$nome'"; // consulta para verificar se o usuário já existe

    $resultado = $conexao->query($sqlcliente); // executa a consulta
    mysqli_query($conexao, "ALTER TABLE dblocadora.usuario AUTO_INCREMENT = 1;");

    if (mysqli_num_rows($resultado) == 1) { // verifica se encontrou algum registro
        $mensagem = 'Usuário já existe'; // define a mensagem de erro
    } else {
        $result = mysqli_query($conexao, "INSERT INTO usuario (Nome_usuario,Cidade,Endereço,Email)
        VALUES ('$nome','$cidade','$endereço','$email')"); // insere o novo usuário no banco de dados
        if (!$result) { // verifica se ocorreu algum erro ao inserir o registro
            $mensagem = "Erro ao cadastrar usuário: " . mysqli_error($conexao); // define a mensagem de erro
        } else {
            echo "<script type='text/javascript'>Swal.fire('Excelente!','Aluguel adicionado com sucesso!','success').then(() => {window.location.href = '../SISTEMA/Usuarios.php';})</script>";
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
    <title>CADASTRO USUÁRIO</title>
    <!-- <link rel="stylesheet" href="../assets/css/Cadastro.css"> -->
    <style>
        /* Importa as fontes do Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500&family=Open+Sans:wght@300;400;500;600&display=swap');

/* Define que todos os elementos devem ter padding e margin zerados, a caixa deve ser de borda, e a fonte é 'Inter', sans-serif */
* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: 'Inter', sans-serif;
}

/* Define o fundo do corpo da página, centraliza e alinha verticalmente os elementos */
body {
    /* A largura total disponível na tela */
    width: 100vw;
    /* A altura total disponível na tela */
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgb(181, 181, 248);
}

/* Define o estilo do botão 'Voltar' */
.voltar-button {
    display: flex;
    align-items: center;
}

.voltar-button button {
    border: none;
    background-color: rgb(108, 99, 255);
    padding: 6px 16px;
    border-radius: 5px;
    cursor: pointer;
}

.voltar-button button:hover {
    background-color: rgba(107, 99, 255, 0.945);
}

.voltar-button button a {
    text-decoration: none;
    font-weight: 500;
    color: rgb(255, 255, 255);
}

/* Define o estilo do container do formulário */
.container {
    /* A largura total disponível na tela */
    width: 80vw;
    /* A altura total disponível na tela */
    height: 80vh;
    display: flex;
    box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.212);
}

/* Define o estilo da imagem do formulário */
.form-image {
    width: 55%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgb(240, 220, 180);
    padding: 16px;
}

.form-image img {
    width: 496px;
}

/* Define o estilo do formulário de registro */
.form {
    width: 50%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: rgb(255, 255, 255);
    padding: 48px;
}

/* Define o estilo do título do formulário */
.form-register {
    margin-bottom: 48px;
    display: flex;
    justify-content: space-between;
}


.form-register h1::after {
    content: '';
    display: block;
    width: 80px;
    height: 5px;
    background-color: rgb(108, 99, 255);
    margin: 0 auto;
    position: absolute;
    border-radius: 10px;
}

/* Define o estilo dos grupos de entrada de dados */
.input-group {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: 16px 0;
}

/* Define o estilo de cada entrada de dados */
.input-box {
    margin-left: 5px;
    display: flex;
    flex-direction: column;
    margin-bottom: 18px;
}

/* Define o estilo do campo de entrada de dados */
.input-box input {
    margin: 10px 0;
    padding: 13px 19px;
    border: none;
    border-radius: 10px;
    box-shadow: 1px 1px 6px #0000001c;
    font-size: 13px;
}

/* Define o estilo do efeito de hover sobre o campo de entrada de dados */
.input-box input:hover {
    background-color: rgba(238, 238, 238, 0.459);
}

/* Define o estilo do foco visível no campo de entrada de dados */
.input-box input:focus-visible {
    outline: 1px solid rgb(108, 99, 255);
}

/* Define o estilo da label associada ao campo de entrada de dados */
.input-box label {
    font-size: 12px;
    /* É utilizada para definir a espessura da fonte  */
    font-weight: 600;
    color: rgb(0, 0, 0, 0.753);
}

/* Define o estilo do placeholder do campo de entrada de dados */
.input-box input::placeholder {
    color: rgb(0, 0, 0, 0.745);
}

/* Define o estilo do botão "Continuar" */
.continue-button input {
    width: 100%;
    margin-top: 40px;
    border: none;
    background-color: rgb(108, 99, 255);
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
}

/* Define o estilo do efeito de hover sobre o botão "Continuar"*/
.continue-button input:hover {
    background-color: rgba(107, 99, 255, 0.945);
}

/* Define o estilo do texto dentro do botão "Continuar" */
.continue-button input a {
    text-decoration: none;
    font-size: 15px;
    /*  É utilizada para definir a espessura da fonte  */
    font-weight: 500;
    color: rgb(255, 255, 255);
}


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
@media screen and (max-width: 1330px) {
    .form-image {
        display: none;
    }
    .container {
        width: 50%;
    }
    .form {
        width: 100%;
    }
}

@media screen and (max-width: 1064px) {
    .container {
        width: 90%;
        height: auto;
    }
    .input-group {
        flex-direction: column;
        z-index: 5;
        padding-right: 5rem;
        max-height: 10rem;
        overflow-y: scroll;
        flex-wrap: nowrap;
    }
}
    </style>
</head>

<body>

    <div class="container">
        <div class="form-image">
            <img src="../assets/img/Cadastro_cliente.svg" width="" height="">
        </div>
        <div class="form">
            <form action="C_usuario.php" method="POST">
                <div class="form-register">
                    <div class="title">
                        <h1>ADICIONAR CLIENTE</h1>
                    </div>
                    <div class="voltar-button">
                        <button><a href="../SISTEMA/Usuarios.php">Voltar</a></button>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-box">
                        <label for="nome">Nome</label>
                        <input id="nome" type="text" name="nome" placeholder="Digite seu nome" required>
                    </div>

                    <div class="input-box">
                        <label for="username">Cidade</label>
                        <input id="cidade" type="text" name="cidade" placeholder="Digite sua cidade " required>
                    </div>


                    <div class="input-box">
                        <label for="endereço">Endereço</label>
                        <input id="endereço" type="text" name="endereço" placeholder="Digite seu Endereço" required>
                    </div>

                    <div class="input-box">
                        <label for="email">E-mail</label>
                        <input id="email" type="email" name="email" placeholder="Digite seu e-mail" required>
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