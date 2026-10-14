<?php
    require_once "verificar_sessao.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="estilizar.css">
</head>
<body class="body2">
    <form action="salvar_postagem.php" class="form">
        <div class="texto">Texto:</div> <br>
        <input type="text" name="texto" class="input"> <br><br>

        <input type="submit" value="Publicar" class="button" class="button">
    </form>
</body>
</html>