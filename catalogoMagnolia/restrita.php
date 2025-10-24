<?php
session_start();
if (!isset($_SESSION['idUsuario']) || $_SESSION['idUsuario'] != 1) {
    header("Location: fazerLogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <title>ADM</title>
</head>
<body>
    <section class='janela'>
        <div class='perfil'>
            <img src="arquivos/logo.png" alt="Logo Magnolia" class="logo">
            
            <div class="group">
            <a href="formProduto.php">Produtos</a>
            </div>

            <div class="group">
            <a href="formAroma.php">Aromas</a>
            </div>

            <div class="group">
            <a href="formCategoria.php">Categorias</a>
            </div>
            
            <div class="groupBack">
            <a href="index.php">Voltar</a>
            </div>
            
            
        </div>
    </section>
    
</body>
</html>
