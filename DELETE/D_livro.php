</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>;
</head>

<body>

    <?php
    if (!empty($_GET['id'])) {
        include_once('../Config.php');
        $id = $_GET['id'];
        $sqlSelect = "SELECT * FROM livro WHERE Cod_livro=$id";

        $result = $conexao->query($sqlSelect);
        $sqlCheckAluguel = "SELECT * FROM aluguel WHERE Livro=$id ";
        $resultCheckAluguel = $conexao->query($sqlCheckAluguel);

        if ($resultCheckAluguel->num_rows > 0) {
            echo "<script type='text/javascript'>Swal.fire('Erro!','Não é possível excluir este Livro pois há um aluguel ativo.','error').then(() => {window.location.href = '../SISTEMA/Livros.php';})</script>";
        } else {
            // Se não houver aluguel ativo, continuar com o código original
            if ($result->num_rows > 0) {
                $sqlDelete = "DELETE FROM livro WHERE Cod_livro=$id";
                $resultDelete = $conexao->query($sqlDelete);
                mysqli_query($conexao, "ALTER TABLE dblocadora.livro AUTO_INCREMENT = 1;");
            }
            echo "<script type='text/javascript'>Swal.fire('Excelente!','Livro deletado com sucesso!','success').then(() => {window.location.href = '../SISTEMA/Livros.php';})</script>";
        }
    }
    ?>
</body>

</html>