<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php

    use LDAP\Result;

    include_once("../Config.php");

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $cidade = $_POST['cidade'];
        $contato = $_POST['contato'];
        $nome_original = $_POST['nome_original'];


        if ($nome != $nome_original) {

            $sqleditora = "SELECT * FROM editora WHERE Nome_editora ='$nome'"; // consulta para verificar se o usuário já existe

            $resultado = $conexao->query($sqleditora); // executa a consulta

            if (mysqli_num_rows($resultado) >= 1) { // verifica se encontrou algum registro
                echo "<script type='text/javascript'>Swal.fire('Ops!', 'Editora ja existe!', 'error').then(() => {window.location.href = '../SISTEMA/Editoras.php';})</script>";
                exit;
            }
        } else {

            if (!empty($nome) && !empty($cidade) && !empty($contato)) {
                $sqlInsert = "UPDATE editora SET Nome_editora='$nome', Cidade='$cidade', Contato='$contato' WHERE Cod_editora=$id";
                $result = $conexao->query($sqlInsert);
                echo "<script type='text/javascript'>Swal.fire('Excelente!', 'Dados editado com sucesso!', 'success').then(() => {window.location.href = '../SISTEMA/Editoras.php';})</script>";
            }
        }
    }

    ?>
</body>

</html>