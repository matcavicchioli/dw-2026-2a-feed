
<?php
require_once "verificar_sessao.php";
require_once "conexao.php";

$idusuario = $_SESSION['idusuario'];

// Temporariamente, mostra apenas as próprias postagens.
// Depois vamos incluir as postagens de quem o usuário segue.
$sql = "SELECT postagem.*, usuario.nome, usuario.foto
        FROM postagem
        INNER JOIN usuario
        ON postagem.idusuario = usuario.idusuario
        WHERE postagem.idusuario = $idusuario
        ORDER BY postagem.data_hora DESC";

$resultados = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed - INSTAGRADO</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <a href="principal.php"><button>Voltar</button></a>
    <a href="listarpostagem.php"><button>Listar postagens</button></a>
    <a href="index.php"><button>Sair</button></a>

    <h2>INSTAGRADO - FEED</h2>

    <div class="postagens">

        <?php
        if ($resultados && mysqli_num_rows($resultados) > 0) {

            while ($linha = mysqli_fetch_assoc($resultados)) {
                $idpostagem = $linha['idpostagem'];
                ?>

                <div class="postagem">

                    <div class="cabecalho-postagem">

                        <img src="<?php echo htmlspecialchars($linha['foto']); ?>">

                        <span class="nome-usuario">
                            <?php echo htmlspecialchars($linha['nome']); ?>
                        </span>

                        <span class="datahora">
                            <?php echo htmlspecialchars($linha['data_hora']); ?>
                        </span>

                    </div>

                    <div class="texto-postagem">
                        <?php echo htmlspecialchars($linha['texto']); ?>
                    </div>

                    <div class="comentarios">

                        <?php
                        $sql_comentarios = "SELECT comentario.*, usuario.nome, usuario.foto
                                            FROM comentario
                                            INNER JOIN usuario
                                            ON comentario.idusuario = usuario.idusuario
                                            WHERE comentario.idpostagem = $idpostagem";

                        $comentarios = mysqli_query($conexao, $sql_comentarios);

                        if ($comentarios && mysqli_num_rows($comentarios) > 0) {

                            while ($comentario = mysqli_fetch_assoc($comentarios)) {
                                ?>

                                <div class="comentario">

                                    <img src="imagem_usuario/<?php
                                        echo htmlspecialchars($comentario['foto']);
                                    ?>">

                                    <span>
                                        <strong>
                                            <?php echo htmlspecialchars($comentario['nome']); ?>:
                                        </strong>

                                        <?php echo htmlspecialchars($comentario['texto']); ?>
                                    </span>

                                </div>

                                <?php
                            }

                        } else {
                            echo "<p class='sem-comentarios'>Essa postagem não possui comentários.</p>";
                        }
                        ?>

                        <form action="salvar_comentario.php" method="POST">

                            <input type="hidden" name="idpostagem"
                                value="<?php echo $idpostagem; ?>">

                            <input type="text" name="texto"
                                placeholder="Digite seu comentário" required>

                            <input type="submit" value="Comentar">

                        </form>

                    </div>

                </div>

                <?php
            }

        } else {
            echo "<p>Você ainda não publicou nada.</p>";
        }
        ?>

    </div>

</body>
</html>