<?php
$msg = "";
if(isset($_POST['button'])){
    require_once __DIR__."/classe/Usuario.php";
    $u = new Usuario($_POST['email'],$_POST['senha']);
    if($u->authenticate()){
        header("location: index.php");
        exit();
        
    }else{
        $msg='Usuario ou senha incorretos!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Fazer login</title>
</head>
<body>
    <section class='janela'>
    <div class="formulario">
    <img src="arquivos/logo.png" alt="Logo Magnolia" class="logo">
    <form method= "POST" action ="fazerLogin.php">
        <a><?=$msg?></a>
        <div class="group">
            <label for=email>E-mail</label>
            <input id=email type=email name=email class=campo>
        </div>

        <div class=group>
            <label for=senha>Senha</label>
            <input id=senha type=password name=senha required class=campo>
        </div>
        
        <div class=group_submit>
            <input type=submit name=button value="Entrar" >
        </div>   
    </form>
        <a href="cadUsuario.php">Cadastrar perfil</a>
        <a href="index.php">Voltar</a>
    </div>
    
    </section>    
</body>
</html>