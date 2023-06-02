<?php
session_start();
include_once("../Config.php");

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

if (!empty($_GET['search'])) {
    $search = limparEntrada($_GET['search']);
    $data = $_GET['search'];

    // Verifica se a data possui apenas números
    if (is_numeric($data)) {
        // Pesquisa por qualquer campo que contenha o número informado
        $sqlhist = "SELECT histórico.Cod_hist, livro.Nome_livro, usuario.Nome_usuario, histórico.Data_aluguel, histórico.Data_previsão, histórico.Data_devolução, histórico.Quantidade
        FROM histórico
        INNER JOIN livro ON histórico.Livro = livro.Cod_livro
        INNER JOIN usuario ON histórico.Usuário = usuario.Cod_usuario
        WHERE livro.Nome_livro LIKE '%$data%'
            OR usuario.Nome_usuario LIKE '%$data%'
            OR histórico.Data_aluguel LIKE '%$data%'
            OR histórico.Data_previsão LIKE '%$data%'
            OR histórico.Data_devolução LIKE '%$data%'
            OR histórico.Status_hist LIKE '%$data%'";
    }
    // Verifica se a data possui apenas o dia e o mês
    elseif (preg_match('/^\d{2}\/\d{2}$/', $data)) {
        // Pesquisa por qualquer data com o dia e mês informados
        $sqlhist = "SELECT histórico.Cod_hist, livro.Nome_livro, usuario.Nome_usuario, histórico.Data_aluguel, histórico.Data_previsão, histórico.Data_devolução, histórico.Quantidade
        FROM histórico
        INNER JOIN livro ON histórico.Livro = livro.Cod_livro
        INNER JOIN usuario ON histórico.Usuário = usuario.Cod_usuario
        WHERE DATE_FORMAT(histórico.Data_aluguel, '%d/%m') = '$data'
            OR DATE_FORMAT(histórico.Data_devolução, '%d/%m') = '$data'
            OR DATE_FORMAT(histórico.Data_previsão, '%d/%m') = '$data'";
    }
    // Verifica se a data possui apenas o mês e o ano
    elseif (preg_match('/^\d{2}\/\d{4}$/', $data)) {
        // Pesquisa por qualquer data com o mês e ano informados
        $sqlhist = "SELECT histórico.Cod_hist, livro.Nome_livro, usuario.Nome_usuario, histórico.Data_aluguel, histórico.Data_previsão, histórico.Data_devolução, histórico.Quantidade
        FROM histórico
        INNER JOIN livro ON histórico.Livro = livro.Cod_livro
        INNER JOIN usuario ON histórico.Usuário = usuario.Cod_usuario
        WHERE DATE_FORMAT(histórico.Data_aluguel, '%m/%Y') = '$data'
            OR DATE_FORMAT(histórico.Data_devolução, '%m/%Y') = '$data'
            OR DATE_FORMAT(histórico.Data_previsão, '%m/%Y') = '$data'
            OR Status_hist LIKE '%$data%";
    }
    // Verifica se a data possui dia, mês e ano
    elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $data)) {
        $dataFormatada = date("Y-m-d", strtotime(str_replace('/', '-', $data)));
        // Pesquisa por qualquer data com o formato completo informado
        $sqlhist = "SELECT histórico.Cod_hist, livro.Nome_livro, usuario.Nome_usuario, histórico.Data_aluguel, histórico.Data_previsão, histórico.Data_devolução, histórico.Quantidade
        FROM histórico
        INNER JOIN livro ON histórico.Livro = livro.Cod_livro
        INNER JOIN usuario ON histórico.Usuário = usuario.Cod_usuario
        WHERE histórico.Cod_hist LIKE '%$data%'
            OR livro.Nome_livro LIKE '%$data%'
            OR usuario.Nome_usuario LIKE '%$data%'
            OR histórico.Data_aluguel LIKE '%$dataFormatada%'
            OR histórico.Data_devolução LIKE '%$dataFormatada%'
            OR histórico.Data_previsão LIKE '%$dataFormatada%'
            OR histórico.Status_hist LIKE '%$data%'";
    } else {
        // Caso a data informada não esteja em um formato válido, exibe uma mensagem de erro ou realiza alguma ação apropriada.
        $sqlhist = "SELECT histórico.Cod_hist, livro.Nome_livro, usuario.Nome_usuario, histórico.Data_aluguel, histórico.Data_previsão, histórico.Data_devolução, histórico.Quantidade
        FROM histórico
        INNER JOIN livro ON histórico.Livro = livro.Cod_livro
        INNER JOIN usuario ON histórico.Usuário = usuario.Cod_usuario
        WHERE histórico.Cod_hist LIKE '%$data%'
            OR livro.Nome_livro LIKE '%$data%'
            OR usuario.Nome_usuario LIKE '%$data%'
            OR histórico.Data_aluguel LIKE '%$data%'
            OR histórico.Data_devolução LIKE '%$data%'
            OR histórico.Data_previsão LIKE '%$data%'
            OR histórico.Status_hist LIKE '%$data%'";
    }
} else {
    $sqlhist = "SELECT histórico.Cod_hist, livro.Nome_livro, usuario.Nome_usuario, histórico.Data_aluguel, histórico.Data_previsão, histórico.Data_devolução, histórico.Quantidade
    FROM histórico
    INNER JOIN livro ON histórico.Livro = livro.Cod_livro
    INNER JOIN usuario ON histórico.Usuário = usuario.Cod_usuario";
}

// Verifica qual cabeçalho foi clicado para ordenação
$orderColumn = isset($_GET['order']) ? limparEntrada($_GET['order']) : 'Cod_hist';
$orderDirection = isset($_GET['direction']) && strtolower($_GET['direction']) === 'desc' ? 'DESC' : 'ASC';

// Constrói a parte da consulta SQL relacionada à ordenação
$orderClause = " ORDER BY $orderColumn $orderDirection";
// $sqlhist .= $orderClause;

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
$resultadoTotal = executarConsulta($conexao, $sqlhist);
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


if (!empty($data)) {
    $sqlhist .= " ORDER BY Cod_hist DESC";
} else {
    $sqlhist .= $orderClause;
    $sqlhist .= " LIMIT $registrosPorPagina OFFSET $offset";
}

// Executa a consulta SQL
$resultadoConsulta = executarConsulta($conexao, $sqlhist);
// echo $sqlhist;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <title>HISTÓRICO DE DEVOLUÇÃO</title>
    <link rel="stylesheet" href="../assets/css/Table.css?<?php echo rand(1, 1000); ?>">
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
                        <a class="nav-link" href="Historico.php" style="text-decoration:underline">HISTÓRICO</a>
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
    <div class="table-responsive">
        <div class="header-table d-flex justify-content-between align-items-center">
            <h2 class="hist">Histórico</h2>
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
                    <th><a class="header" href="?order=Cod_hist&direction=<?php echo ($orderColumn === 'Cod_hist' && $orderDirection === 'ASC') ? 'desc' : 'asc'; ?>&pagina=<?php echo $paginaAtual ?>">ID</a></th>
                    <th><a class="header" href="?order=Nome_livro&direction=<?php echo ($orderColumn === 'Nome_livro' && $orderDirection === 'ASC') ? 'desc' : 'asc'; ?>&pagina=<?php echo $paginaAtual ?>">Livro</a></th>
                    <th><a class="header" href="?order=Nome_usuario&direction=<?php echo ($orderColumn === 'Nome_usuario' && $orderDirection === 'ASC') ? 'desc' : 'asc'; ?>&pagina=<?php echo $paginaAtual ?>">Cliente</a></th>
                    <th><a class="header" href="?order=Data_aluguel&direction=<?php echo ($orderColumn === 'Data_aluguel' && $orderDirection === 'ASC') ? 'desc' : 'asc'; ?>&pagina=<?php echo $paginaAtual ?>">Data de aluguel</a></th>
                    <th><a class="header" href="?order=Data_previsão&direction=<?php echo ($orderColumn === 'Data_previsão' && $orderDirection === 'ASC') ? 'desc' : 'asc'; ?>&pagina=<?php echo $paginaAtual ?>">Previsão devolução</a></th>
                    <th><a class="header" href="?order=Data_devolução&direction=<?php echo ($orderColumn === 'Data_devolução' && $orderDirection === 'ASC') ? 'desc' : 'asc'; ?>&pagina=<?php echo $paginaAtual ?>">Data devolução</a></th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <?php
                while ($hist_data = mysqli_fetch_assoc($resultadoConsulta)) {
                    echo "<tr>";
                    echo "<td>" . $hist_data['Cod_hist'] . "</td>";
                    echo "<td>" . $hist_data['Nome_livro'] . "</td>";
                    echo "<td>" . $hist_data['Nome_usuario'] . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($hist_data['Data_aluguel'])) . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($hist_data['Data_previsão'])) . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($hist_data['Data_devolução'])) . "</td>";
                    // echo "<td>" . $hist_data['Quantidade'] . "</td>";
                    if (strtotime($hist_data['Data_previsão']) >= strtotime($hist_data['Data_devolução'])) {
                        $sqlstatus = "UPDATE histórico SET Status_hist = 'Livro no dentro do prazo' WHERE Cod_hist = $hist_data[Cod_hist]";
                        $status = $conexao->query($sqlstatus);
                        echo "<td>
                            <a class='btn btn-sm' onclick='confirmPrazo()' title='Entregue no prazo'>
                            <img src='../assets/img/prazo.png' width='26' height='26'>
                            </a>
                            </td>";
                    } else {
                        $sqlstatus = "UPDATE histórico SET Status_hist = 'Livro fora do Prazo em atraso atrasado' WHERE Cod_hist = $hist_data[Cod_hist]";
                        $status = $conexao->query($sqlstatus);
                        echo "<td>
                            <a class='btn btn-sm' onclick='confirmForaPrazo()' title='Entregue fora do prazo'>
                            <img src='../assets/img/erro.png' width='26' height='26'>
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
                    <a class="page-link" href="Historico.php?order=<?php echo $orderColumn; ?>&direction=<?php echo $orderDirection; ?>&pagina=<?php echo ($paginaAtual - 1); ?>" aria-label="Anterior">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php
                // Exibir link da página anterior, se existir
                if ($paginaAtual > 3) {
                    echo "<li class='page-item'><a class='page-link' href='Historico.php?order=$orderColumn&direction=$orderDirection&pagina=1'>1</a></li>";
                    echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                }

                // Exibir páginas anteriores à página atual
                for ($i = max(1, $paginaAtual - 1); $i < $paginaAtual; $i++) {
                    echo "<li class='page-item'><a class='page-link' href='Historico.php?order=$orderColumn&direction=$orderDirection&pagina=$i'>$i</a></li>";
                }

                // Exibir página atual
                echo "<li class='page-item active'><span class='page-link'>$paginaAtual</span></li>";

                // Exibir páginas posteriores à página atual
                for ($i = $paginaAtual + 1; $i <= min($paginaAtual + 1, $totalPaginas); $i++) {
                    echo "<li class='page-item'><a class='page-link' href='Historico.php?order=$orderColumn&direction=$orderDirection&pagina=$i'>$i</a></li>";
                }

                // Exibir link da próxima página, se existir
                if ($paginaAtual < $totalPaginas - 2) {
                    echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                    echo "<li class='page-item'><a class='page-link' href='Historico.php?order=$orderColumn&direction=$orderDirection&pagina=$totalPaginas'>$totalPaginas</a></li>";
                }
                ?>
                <li class="page-item <?php echo ($paginaAtual == $totalPaginas) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="Historico.php?order=<?php echo $orderColumn; ?>&direction=<?php echo $orderDirection; ?>&pagina=<?php echo ($paginaAtual + 1); ?>" aria-label="Próxima">
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
        window.location = 'Historico.php?search=' + search.value
    }
</script>
<script>
    function confirmPrazo() {
        Swal.fire('Excelente!', 'Livro devolvido dentro do prazo', 'success')
    }

    function confirmForaPrazo() {
        Swal.fire('Hmm!', 'Livro devolvido Fora do prazo', 'info')
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

</html>