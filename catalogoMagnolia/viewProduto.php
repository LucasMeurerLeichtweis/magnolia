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
require_once __DIR__ . "\classe\Usuario.php";

$produto = Produto::find($_GET["idProduto"]);
$categoria = Categoria::find($produto->getIdCategoria());
$imagens = Imagem::findAllByProduto($produto->getIdProduto());
$aromas = ProdutoAroma::findByProdutoAromas($produto->getIdProduto());
$avaliacoes = Avaliacao::findAllByProduto($produto->getIdProduto());

//Troca de imagem
$chaveContador = 'contador_' . $produto->getIdProduto();
if (!isset($_SESSION[$chaveContador])) {
    $_SESSION[$chaveContador] = 0;
}


if (isset($_POST['proximo'])) {
    $_SESSION[$chaveContador]++;
    header("Location: viewProduto.php?idProduto=".$produto->getIdProduto());
    exit();
} elseif (isset($_POST['anterior'])) {
    $_SESSION[$chaveContador]--;
    header("Location: viewProduto.php?idProduto=".$produto->getIdProduto());
    exit();
}

$totalImagens = count($imagens);
if ($totalImagens > 0) {
    $_SESSION[$chaveContador] = ($_SESSION[$chaveContador] + $totalImagens) % $totalImagens;
    $indice = $_SESSION[$chaveContador];
    $imagemAtual = $imagens[$indice];
} else {
    $imagemAtual = null;
}


$mostrarAvaliacao = isset($_GET['mostrar']) ? (int) $_GET['mostrar'] : 1;

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
            <a href="index.php">Voltar</a>
        </div>
    </header>
         

    <main>
        <section class="index">
            
            <div class="image-container">
                <form method="post">
                    <button type="submit" name="anterior">⟵</button>
                </form>

                <?php if ($imagemAtual): ?>
                    <img src="arquivos/produtos/<?= $imagemAtual->getImagem(); ?>" alt="Imagem do produto">
                <?php else: ?>
                    <p>Nenhuma imagem disponível.</p>
                <?php endif; ?>

                <form method="post">
                    <button type="submit" name="proximo">⟶</button>
                </form>
            </div>

            <div class="produto-info">
                <div class="info-item">
                    <h3>Nome do Produto:</h3>
                    <p><?= $produto->getNome(); ?></p>
                </div>

                <div class="info-item">
                    <h3>Preço:</h3>
                    <p>R$ <?= number_format($produto->getPreco(), 2, ",", "."); ?></p>
                </div>

                <div class="info-item">
                    <h3>Descrição:</h3>
                    <p><?= $produto->getDescricaoProduto(); ?></p>
                </div>

                <div class="info-item">
                    <h3>Aromas disponíveis:</h3>
                    <p><?php 
                    foreach($aromas as $IdAroma){
                        $aromaLista = Aroma::find($IdAroma);
                        echo "- " . htmlspecialchars($aromaLista->getNome()) . "<br>";
                    } 
                    ?></p>
                </div> 
            </div>


            
            <a href="viewProduto.php?idProduto=<?= $produto->getIdProduto(); ?>&mostrar=<?= $mostrarAvaliacao ? 0 : 1; ?>" class="botao-toggle">
                <?= $mostrarAvaliacao ? 'Ocultar Avaliações' : 'Mostrar Avaliações'; ?>
            </a>

            <?php if ($mostrarAvaliacao): ?>
                <div class="produto-avaliacao">
                    <?php 
                        if(count($avaliacoes) > 0){
                        foreach($avaliacoes as $avaliacao){
                            $usuario = Usuario::find($avaliacao->getIdUsuario());
                            $dataFormatada = date("d/m/Y", strtotime($avaliacao->getData()));
                            echo "<div class='item-avaliacao'>
                                <div class='item-avaliacao-head'>
                                    <p>".htmlspecialchars($usuario->getNome())."</p>
                                    <p>".number_format($avaliacao->getNota(), 2, '.', ',')." / 5.00</p>
                                </div>
                                <div class='item-avaliacao-body'>
                                    ".htmlspecialchars($avaliacao->getDescricaoAvaliacao())."
                                    <p>$dataFormatada</p>
                                </div>
                            </div>";
                        }
                        }else{
                            echo "<h3>OPS!<br>Parece que não temos nenhum comentário neste produto...<br>
                            Seja você o primeiro!</h3>";
                        }   
                    ?>
            </div>
            <?php endif; ?>
            
            <div class="info-item-a">
                <a href="formAvaliacao.php?idProduto=<?=$produto->getIdProduto()?>">Avaliar Produto</a>
            </div>



        </section>
    </main>

</body>
</html>
