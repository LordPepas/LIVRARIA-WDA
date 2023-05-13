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
        $titulo = $_POST['titulo'];
        $editora = $_POST['editora'];
        $autor = $_POST['autor'];
        $lançamento = $_POST['lançamento'];
        $quantidade = $_POST['quantidade'];
        $titulo_original = $_POST['titulo_original'];

        if ($titulo != $titulo_original) {
            // O título foi modificado, verificar se já existe outro livro com o mesmo título
            $sqllivros = "SELECT * FROM livro WHERE Nome_livro ='$titulo'";
            $resultado = $conexao->query($sqllivros);
            if (mysqli_num_rows($resultado) >= 1) {
                echo "<script type='text/javascript'>Swal.fire('Ops!', 'Livro já existe!', 'error').then(() => {window.location.href = '../SISTEMA/Livros.php';})</script>";
                exit;
            }
        }
        $sqlInsert = "UPDATE livro SET Nome_livro='$titulo', Editora='$editora', Autor='$autor', Lançamento='$lançamento', Quantidade='$quantidade' WHERE Cod_livro='$id'";
        $resultado = $conexao->query($sqlInsert);
        echo "<script type='text/javascript'>Swal.fire('Excelente!', 'Dados editado com sucesso!', 'success').then(() => {window.location.href = '../SISTEMA/Livros.php';})</script>";
    }
    ?>
</body>

</html>