<?php

session_start();
if (!isset($_SESSION['idUsuario'])) {
    header("Location: index.php");
    exit();
}
require_once __DIR__ . "\classe\Categoria.php";
require_once __DIR__ . "\classe\Produto.php";
require_once __DIR__ . "\classe\ProdutoAroma.php";
require_once __DIR__ . "\classe\Imagem.php";
require_once __DIR__ . "\classe\Aroma.php";
require_once __DIR__ . "\classe\Avaliacao.php";
$produto = Produto::find($_GET["idProduto"]);
$categoria = Categoria::find($produto->getIdCategoria());
if(isset($_POST['button'])){
    $av = new Avaliacao($_POST['nota'],
    $_POST['descricao'],
    $produto->getIdProduto(),
    $_SESSION['idUsuario']);
    $av->save();
    header("location: viewProduto.php?idProduto={$produto->getIdProduto()}");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Produto: <?= $produto->getNome(); ?></title>
</head>
<body>
    
    <header class='head'>
        <a href="index.php" class="backBlack"><img src="arquivos/logo.png" alt="Logo Magnolia" class="logo"></a>
        <div class="header-center">
            <h1><?= $categoria->getNome(); ?>: <?= $produto->getNome(); ?></h1>
            <h2><?= $produto->getDescricaoProduto(); ?></h2>
        </div>
        <div class="header-right">
            <a href="viewProduto.php?idProduto=<?=$produto->getIdProduto()?>">Voltar</a>
        </div>
    </header>
         

    <main>
        <section class="index">
            <form method= "POST" action ="formAvaliacao.php?idProduto=<?=$produto->getIdProduto()?>">

                <div class="group">
                    <label for="nota">Nota</label>
                    <input id="nota" type="number" name="nota" class="campo" min="0" max="5" step="0.5" placeholder="Digite uma nota entre 0 e 5..." required>
                </div>

                <div class="groupleft">
                    <label for=descricao>Descrição</label>
                    <textarea id="descricao" name="descricao" class="campo" rows="6" placeholder="Avalie nosso produto..." required></textarea>
                </div>

                <div class=group_submit>
                    <input type=submit name=button value="Enviar Avaliação" >
                </div>   
            </form>
        </section>
    </main>

</body>
</html>
