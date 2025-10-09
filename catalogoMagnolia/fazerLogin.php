<?php
if(isset($_POST["button"])){
    require_once __DIR__. "/classes/Usuario.php";
    $u = new Usuario($_POST["email"], $_POST["senha"]);
    if($u->authenticate()){
        header("location: restrita.php");
    }else{
         header("location: fazerLogin.php");
     }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fazer login</title>
</head>
<body>
    <form method= "POST" action ="fazerLogin.php">
        <label for = "email"> e-mail</label>
        <input type = "email" name= "email" id = "email" required>
        <label for = "senha"> senha:</label>
        <input type = "password" name= "senha" id = "senha" required>

        <input type = "submit" name = "button" value = "Entrar" required>
        
</body>
</html>