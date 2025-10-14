<?php
require_once __DIR__ . "\classe\Usuario.php";

session_start();
if(!isset($_SESSION['idUsuario'])){
    header("location:index.php");
    exit();
}

if(isset($_POST['button'])){
    if($_POST['senhaNew'] === $_POST['senhaConf']){
        
        $u = new Usuario($_SESSION['email'], '', $_SESSION['nome']);
        $u->setIdUsuario($_SESSION['idUsuario']);
        
        if($u->updatePassword($_POST['senhaOld'], $_POST['senhaNew'])){
            header("location: index.php");
            exit();
        } else {
            header("location: updateSenha.php?msg=false");
            exit();
        }

    } else {
        header("location: updateSenha.php?msg=false");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Mudar Senha</title>
</head>
<body>
    <section>
        <div class="formulario">
            <img src="arquivos/logo.png" alt="Logo Magnolia" class="logo">

            <form method="POST" action="updateSenha.php">
                <div class="group">
                    <label for="senhaOld">Senha Antiga</label>
                    <input id="senhaOld" type="password" name="senhaOld" required class="campo">
                </div>

                <div class="group">
                    <label for="senhaNew">Senha Nova</label>
                    <input id="senhaNew" type="password" name="senhaNew" required class="campo">
                </div>

                <div class="group">
                    <label for="senhaConf">Confirme a Senha</label>
                    <input id="senhaConf" type="password" name="senhaConf" required class="campo">
                </div>

                <div class="group_submit">
                    <input type="submit" name="button" value="Confirmar">
                </div>

                <?php
                if(isset($_GET['msg']) && $_GET['msg'] === 'false'){
                    echo '<p>Senha incorreta ou não confirmada!</p>';
                }
                ?>   
            </form>
            
            <a href="verPerfil.php">Voltar</a>
        </div>
    </section>

    <script>
        const url = new URL(window.location);
        if (url.searchParams.get("msg") === "false") {
            url.searchParams.set("msg", "true");
            window.history.replaceState({}, "", url);
        }
    </script>    
</body>
</html>
