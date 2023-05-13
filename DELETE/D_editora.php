<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    if (!empty($_GET['id'])) {
        include_once('../Config.php');
        $id = $_GET['id'];
        $sqlSelect = "SELECT * FROM editora WHERE Cod_editora=$id";
        $result = $conexao->query($sqlSelect);
        $sqlCheckLivro = "SELECT * FROM livro WHERE Editora=$id ";
        $resultCheckLivro = $conexao->query($sqlCheckLivro);

        if ($resultCheckLivro->num_rows > 0) {
            echo "<script type='text/javascript'>Swal.fire('Erro!', 'Não é possível excluir esta editora pois há um ou mais livros cadastrados com ela', 'error').then(() => {window.location.href = '../SISTEMA/Editoras.php';})</script>";
            exit;
        } else {
            // Se não houver aluguel ativo, continuar com o código original
            if ($result->num_rows > 0) {
                $sqlDelete = "DELETE FROM editora WHERE Cod_editora=$id";
                $resultDelete = $conexao->query($sqlDelete);
                mysqli_query($conexao, "ALTER TABLE dblocadora.editora AUTO_INCREMENT = 1;");
            }
            echo "<script type='text/javascript'>Swal.fire('Excelente!','Editora deletado com sucesso!','success').then(() => {window.location.href = '../SISTEMA/Editoras.php';})</script>";
        }
    }
    ?>
</body>

</html>