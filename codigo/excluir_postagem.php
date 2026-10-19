<?php require_once "conexao.php";
// excluir postagem
//1 pegar o id da postagem que vai ser excluida
//2 criar o sql para excluir a postagem
//3 executar o sql
//3.1 apagar os comentarios da postagem
//3.1,5 pegar o id dos comentarios, fazer um loop (if) e apagar os comentarios um por um
//3.2 apagar os likes da postagem
//4 redirecionar para o feed
$idpostagem = $_GET["idpostagem"];

$sql = "SELECT * FROM postagem WHERE idpostagem = $idpostagem;";
$sql1 = mysqli_query($conexao, $sql);
$sql2 = "SELECT * FROM comentario WHERE idpostagem = $idpostagem;";
$sql3 = mysqli_query($conexao, $sql2);
    if (mysqli_num_rows($sql1) > 0) {
        $sql4 = "DELETE FROM postagem WHERE idpostagem = $idpostagem;";
        mysqli_query($conexao, $sql4);
        if (mysqli_num_rows($sql3) > 0) {
            while ($linha = mysqli_fetch_array($sql3)) {
                $idcomentario = $linha['idcomentario'];
                $sql5 = "DELETE FROM comentario WHERE idcomentario = $idcomentario;";
                mysqli_query($conexao, $sql5);
            }
        }
    }
header("Location: feed.php");
?>