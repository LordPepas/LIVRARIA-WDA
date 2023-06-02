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

// Função para limpar dados de entrada
function limparEntrada($entrada)
{
    global $conexao;
    // Remove espaços em branco no início e no final da string
    $entrada = trim($entrada);
    // Remove barras invertidas
    $entrada = stripslashes($entrada);
    // Remove caracteres especiais
    $entrada = htmlspecialchars($entrada);
    // Escapa os caracteres especiais para evitar ataques de SQL injection
    $entrada = mysqli_real_escape_string($conexao, $entrada);

    return $entrada;
}

// Verifica se há uma busca na URL
if (!empty($_GET['search'])) {
    $search = limparEntrada($_GET['search']);

    $sqlaluguel = "SELECT Cod_aluguel,livro.Nome_livro,usuario.Nome_usuario,Data_aluguel,Data_previsão,Quantidade_alugada
     FROM aluguel,livro,usuario
    WHERE aluguel.Livro = Livro.Cod_livro 
    AND aluguel.Usuário = usuario.Cod_usuario 
    AND (Cod_aluguel 
    LIKE '%$search%' or Nome_livro 
    LIKE '%$search%' or Nome_usuario 
    LIKE '%$search%' or Data_aluguel 
    LIKE '%$search%' or Data_previsão 
    LIKE '%$search%' or Status_aluguel 
    LIKE '%$search%')";
} else {
    $sqlaluguel = "SELECT Cod_aluguel,livro.Nome_livro,usuario.Nome_usuario,Data_aluguel,Data_previsão,Quantidade_alugada 
    FROM aluguel,livro,usuario
    WHERE aluguel.Livro = Livro.Cod_livro 
    AND aluguel.Usuário = usuario.Cod_usuario ";
}

// Verifica qual cabeçalho foi clicado para ordenação
$orderColumn = isset($_GET['order']) ? limparEntrada($_GET['order']) : 'Cod_aluguel';
$orderDirection = isset($_GET['direction']) && strtolower($_GET['direction']) === 'desc' ? 'DESC' : 'ASC';

// Constrói a parte da consulta SQL relacionada à ordenação
$orderClause = " ORDER BY $orderColumn $orderDirection";
// $sqlbook .= $orderClause;

// Função para executar uma consulta SQL e retornar o resultado
function executarConsulta($conexao, $sql)
{
    $result = mysqli_query($conexao, $sql);
    if ($result === false) {
        echo "Erro na consulta: " . mysqli_error($conexao);
        return false;
    }
    return $result;
}

// Define o número de registros por página
$registrosPorPagina = 5;

// Obtém o número total de registros
$resultadoTotal = executarConsulta($conexao, $sqlaluguel);
$totalRegistros = mysqli_num_rows($resultadoTotal);

// Calcula o total de páginas
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);

// Obtém a página atual
$paginaAtual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
if ($paginaAtual < 1) {
    $paginaAtual = 1;
} elseif ($paginaAtual > $totalPaginas) {
    $paginaAtual = $totalPaginas;
}

// Calcula o offset (deslocamento) para a consulta SQL
$offset = ($paginaAtual - 1) * $registrosPorPagina;


if (!empty($search)) {
    $sqlaluguel .= " ORDER BY Cod_aluguel DESC";
} else {
    $sqlaluguel .= $orderClause;
    $sqlaluguel .= " LIMIT $registrosPorPagina OFFSET $offset";
}
// Adiciona o limite e offset na consulta SQL

// Executa a consulta SQL
$resultadoConsulta = executarConsulta($conexao, $sqlaluguel);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/Table.css?<?php echo rand(1, 1000); ?>">
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
                        <a class="nav-link" href="Aluguel.php" style="text-decoration:underline">ALUGUEL</a>
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
    <div class="table-responsive">
        <div class="header-table d-flex justify-content-between align-items-center">
            <h2 class="aluguel">Aluguel</h2>
            <!-- Botão para adicionar novo cliente -->
            <a href="../CREATE/C_aluguel.php" class="btn btn-success">ADICIONAR+</a><br>
            <!-- Campo de busca -->
            <input type="search" class="form-control" placeholder="Pesquisar" id="pesquisar">
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
                    <th><a class="header" href="?order=Cod_aluguel&direction=<?php echo ($orderColumn === 'Cod_aluguel' && $orderDirection === 'ASC') ? 'desc' : 'asc'; ?>&pagina=<?php echo $paginaAtual ?>">ID</a></th>
                    <th><a class="header" href="?order=Nome_livro&direction=<?php echo ($orderColumn === 'Nome_livro' && $orderDirection === 'ASC') ? 'desc' : 'asc'; ?>&pagina=<?php echo $paginaAtual ?>">Livro</a></th>
                    <th><a class="header" href="?order=Nome_usuario&direction=<?php echo ($orderColumn === 'Nome_usuario' && $orderDirection === 'ASC') ? 'desc' : 'asc'; ?>&pagina=<?php echo $paginaAtual ?>">Cliente</a></th>
                    <th><a class="header" href="?order=Data_aluguel&direction=<?php echo ($orderColumn === 'Data_aluguel' && $orderDirection === 'ASC') ? 'desc' : 'asc'; ?>&pagina=<?php echo $paginaAtual ?>">Data de aluguel</a></th>
                    <th><a class="header" href="?order=Data_previsão&direction=<?php echo ($orderColumn === 'Data_previsão' && $orderDirection === 'ASC') ? 'desc' : 'asc'; ?>&pagina=<?php echo $paginaAtual ?>">Previsão de devolução</a></th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <?php
                while ($aluguel_data = mysqli_fetch_assoc($resultadoConsulta)) {
                    echo "<tr>";
                    echo "<td>" . $aluguel_data['Cod_aluguel'] . "</td>";
                    echo "<td>" . $aluguel_data['Nome_livro'] . "</td>";
                    echo "<td>" . $aluguel_data['Nome_usuario'] . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($aluguel_data['Data_aluguel'])) . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($aluguel_data['Data_previsão'])) . "</td>";
                    // echo "<td>" . $aluguel_data['Quantidade_alugada'] . "</td>";
                    if (strtotime($aluguel_data['Data_previsão']) >= strtotime(date('Y-m-d'))) {
                        $sqlstatus = "UPDATE aluguel SET Status_aluguel = 'Livro no dentro do prazo' WHERE Cod_aluguel = $aluguel_data[Cod_aluguel]";
                        $status = $conexao->query($sqlstatus);
                        echo "<td>
                        <a class='btn btn-sm' title='Livro no Prazo!' onclick='confirmDelete($aluguel_data[Cod_aluguel])'>
                        <img src='../assets/img/envio.png' width='28' height='28'>
                        </a>
                        </td>";
                    } else {
                        $sqlstatus = "UPDATE aluguel SET Status_aluguel = 'Livro fora Prazo em atraso atrasado' WHERE Cod_aluguel = $aluguel_data[Cod_aluguel]";
                        $status = $conexao->query($sqlstatus);
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
        <!-- Div para os links de paginação -->
        <div class="pagination <?php if (!empty($search)) echo 'd-none'; ?>">
            <!-- links de paginação serão adicionados aqui -->
            <!-- Dentro da div de paginação -->
            <ul class="pagination">
                <li class="page-item <?php echo ($paginaAtual == 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="Aluguel.php?order=<?php echo $orderColumn; ?>&direction=<?php echo $orderDirection; ?>&pagina=<?php echo ($paginaAtual - 1); ?>" aria-label="Anterior">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php
                // Exibir link da página anterior, se existir
                if ($paginaAtual > 3) {
                    echo "<li class='page-item'><a class='page-link' href='Aluguel.php?order=$orderColumn&direction=$orderDirection&pagina=1'>1</a></li>";
                    echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                }

                // Exibir páginas anteriores à página atual
                for ($i = max(1, $paginaAtual - 1); $i < $paginaAtual; $i++) {
                    echo "<li class='page-item'><a class='page-link' href='Aluguel.php?order=$orderColumn&direction=$orderDirection&pagina=$i'>$i</a></li>";
                }

                // Exibir página atual
                echo "<li class='page-item active'><span class='page-link'>$paginaAtual</span></li>";

                // Exibir páginas posteriores à página atual
                for ($i = $paginaAtual + 1; $i <= min($paginaAtual + 1, $totalPaginas); $i++) {
                    echo "<li class='page-item'><a class='page-link' href='Aluguel.php?order=$orderColumn&direction=$orderDirection&pagina=$i'>$i</a></li>";
                }

                // Exibir link da próxima página, se existir
                if ($paginaAtual < $totalPaginas - 2) {
                    echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                    echo "<li class='page-item'><a class='page-link' href='Aluguel.php?order=$orderColumn&direction=$orderDirection&pagina=$totalPaginas'>$totalPaginas</a></li>";
                }
                ?>
                <li class="page-item <?php echo ($paginaAtual == $totalPaginas) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="Aluguel.php?order=<?php echo $orderColumn; ?>&direction=<?php echo $orderDirection; ?>&pagina=<?php echo ($paginaAtual + 1); ?>" aria-label="Próxima">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </div>
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