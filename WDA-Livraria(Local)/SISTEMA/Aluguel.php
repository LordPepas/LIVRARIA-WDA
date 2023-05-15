<?php
session_start();
include_once("../Config.php");
/* 
// Debug: imprime o array $_SESSION
print_r($_SESSION); 
*/

// Verifica se não existem informações de username e senha na sessão
if ((!isset($_SESSION['username']) == true) and (!isset($_SESSION['senha']) == true)) {
    // Destrói as informações existentes na sessão
    unset($_SESSION['username']);
    unset($_SESSION['senha']);
  
    // Redireciona o usuário para a página de login
    header('Location: ../ADMIN/login.php');
  }

if (!empty($_GET['search'])) {
    $data = $_GET['search'];

    $sql = "SELECT Cod_aluguel,livro.Nome_livro,usuario.Nome_usuario,Data_aluguel,Data_previsão,Quantidade_alugada FROM aluguel,livro,usuario
    WHERE aluguel.Livro = Livro.Cod_livro AND aluguel.Usuário = usuario.Cod_usuario AND (Cod_aluguel LIKE '%$data%' or Nome_livro LIKE 
    '%$data%' or Nome_usuario LIKE '%$data%' or Data_aluguel LIKE '%$data%' or Data_previsão LIKE '%$data%')
     ORDER BY Cod_aluguel DESC";
} else {
    $sql = "SELECT Cod_aluguel,livro.Nome_livro,usuario.Nome_usuario,Data_aluguel,Data_previsão,Quantidade_alugada FROM aluguel,livro,usuario
    WHERE aluguel.Livro = Livro.Cod_livro AND aluguel.Usuário = usuario.Cod_usuario  ORDER BY Cod_aluguel DESC";
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
    <link rel="stylesheet" href="../assets/css/Tabela.css">
    <title>ALUGUEL DE LIVROS</title>
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
                        <a href="Sair.php" id="out" class="btn btn-outline-danger me-5 ">Sair</a>
                    </div>
                </span>
            </div>
        </div>
    </nav>
    <br><br>
    <!-- Tabela de clientes -->
    <div class="table-responsive m-5">
        <div class="header-table d-flex justify-content-between align-items-center">
            <h2>Aluguel</h2>
            <!-- Botão para adicionar novo cliente -->
            <a href="../CREATE/C_aluguel.php" class="btn btn-success btn-block" style="margin: 3px 3px 3px 3px;">ADICIONAR +</a><br>
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
                    <th scope="col">Quantidade</th>
                    <th scope="col">Devolver</th>
                </tr>
            </thead>

            <tbody>
                <?php
                while ($aluguel_data = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $aluguel_data['Cod_aluguel'] . "</td>";
                    echo "<td>" . $aluguel_data['Nome_livro'] . "</td>";
                    echo "<td>" . $aluguel_data['Nome_usuario'] . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($aluguel_data['Data_aluguel'])) . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($aluguel_data['Data_previsão'])) . "</td>";
                    echo "<td>" . $aluguel_data['Quantidade_alugada'] . "</td>";
                    if (strtotime($aluguel_data['Data_previsão']) >= strtotime(date('Y-m-d'))) {
                        echo "<td>
                        <a class='btn btn-sm' title='Livro no Prazo!' onclick='confirmDelete($aluguel_data[Cod_aluguel])'>
                        <img src='../assets/img/envio.png' width='28' height='28'>
                        </a>
                        </td>";
                    } else {
                        echo "<td>
                        <a class='btn btn-sm b' title='Livro fora Prazo!' onclick='confirmDelete($aluguel_data[Cod_aluguel])'> 
                        <img src='../assets/img/em-formacao.png' width='28' height='28'>

                            </a>
                            </td>";
                    }
                }
                echo "</tr>";
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
        window.location = 'Aluguel.php?search=' + search.value
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Devolver livro alugado?',
            text: "Você não poderá reverter isso!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, devolver!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `../DELETE/D_aluguel.php?id=${id}`;
            }
        })
    }
</script>

</html>
