<?php
require_once __DIR__ . "/classe/Imagem.php";
require_once __DIR__ . "/bd/MySQL.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idImagem'])) {
    $idImagem = (int) $_POST['idImagem'];
    $imagem = Imagem::find($idImagem);
    
    if ($imagem && $imagem->delete()) {
        echo "Imagem excluída com sucesso.";
    } else {
        echo "Erro ao excluir imagem.";
    }
} else {
    echo "Requisição inválida.";
}
