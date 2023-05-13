<?php

$dbhost = 'Localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'dblocadora';

$conexao = new mysqli($dbhost, $dbUsername, $dbPassword, $dbName);

/* if($conexao->connect_errno){
    echo "erro";
}else{
    echo "Deu Bom";
} */
if ($conexao->error) {
    die("Falha ao conectar ao Banco de dados: " . $conexao->error);
}