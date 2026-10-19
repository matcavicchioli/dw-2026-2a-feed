<?php require_once "verificar_sessao.php"; // quem sou eu? R ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h2>INSTAGRADO</h2>



    <div class="postagens">
        <a href="form_postagem.php"><button>POSTAR</button></a><br>
        <a href="listar_postagem.php" class="href"><button>VER TODAS AS POSTAGENS</button></a> <br>
        <a href="deslogar.php" class="href"><button>Sair...</button></a><br>
        <!-- </div>  se nao fechar esta div as postagens fica centralizadas, nao sei pq -->
        <h3>FEED SEGUINDO</h3>
        <div class="postagens">
            <!-- sql1 = seleciona quem nao segue ninguem
         sql2 = meus posts
         sql3 = procura comentario
         sql4 = tras os comentarios
         ta repetindo

        resultado1 = pegar os resultados de quem nao segue
        resultado2 = meus posts -->
            <?php
            require_once "conexao.php";
            
            $sql1 = "SELECT u.* FROM usuario u LEFT JOIN seguir s ON s.idseguidor = u.idusuario WHERE s.idseguindo IS NULL";
            $resultado1 = mysqli_query($conexao, $sql1);
            $listaNAOSEGUEMNGM = mysqli_fetch_array($resultado1);
            //  $quantidade = mysqli_num_rows($resultado1);
            $idusuario = ($_SESSION['idusuario']); // reduzindo a variavel
            $souumusuarioqnaosegueninguem = (in_array($idusuario, $listaNAOSEGUEMNGM)); // verificando se eu to na lista de quem nao segue ngm
            // $_SESSION['idusuario'] = $sigo['idusuario'];    
            if ($souumusuarioqnaosegueninguem == true) //se estou na lista (ou seja, nao sigo ngm) 
            {
                $sql2 = "SELECT postagem.idpostagem, postagem.texto, postagem.data_hora, postagem.idusuario, usuario.idusuario, usuario.nome, usuario.foto FROM postagem, usuario WHERE postagem.idusuario = $idusuario AND usuario.idusuario = $idusuario ORDER BY data_hora DESC";
                $resultado2 = mysqli_query($conexao, $sql2);
                while ($linha = mysqli_fetch_array($resultado2)) {
                    $idpostagem = $linha['idpostagem'];
                    $texto = $linha['texto'];
                    $data_hora = $linha['data_hora'];
                    $idusuario = $linha['idusuario'];
                    $foto = $linha['foto'];
                    $nome = $linha['nome'];
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
                                    $resultado4 = mysqli_query($conexao, $sql4);
                                    $usuario_comentario = mysqli_fetch_array($resultado4);

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

                                <input type="hidden" name="idpostagem" value="<?php echo $idpostagem; ?>">

                                <input type="text" name="texto" placeholder="Digite seu comentário" required>

                                <input type="submit" value="Comentar">
                                
                                

                            </form>

                        </div>
                    </div>
                    <?php
                }

            } else {
                //eu sigo alguem
                $sql5 = "SELECT seguir.idseguindo from seguir, usuario WHERE idseguidor = idusuario AND idusuario = $idusuario";
                // SELECT usuario.nome, seguir.idseguindo from seguir, usuario WHERE idseguidor = idusuario AND idusuario = $idusuario
                $resultado5 = mysqli_query($conexao, $sql5);
                $quantidadedepessoasquesigo = mysqli_num_rows($resultado5);
                echo "<br> <h1> Você segue $quantidadedepessoasquesigo pessoas </h1>";
                $sql6 = "SELECT p.idpostagem, p.texto, p.data_hora, u.idusuario, u.nome, u.foto FROM seguir s
                JOIN postagem p ON p.idusuario = s.idseguindo JOIN usuario u ON u.idusuario = p.idusuario
                WHERE s.idseguidor = $idusuario

                UNION

                SELECT p.idpostagem, p.texto, p.data_hora, u.idusuario, u.nome, u.foto
                FROM postagem p
                JOIN usuario u ON u.idusuario = p.idusuario
                WHERE p.idusuario = $idusuario
                ORDER BY data_hora DESC;";
                $resultado6 = mysqli_query($conexao, $sql6);
                

                    while ($linha = mysqli_fetch_array($resultado6)) {
                        $idpostagem = $linha['idpostagem'];
                        $texto = $linha['texto'];
                        $data_hora = $linha['data_hora'];
                        $idusuario = $linha['idusuario'];
                        $foto = $linha['foto'];
                        $nome = $linha['nome'];
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

                                $sql7 = "SELECT * FROM comentario WHERE idpostagem = $idpostagem";
                                $comentarios = mysqli_query($conexao, $sql7);

                                if (mysqli_num_rows($comentarios) == 0) {

                                    echo "<p class='sem-comentarios'>Essa postagem não possui comentários.</p>";

                                } else {

                                    while ($comentario = mysqli_fetch_array($comentarios)) {

                                        $idusuario_comentario = $comentario['idusuario'];
                                        $texto_comentario = $comentario['texto'];

                                        // Busca o usuário do comentário
                                        $sql8 = "SELECT * FROM usuario WHERE idusuario = $idusuario_comentario";
                                        $resultado8 = mysqli_query($conexao, $sql8);
                                        $usuario_comentario = mysqli_fetch_array($resultado8);

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

                                    <input type="hidden" name="idpostagem" value="<?php echo $idpostagem; ?>">

                                    <input type="text" name="texto" placeholder="Digite seu comentário" required>

                                    <input type="submit" value="Comentar">

                                </form>

                            </div>
                            <a href="excluir_postagem.php?idpostagem=<?php echo $idpostagem; ?>">excluir post</a>

                        </div>
                        <?php
                    }

                }
            
            // verificar quem eu sigo (select das pessoas que sigo e possuem post)
            //SE tais pessoas pussuirem posts, mostrar os posts(e ordenar. Futuramente a adição de uma dlc de botão que ordene os post de acordo com a escolha categorica do usuario).
            //SE NAO, falar pro usuario seguir alguem que tenha posts(possivel trabalho de outro grupo - mostrar usuarios que nao sigo e que possuem post e que sao recomendaveis o seguimento meritocrata do "eu". Afinal, quem é o "eu") 
            
            ?>
        </div>
</body>

</html>