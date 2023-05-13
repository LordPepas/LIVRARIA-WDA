<?php
include_once("../Config.php");
session_start();
if (!empty($_GET['search'])) {
    $data = $_GET['search'];
    $sql = "SELECT histórico.Cod_hist, livro.Nome_livro, usuario.Nome_usuario, histórico.Data_aluguel, histórico.Data_previsão, histórico.Data_devolução, histórico.Quantidade
    FROM histórico, livro, usuario 
    WHERE histórico.Livro = livro.Cod_livro 
    AND histórico.Usuário = usuario.Cod_usuario 
    AND (livro.Nome_livro LIKE '%$data%' 
         OR usuario.Nome_usuario LIKE '%$data%' 
         OR histórico.Data_aluguel LIKE '%$data%' 
         OR histórico.Data_previsão LIKE '%$data%' 
         OR histórico.Data_devolução LIKE '%$data%') 
    ORDER BY Cod_hist DESC";
} else {
    $sql = "SELECT h.Cod_hist, l.Nome_livro, u.Nome_usuario, h.Data_aluguel, h.Data_previsão, h.Data_devolução, h.Quantidade
FROM histórico h
INNER JOIN livro l ON h.Livro = l.Cod_livro
INNER JOIN usuario u ON h.Usuário = u.Cod_usuario
ORDER BY h.Cod_hist DESC";
}

$result = $conexao->query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <title>HISTÓRICO DE DEVOLUÇÃO</title>
    <link rel="stylesheet" href="../assets/css/Tabela.css">
</head>

<body>
    <!-- Código HTML para exibição da barra de navegação e da tabela de clientes -->
    <!-- Barra de navegação -->
    <nav class="navbar navbar-expand-lg" style="background-color: rgb(255,255,255);">
        <div class="container-fluid">
            <a class="navbar-brand" href="Sistema.php">WDA LIVRARIA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Links para as diferentes páginas -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="Sistema.php">INICIO
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Usuarios.php">CLIENTES</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Livros.php">LIVROS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Editoras.php">EDITORAS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Aluguel.php">ALUGUEL</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Historico.php">HISTÓRICO</a>
                    </li>
                </ul>
                <!-- Botão de sair -->
                <span class="navbar-text">
                    <div class="d-flex">
                        <a href="Sair.php" id="out" class="btn btn-outline-danger me-5">Sair</a>
                    </div>
                </span>
            </div>
        </div>
    </nav>
    <br><br>
    <!-- Tabela de clientes -->
    <div class="table-responsive m-5">
        <div class="header-table d-flex justify-content-between align-items-center">
            <h2 style="margin-right: 15%">Histórico</h2>
            <!-- Campo de busca -->
            <input type="search" class="form-control w-25" placeholder="Pesquisar" id="pesquisar">
            <!-- Botão para executar a busca -->
            <button class="btn btn-primary" onclick="searchData()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                </svg>
            </button>
        </div>
        <!-- Tabela propriamente dita -->
        <table class="table text-white table-bg">
            <thead class="table-header">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Livro</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Data de aluguel</th>
                    <th scope="col">Previsão de devolução</th>
                    <th scope="col">Devolução</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>

            <tbody>
                <?php
                while ($user_data = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    $user_data['Data_aluguel'];
                    echo "<td>" . $user_data['Cod_hist'] . "</td>";
                    echo "<td>" . $user_data['Nome_livro'] . "</td>";
                    echo "<td>" . $user_data['Nome_usuario'] . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($user_data['Data_aluguel'])) . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($user_data['Data_previsão'])) . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($user_data['Data_devolução'])) . "</td>";
                    echo "<td>" . $user_data['Quantidade'] . "</td>";
                    if (strtotime($user_data['Data_previsão']) >= strtotime($user_data['Data_devolução'])) {
                        echo "<td>
                            <a class='btn btn-sm' onclick='confirmPrazo()' title='Entregue no prazo'>
                            <img src='../assets/img/prazo.png' width='26' height='26'>
                            </a>
                            </td>";
                    } else {
                        echo "<td>
                            <a class='btn btn-sm' onclick='confirmForaPrazo()' title='Entregue fora do prazo'>
                            <img src='../assets/img/erro.png' width='26' height='26'>
                            </a>
                            </td>";
                    }
                }
                echo "</tr>";
                // 
                ?>
            </tbody>
        </table>
    </div>
</body>
<script>
    var search = document.getElementById('pesquisar')

    search.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            searchData()
        }
    })

    function searchData() {
        window.location = 'Historico.php?search=' + search.value
    }
</script>
<script>
    function confirmPrazo() {
        Swal.fire('Excelente!', 'Livro devolvido dentro do prazo', 'success')
    }

    function confirmForaPrazo() {
        Swal.fire('Hmm!', 'Livro devolvido Fora do prazo', 'warning')
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

</html>