<?php
require_once __DIR__."/classes/Item.php";
$itens = Item::findall();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restrita ADM</title>
</head>
<body>
    <h1>Itens perdidos</h1>
    
    <a href = "formCadItem.php" >Cadastra item</a>
</body>
</html>