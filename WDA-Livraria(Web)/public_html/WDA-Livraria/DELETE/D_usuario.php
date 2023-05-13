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
        $sqlSelect = "SELECT * FROM usuario WHERE Cod_usuario=$id";

        $result = $conexao->query($sqlSelect);
        $sqlCheckAluguel = "SELECT * FROM aluguel WHERE Usuário=$id ";
        $resultCheckAluguel = $conexao->query($sqlCheckAluguel);
        $sqlCheckHist = "SELECT * FROM histórico WHERE Usuário=$id ";
        $resultCheckHist = $conexao->query($sqlCheckHist);

        if ($resultCheckHist->num_rows > 0) {
            $sqlDelHist = "DELETE FROM histórico WHERE Usuário=$id";
                $resultDelHist = $conexao->query($sqlDelHist);
                mysqli_query($conexao, "ALTER TABLE dblocadora.histórico AUTO_INCREMENT = 1;");
        }
        if ($resultCheckAluguel->num_rows > 0) {
            echo "<script type='text/javascript'>Swal.fire('Erro!','Não é possível excluir este cliente pois há um aluguel ativo.','error').then(() => {window.location.href = '../SISTEMA/Usuarios.php';})</script>";
        } else {
            // Se não houver aluguel ativo, continuar com o código original
            if ($result->num_rows > 0) {
                $sqlDelete = "DELETE FROM usuario WHERE Cod_usuario=$id";
                $resultDelete = $conexao->query($sqlDelete);
                mysqli_query($conexao, "ALTER TABLE id20742095_bdlocadora.usuario AUTO_INCREMENT = 1;");
            }
            echo "<script type='text/javascript'>Swal.fire('Excelente!','Cliente e histórico deletado com sucesso!','success').then(() => {window.location.href = '../SISTEMA/Usuarios.php';})</script>";
        }
    }
    ?>
</body>

</html>