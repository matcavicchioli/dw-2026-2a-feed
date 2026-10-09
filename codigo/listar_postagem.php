<?php require_once "verificar_sessao.php"; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de postagens</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <a href="principal.php"><button>voltar</button></a>
    <a href="index.php"><button>sair</button></a>

    <h2>INSTAGRADO</h2>

    <div class="postagens">
        <a href="cad_postagem.php"><button>POSTAR</button></a>

        <?php
        require_once "conexao.php";

        $sql = "SELECT * FROM postagem";
        $resultados = mysqli_query($conexao, $sql);

        while ($linha = mysqli_fetch_array($resultados)) {

            $idpostagem = $linha['idpostagem'];
            $texto = $linha['texto'];
            $data_hora = $linha['data_hora'];
            $idusuario = $linha['idusuario'];

            // Busca o usuário da postagem
            $sql2 = "SELECT * FROM usuario WHERE idusuario = $idusuario";
            $resultado = mysqli_query($conexao, $sql2);
            $usuario = mysqli_fetch_array($resultado);

            $foto = $usuario['foto'];
            $nome = $usuario['nome'];

            ?>

            <!-- INÍCIO DA POSTAGEM -->
            <div class="postagem">

                <!-- Cabeçalho -->
                <div class="cabecalho-postagem">

                    <img src="<?php echo $foto; ?>">

                    <span class="nome-usuario">
                        <?php echo $nome; ?>
                    </span>

                    <span class="datahora">
                        <?php echo $data_hora; ?>
                    </span>

                </div>


                <!-- Texto da postagem -->
                <div class="texto-postagem">
                    <?php echo $texto; ?>
                </div>


                <!-- Comentários -->
                <div class="comentarios">

                    <?php

                    $sql3 = "SELECT * FROM comentario WHERE idpostagem = $idpostagem";
                    $comentarios = mysqli_query($conexao, $sql3);

                    if (mysqli_num_rows($comentarios) == 0) {

                        echo "<p class='sem-comentarios'>Essa postagem não possui comentários.</p>";

                    } else {

                        while ($comentario = mysqli_fetch_array($comentarios)) {

                            $idusuario_comentario = $comentario['idusuario'];
                            $texto_comentario = $comentario['texto'];

                            // Busca o usuário do comentário
                            $sql4 = "SELECT * FROM usuario WHERE idusuario = $idusuario_comentario";
                            $resultado = mysqli_query($conexao, $sql4);
                            $usuario_comentario = mysqli_fetch_array($resultado);

                            $foto_usuario_comentario = $usuario_comentario['foto'];

                            ?>

                            <div class="comentario">

                                <img src="imagem_usuario/<?php echo $foto_usuario_comentario; ?>">

                                <span>
                                    <?php echo $texto_comentario; ?>
                                </span>

                            </div>

                            <?php
                        }
                    }

                    ?>


                    <!-- Formulário -->
                    <form action="salvar_comentario.php" method="POST">

                        <input
                            type="hidden"
                            name="idpostagem"
                            value="<?php echo $idpostagem; ?>"
                        >

                        <input
                            type="text"
                            name="texto"
                            placeholder="Digite seu comentário"
                            required
                        >

                        <input
                            type="submit"
                            value="Comentar"
                        >

                    </form>

                </div>

            </div>
            <!-- FIM DA POSTAGEM -->

            <?php
        }
        ?>

    </div>

</body>

</html>
