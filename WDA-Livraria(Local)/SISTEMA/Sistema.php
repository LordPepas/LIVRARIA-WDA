<?php
// Inicia a sessão
session_start();

// Inclui o arquivo de configuração
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
  header('Location: login.php');
}

// Armazena o nome de usuário da sessão em uma variável
$logado = $_SESSION['username'];

// Obtém o último aluguel
$sql_ultimo_aluguel = "SELECT Cod_aluguel,livro.Nome_livro,usuario.Nome_usuario,Data_aluguel,Data_previsão,Quantidade_alugada
FROM aluguel,livro,usuario WHERE aluguel.Livro = Livro.Cod_livro AND aluguel.Usuário = usuario.Cod_usuario ORDER BY Cod_aluguel DESC";
$resultado_ultimo_aluguel = $conexao->query($sql_ultimo_aluguel);
$linha_ultimo_aluguel = $resultado_ultimo_aluguel->fetch_assoc();
if (isset($linha_ultimo_aluguel['Nome_livro'], $linha_ultimo_aluguel['Nome_usuario'], $linha_ultimo_aluguel['Data_aluguel'])) {
  $ultimo_aluguel = "<br>LIVRO:<br>" . $linha_ultimo_aluguel['Nome_livro'] . "<br>" .
    "Alugado por:<br>" . $linha_ultimo_aluguel['Nome_usuario'] . "<br>" .
    "Data do aluguel:<br>" . date('d/m/Y', strtotime($linha_ultimo_aluguel['Data_aluguel']));
} else {
  $ultimo_aluguel = "<br>Não há nenhum aluguel ativo!";
}

// Obtém o total de alugueis
$sql_total_alugueis = "SELECT COUNT(*) AS total_alugueis FROM aluguel";
$resultado_total_alugueis = $conexao->query($sql_total_alugueis);
$linha_total_alugueis = $resultado_total_alugueis->fetch_assoc();
if (isset($linha_total_alugueis['total_alugueis'])) {
  $quantidade_alugueis = $linha_total_alugueis['total_alugueis'];
}
if ($linha_total_alugueis['total_alugueis'] == 0) {
  $quantidade_alugueis = "<br>Não há aluguéis registrados!";
}

//Total de livros
$sql_total_livros = "SELECT COUNT(*) AS Nome_livro FROM livro";
$resultado_total_livros = $conexao->query($sql_total_livros);
$linha_total_livros = $resultado_total_livros->fetch_assoc();
if (isset($linha_total_livros['Nome_livro'])) {
  $total_livros = $linha_total_livros['Nome_livro'];
}
if ($linha_total_livros['Nome_livro'] == 0) {
  $total_livros = "<br>Não há livros registrados!";
}

// Obtém o último livro devolvido
$sql_ultimo_devolvido = "SELECT histórico.Cod_hist, livro.Nome_livro, usuario.Nome_usuario, histórico.Data_aluguel, histórico.Data_previsão, histórico.Data_devolução, histórico.Quantidade
FROM histórico, livro, usuario 
WHERE histórico.Livro = livro.Cod_livro 
AND histórico.Usuário = usuario.Cod_usuario
ORDER BY Cod_hist DESC ";
$resultado_ultimo_devolvido = $conexao->query($sql_ultimo_devolvido);
$linha_ultimo_devolvido = $resultado_ultimo_devolvido->fetch_assoc();
if (isset($linha_ultimo_devolvido['Nome_livro'], $linha_ultimo_devolvido['Nome_usuario'], $linha_ultimo_devolvido['Data_devolução'])) {
  $ultimo_devolvido = "<br>LIVRO:<br>" . $linha_ultimo_devolvido['Nome_livro'] . "<br>" .
    "Alugado por:<br>" . $linha_ultimo_devolvido['Nome_usuario'] . "<br>" .
    "Data do aluguel:<br>" . date('d/m/Y', strtotime($linha_ultimo_devolvido['Data_aluguel']));
} else {
  $ultimo_devolvido = "<br>Não há nenhum aluguel ativo!";
}

//Lirvos dentro e fora do prazo
$sql = "SELECT * FROM histórico ORDER BY Cod_hist DESC";
$result = $conexao->query($sql);
$total_prazo = 0;
$total_foraprazo = 0;
while ($user_data = mysqli_fetch_assoc($result)) {
  echo "<tr>";
  $user_data['Cod_hist'];
  $user_data['Livro'];
  $user_data['Data_previsão'];
  $user_data['Data_devolução'];
  $user_data['Quantidade'];
  //Livro no praxo
  if ($user_data['Data_previsão'] > $user_data['Data_devolução']) {
    $total_prazo++;
  }
  //Livro fora praxo
  if ($user_data['Data_previsão'] < $user_data['Data_devolução']) {
    $total_foraprazo++;
  }
}

// Função para gerar uma cor aleatória no formato RGBA
function gerar_cor()
{
  $r = rand(0, 255); //gerar um número inteiro aleatório
  $g = rand(0, 255); //gerar um número inteiro aleatório
  $b = rand(0, 255); //gerar um número inteiro aleatório
  return "rgba($r, $g, $b, 0.7)";
}
// Obtém os dados do banco de dados
$rotulos = array();
$dados = array();
$rotulos2 = array();
$dados2 = array();
$backgroundColor = array();
$borderColor = array();
$backgroundColor2 = array();
$borderColor2 = array();

//Gráfico 01

//Secionar dados
$sql_dados = "SELECT livro.Nome_livro, COUNT(*) AS total_alugueis 
FROM histórico, livro 
WHERE histórico.Livro = livro.Cod_livro 
GROUP BY livro.Cod_livro 
ORDER BY total_alugueis DESC;";
$resultado_dados = $conexao->query($sql_dados);
// Loop pelos resultados e adiciona os dados aos arrays

while ($linha = $resultado_dados->fetch_assoc()) {
  $rotulos[] = $linha['Nome_livro'];
  $dados[] = $linha['total_alugueis'];
  $backgroundColor[] = gerar_cor();
  $borderColor[] = str_replace("0.5", "1", $backgroundColor[count($backgroundColor) - 1]);
}
//Gráfico 02

//Selecionar dados
$sql_dados2 = "SELECT Nome_livro, Quantidade
 FROM livro WHERE Quantidade > 0 
 ORDER BY Quantidade DESC";
$resultado_dados2 = $conexao->query($sql_dados2);
// Loop pelos resultados e adiciona os dados aos arrays
while ($linha2 = $resultado_dados2->fetch_assoc()) {
  $rotulos2[] = $linha2['Nome_livro'];
  $dados2[] = $linha2['Quantidade'];
  $backgroundColor2[] = gerar_cor();
  $borderColor2[] = str_replace("0.5", "1", $backgroundColor2[count($backgroundColor2) - 1]);
}

// Cria um objeto do tipo Chart.js


//Grafico 01
$chart = array(
  "type" => "pie",
  "data" => array(
    "labels" => $rotulos,
    "datasets" => array(
      array(
        "label" => "Quantidade de Aluguéis",
        "data" => $dados,
        "backgroundColor" => $backgroundColor,
        "borderColor" => $borderColor,
        "borderWidth" => 1
      )
    )
  ),
  "options" => array(
    "scales" => array(
      "yAxes" => array(
        array(
          "ticks" => array(
            "beginAtZero" => true
          )
        )
      )
    )
  )
);

//Grafico 02
$chart2 = array(
  "type" => "pie",
  "data" => array(
    "labels" => $rotulos2,
    "datasets" => array(
      array(
        "label" => "Quantidade de Livros Disponíveis",
        "data" => $dados2,
        "backgroundColor" => $backgroundColor2,
        "borderColor" => $borderColor2,
        "borderWidth" => 1
      )
    )
  ),
  "options" => array(
    "scales" => array(
      "yAxes" => array(
        array(
          "ticks" => array(
            "beginAtZero" => true
          )
        )
      )
    )
  )
);


//Converter esse objeto em uma string JSON
$chart_json = json_encode($chart);
$chart_json2 = json_encode($chart2);
//Quantidade de livros
$quantidade_livros = '<br>' . array_sum($dados2);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="../assets/css/Home.css?<?php echo rand(1, 1000); ?>">
  <title>HOME</title>
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
            <a class="nav-link active" aria-current="page" href="Sistema.php" style = "text-decoration:underline">INICIO</a>
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
  </nav>
  <div class="Graficos">
    <div class="graficos-container">
      <div class="grafico1">
        <label>Livros mais alugados</label>
        <canvas id="chart"></canvas>
      </div>
      <div class="Welcome">
        <h3 id="welcome">Olá <?php echo "<u>$logado</u>"; ?>,
          seja muito bem-vindo! Nosso compromisso é fornecer
          informações estratégicas precisas, apresentadas de
          forma clara e objetiva, por meio de gráficos e dados
          relevantes. Nossa missão é auxiliá-lo em suas
          decisões empresariais futuras, oferecendo informações
          confiáveis e valiosas que possam contribuir para o
          sucesso do seu negócio.</h3><br>
      </div>
      <div class="grafico2">
        <label>Livros Disponíveis</label>
        <canvas id="chart2"></canvas>
      </div>
    </div>
  </div>
  <div class="boxes">
    <div class="box box1">
      <a href="./Aluguel.php" style="text-decoration: none;">
        <img src="../assets/img/ultimo.png" width="76" height="76">
        <span class="text">Último Aluguel:</span>
        <span class="value"><?php echo $ultimo_aluguel; ?></span>
      </a>
    </div>

    <div class="box box2">
      <a href="./Livros.php" style="text-decoration: none;">
        <img src="../assets/img/estante.png" width="76" height="76">
        <span class="text">Total de livros disponíveis:</span><br>
        <span class="value"><?php echo $total_livros; ?></span>
      </a>
    </div>

    <div class="box box2">
      <a href="./Aluguel.php" style="text-decoration: none;">
        <img src="../assets/img/ativo.png" width="76" height="76">
        <span class="text">Total de alugueis Ativos::</span><br>
        <span class="value"><?php echo $quantidade_alugueis; ?></span>
      </a>
    </div>

    <div class="box box2">
      <a href="./Livros.php" style="text-decoration: none;">
        <img src="../assets/img/quantidade.jpg" width="76" height="76">
        <span class="text">Quantidade de livros:</span>
        <span class="value"><?php echo $quantidade_livros; ?></span>
      </a>
    </div>
    <div class="box box1">
      <a href="./Historico.php" style="text-decoration: none;">
        <img src="../assets/img/ultimod.png" width="76" height="76">
        <span class="text">Última devolução:</span>
        <span class="value"><?php echo $ultimo_devolvido; ?></span>
      </a>
    </div>
    <div class="box box2">
      <a href="./Historico.php" style="text-decoration: none;">
        <img src="../assets/img/noprazo.png" width="56" height="56">
        <span class="text">Entregues no prazo:</span><br>
        <span class="value"><?php echo $total_prazo; ?></span>
      </a>
    </div>
    <div class="box box2">
      <a href="./Historico.php" style="text-decoration: none;">
        <img src="../assets/img/atraso.png" width="56" height="56">
        <span class="text">Entregues com atraso:</span><br>
        <span class="value"><?php echo $total_foraprazo; ?></span>
      </a>
    </div>
  </div>

  <script>
    // Cria o gráfico com o objeto Chart.js
    var chart = new Chart(document.getElementById('chart'), <?php echo $chart_json; ?>);
    var chart = new Chart(document.getElementById('chart2'), <?php echo $chart_json2; ?>);
  </script>

</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
<script>
  // Seleciona o elemento h2
  const titulo = document.querySelector('#welcome');

  // Verifica se a largura da janela é menor que 1024px
  if (window.innerWidth <= 1024) {
    // Oculta o texto do h2
    titulo.style.display = 'none';
  }
</script>

</html>