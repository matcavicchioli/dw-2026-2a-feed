<?php
    require_once "verificar_sessao.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="salvar_postagem.php" class="form">
        Texto: <br>
        <input type="text" name="texto"> <br><br>

        <input type="submit" value="Publicar" class="button">
    </form>
</body>
</html>