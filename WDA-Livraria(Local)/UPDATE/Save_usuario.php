<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php

    include_once("../Config.php");

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $nome_original = $_POST['nome_original'];
        $cidade = $_POST['cidade'];
        $endereço = $_POST['endereço'];
        $email = $_POST['email'];

    }
    if (!empty($nome) && !empty($cidade) && !empty($endereço) && !empty($email)) {
        if ($nome != $nome_original) {
            $sqcliente = "SELECT * FROM usuario WHERE Nome_usuario ='$nome'"; // consulta para verificar se o usuário já existe
            $resultado = $conexao->query($sqcliente); // executa a consulta

            if (mysqli_num_rows($resultado) >= 1) { // verifica se encontrou algum registro
                echo "<script type='text/javascript'>Swal.fire('Ops!', 'Cliente ja existe!', 'error').then(() => {window.location.href = '../SISTEMA/Usuarios.php';})</script>";
                exit;
            }
        }
        $sqlInsert = "UPDATE usuario SET Nome_usuario='$nome', Cidade='$cidade', Endereço='$endereço', Email='$email' WHERE Cod_usuario=$id";
        $result = $conexao->query($sqlInsert);
        echo "<script type='text/javascript'>Swal.fire('Excelente!', 'Dados editado com sucesso!', 'success').then(() => {window.location.href = '../SISTEMA/Usuarios.php';})</script>";
        }
    ?>
</body>

</html>