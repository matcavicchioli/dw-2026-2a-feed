<?php
require_once "conexao.php";

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'";

$resultado = mysqli_query($conexao, $sql);

$quantidade = mysqli_num_rows($resultado);

if ($quantidade == 1) {
    $usuario = mysqli_fetch_array($resultado);

    session_start();
    $_SESSION['idusuario'] = $usuario['idusuario'];
    $_SESSION['nome'] = $usuario['nome'];
    $_SESSION['apelido'] = $usuario['apelido'];
    $_SESSION['email'] = $usuario['email'];
    $_SESSION['foto'] = $usuario['foto'];

    header("Location: feed.php");
}
else {
    header("Location: index.php");
}
?>