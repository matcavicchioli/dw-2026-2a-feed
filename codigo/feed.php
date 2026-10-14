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
    <!-- </div> --> // se nao fechar esta div as postagens fica centralizadas, nao sei pq
    <h3>FEED SEGUINDO</h3>
    <div class="postagens">
        <!-- sql1 = seleciona quem nao segue ninguem
         sql2 = meus posts
         sql3 = identifica o usuario
        resultado1 = pegar os resultados de quem nao segue
        resultado2 = meus posts -->
        <?php
        require_once "conexao.php";
        $banana = " TU NAO SEGUE NINGUEM";
        $ana = "vc SEGUE ALGUEM"; //pra printar se sigo ou nao
        // $sql_SA = "SELECT s1.idseguidor, s1.idseguindo FROM seguir s1 JOIN seguir s2 ON s1.idseguidor = s2.idseguindo AND s1.idseguindo = s2.idseguidor WHERE s1.idseguidor < s1.idseguindo;"
        $sql1 = "SELECT u.* FROM usuario u LEFT JOIN seguir s ON s.idseguidor = u.idusuario WHERE s.idseguindo IS NULL";
        $resultado1 = mysqli_query($conexao, $sql1);

        $quantidade = mysqli_num_rows($resultado1);

        $listaNAOSEGUEMNGM = mysqli_fetch_array($resultado1);
        $idusuario = ($_SESSION['idusuario']); // reduzindo a variavel
        $souumusuarioqnaosegueninguem = (in_array($idusuario, $listaNAOSEGUEMNGM)); // verificando se eu to na lista de quem nao segue ngm
        // $_SESSION['idusuario'] = $sigo['idusuario'];    
        if ($souumusuarioqnaosegueninguem == true) //se estou na lista (ou seja, nao sigo ngm) 
        {
            echo $banana;
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
            </div>
            <!-- INÍCIO DA POSTAGEM -->
            <div class="postagem">

                <!-- Cabeçalho -->
                <div class="cabecalho-postagem">

                    <img src="<?php echo $foto; ?>">
                    <span class="nome-usuario">
                        <?php echo $nome;?>
                    </span>

                    <span class="datahora">
                        <?php echo $data_hora; ?>
                    </span>

                </div>


                <!-- Texto da postagem -->
                <div class="texto-postagem">
                    <?php echo $texto; ?>
                </div>
                <?php
            }
        }
        else {

        }
        ?>
        <?php
        if ($souumusuarioqnaosegueninguem == false) //eu sigo alguem
        {
            echo $ana;
            // verificar quem eu sigo (select das pessoas que sigo e possuem post)
            //SE tais pessoas pussuirem posts, mostrar os posts(e ordenar. Futuramente a adição de uma dlc de botão que ordene os post de acordo com a escolha categorica do usuario).
            //SE NAO, falar pro usuario seguir alguem que tenha posts(possivel trabalho de outro grupo - mostrar usuarios que nao sigo e que possuem post e que sao recomendaveis o seguimento meritocrata do "eu". Afinal, quem é o "eu") 
        }
        ?>
    </div>
</body>

</html>