<?php
require_once __DIR__."/classes/Item.php";
$i = new Item("Casaco azul", "Quadra");
$i -> save();
$i2 = new Item("Cachecol azul", "Quadra");
$i2 -> save();
$i3 = new Item("Casaco rosa", "Quadra");
$i3 -> save();
Item::mudaStatus(2);
$itens = Item::findall();
var_dump($itens);
?>