<?php
require_once "verificar_sessao.php";
require_once "conexao.php";

$idpostagem = $_POST['idpostagem'];
$texto = $_POST['texto'];

$idusuario = $_SESSION['idusuario'];


$sql = "INSERT INTO comentario (idpostagem, idusuario, texto) VALUES ('$idpostagem', '$idusuario', '$texto')";

mysqli_query($conexao, $sql);

header("Location: listar_postagem.php");

?>
