<?php
require_once __DIR__ . "\classe\Usuario.php";

session_start();
if(!isset($_SESSION['idUsuario'])){
    header("location:index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Perfil</title>
</head>
<body>
    <section class='janela'>
        <div class='perfil'>
            <img src="arquivos/logo.png" alt="Logo Magnolia" class="logo">

            <?php
            
            echo '<p>Nome: '.htmlspecialchars($_SESSION["nome"]). '</p>';
            echo '<p>E-mail: '.$_SESSION['email'].'</p>';
            ?>
            
            <div class="group">
            <a href="sair.php">Sair da conta</a>
            </div>

            <div class="group">
            <a href="updateSenha.php">Mudar Senha</a>
            </div>
            
            <div class="groupBack">
            <a href="index.php">Voltar</a>
            </div>
            
            
        </div>
    </section>
</body>
</html>