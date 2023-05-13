<?php 

$dbhost = 'Localhost';
$dbUsername = 'id20742095_pedro';
$dbPassword = '#WDAlivraria0';
$dbName ='id20742095_bdlocadora';

$conexao = new mysqli($dbhost,$dbUsername,$dbPassword,$dbName);

/* if($conexao->connect_errno){
    echo "erro";
}else{
    echo "Deu Bom";
} */
if($conexao -> error){
    die("Falha ao conectar ao Banco de dados: " .$conexao->error);
}

?>