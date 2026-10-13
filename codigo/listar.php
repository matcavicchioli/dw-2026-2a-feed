<?php require_once "verificar_sessao.php"; // quem sou eu? R?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>INSTAGRADO</h2>

    <div class="postagens">
        <a href="form_postagem.php"><button>POSTAR</button></a>

        <?php
        require_once "conexao.php";
        $banana = " TU NAO SEGUE NINGUEM";
        $ana = "vc SEGUE ALGUEM";
        // $sql_SA = "SELECT s1.idseguidor, s1.idseguindo FROM seguir s1 JOIN seguir s2 ON s1.idseguidor = s2.idseguindo AND s1.idseguindo = s2.idseguidor WHERE s1.idseguidor < s1.idseguindo;"
        $sql_SA = "SELECT u.* FROM usuario u LEFT JOIN seguir s ON s.idseguidor = u.idusuario WHERE s.idseguindo IS NULL";
        $resultado = mysqli_query($conexao, $sql_SA);

        $quantidade = mysqli_num_rows($resultado);

        $NAOsigoNINGUEM = mysqli_fetch_array($resultado);
        $tomalucoja = ($_SESSION['idusuario']);
        $souumusuarioqnaosegueninguem = (in_array($tomalucoja, $NAOsigoNINGUEM));
        // $_SESSION['idusuario'] = $sigo['idusuario'];    
        if ($souumusuarioqnaosegueninguem == true) {
            echo $banana;

        }
        else {
            echo $ana;
            // verificar quem eu sigo (select das pessoas que sigo e possuem post)
            //SE tais pessoas pussuirem posts, mostrar os posts(e ordenar. Futuramente a adição de uma dlc de botão que ordene os post de acordo com a escolha categorica do usuario).
            //SE NAO, falar pro usuario seguir alguem que tenha posts(possivel trabalho de outro grupo - mostrar usuarios que nao sigo e que possuem post e que sao recomendaveis o seguimento meritocrata do "eu". Afinal, quem é o "eu") 
        }
        ?>
    </div>
</body>
</html>