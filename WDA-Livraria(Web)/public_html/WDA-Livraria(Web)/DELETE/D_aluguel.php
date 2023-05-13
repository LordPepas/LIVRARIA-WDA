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

    $sqlSelect = "SELECT * FROM aluguel WHERE Cod_aluguel=$id";

    $result = $conexao->query($sqlSelect);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $livro = $row['Livro'];
        $quantidade_alugada = $row['Quantidade_alugada'];
        
        $sqlUpdateLivro = "UPDATE livro SET Quantidade = Quantidade + $quantidade_alugada WHERE Cod_livro = '$livro'";
        $resultUpdateLivro = mysqli_query($conexao, $sqlUpdateLivro);
        mysqli_query($conexao, "ALTER TABLE id20742095_bdlocadora.aluguel AUTO_INCREMENT = 1;");
        mysqli_query($conexao, "ALTER TABLE id20742095_bdlocadora.histórico AUTO_INCREMENT = 1;");


    $sql = "SELECT * FROM aluguel ORDER BY Cod_aluguel DESC";
    $result = $conexao->query($sql);
        $user_data = mysqli_fetch_assoc($result);
        $livro = $user_data['Livro'];
        $usuario = $user_data['Usuário'];
        $data_aluguel = $user_data['Data_aluguel'];
        $data_previsão = $user_data['Data_previsão'];
        $quantidade_alugada = $user_data['Quantidade_alugada'];
        $data_devolução = date('Y-m-d');
        if ($resultUpdateLivro) {
            $sqlInsert = "INSERT INTO histórico (Livro, Usuário, Data_aluguel, Data_previsão, Data_devolução, Quantidade) VALUES ('$livro', '$usuario', '$data_aluguel', '$data_previsão', '$data_devolução', '$quantidade_alugada')";
            $resultInsert = mysqli_query($conexao, $sqlInsert);
        if ($resultInsert) {
                $sqlDelete = "DELETE FROM aluguel WHERE Cod_aluguel=$id";
                $resultDelete = $conexao->query($sqlDelete);
                echo "<script type='text/javascript'>Swal.fire('Excelente!','Livro devolvido com sucesso!','success').then(() => {window.location.href = '../SISTEMA/Aluguel.php';})</script>";
            }
        }
    }
}
?>
</body>
</html>   