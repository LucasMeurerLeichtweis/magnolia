<?php

if(isset($_POST['button'])){
    if($_POST['senha']==$_POST['senhaConf']){
    require_once __DIR__."\classe\Usuario.php";
    $u = new Usuario($_POST['email'],$_POST['senha'],$_POST['nome']);
    $u->save();
    header("location: fazerLogin.php");
    exit();
    }else{
        header("location: formCadUsuario.php?msg=false");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cadatro</title>
</head>
<body>
    <section class='janela'>
    <div class="formulario">
    <img src="arquivos/logo.png" alt="Logo Magnolia" class="logo">
    <form method= "POST" action ="formCadUsuario.php">

        <div class="group">
            <label for=nome>Nome</label>
            <input id=nome type=text name=nome class=campo>
        </div>

        <div class="group">
            <label for=email>E-mail</label>
            <input id=email type=email name=email class=campo>
        </div>

        <div class=group>
            <label for=senha>Senha</label>
            <input id=senha type=password name=senha required class=campo>
        </div>

        <div class=group>
            <label for=senhaConf>Confirme a Senha</label>
            <input id=senhaConf type=password name=senhaConf required class=campo>
        </div>

        <div class=group_submit>
            <input type=submit name=button value="Cadastrar" >
        </div>
        <?php
            if(isset($_GET['msg'])){
                if($_GET['msg'] === 'false'){
                    echo '<p>Senha não confirmada!</p>';
                }else{
                    echo '<p></p>';
                }
            }
        ?>   
    </form>
        
        <a href="fazerLogin.php">Voltar</a>
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