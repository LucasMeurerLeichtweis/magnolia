<?php
require_once __DIR__ . "\classe\Categoria.php";
require_once __DIR__ . "\classe\Produto.php";
require_once __DIR__ . "\classe\Imagem.php";
$categorias = Categoria::findall();
$produtos = Produto::findall();

if(isset($_GET['idCategoria'])){
    if($_GET['idCategoria']==0){
        $produtos = Produto::findall();

    }else{
        $produtos = Produto::findAllByCategoria($_GET['idCategoria']);
        
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Magnólia</title>
</head>
<body>
    
    <header class='head'>
        <img src="arquivos/logo.png" alt="Logo Magnolia" class="logo">
        <div class="header-center">
            <h1>Catálogo Magnólia</h1>
        </div>
        <div class="header-right">
            <?php
                session_start();
                if (!isset($_SESSION['idUsuario'])) {
                    echo '<a href="fazerLogin.php">Entrar</a>';
                } else {
                    if ($_SESSION['idUsuario'] == 1) {
                        echo '<a href="restrita.php">Cadastrar Item</a>';
                    }
                    echo '<a href="verPerfil.php">Olá '.htmlspecialchars($_SESSION["nome"]). '!</a>';
                }
            ?>
        </div>
    </header>
         

    <main>
        <aside>
            <h2>Categorias:</h2>
            <?php

            echo "<ul>";
                echo '<li><a href="index.php?idCategoria=0" class="verTodos">Ver todos</a></li>';
                foreach($categorias as $categoria){
                    echo "<li>
                        <a href='index.php?idCategoria={$categoria->getIdCategoria()}'>{$categoria->getNome()}</a>
                    </li>";
                }
            echo "</ul>";
            ?>
        </aside>


        <section class="index">
            <header>
            <?php 
            if (isset($_GET['idCategoria']) && $_GET['idCategoria'] != 0) {
                $categoria = Categoria::find($_GET['idCategoria']);
                echo "<div><h1>".$categoria->getNome()."</h1></div>
                <div><p>".$categoria->getDescricaoCategoria()."</p></div>"; 
            }else{
                 echo "<div><h1>Ver Todos</h1></div>
                 <p>Encontre aqui o produto ideal para você!</p>";
            }
            ?>
            </header>
            
                    <?php if (count($produtos) != 0): ?>
                    <div class="containerIndex">
                        <?php foreach ($produtos as $produto): 
                            $img = Imagem::findFotoCapaById($produto->getIdProduto()); ?>
                            <div class="item">
                                <img src="arquivos/produtos/<?= $img->getImagem(); ?>" alt="<?= $img->getImagem(); ?>">
                                <h3><?= $produto->getNome(); ?></h3>
                                <h4>R$ <?= number_format($produto->getPreco(), 2, ",", "."); ?></h4>
                                <button type="button" onclick="window.location.href='viewProduto.php?idProduto=<?= $produto->getIdProduto(); ?>'">
                                    Ver Produto
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="containerIndex1">
                        <h2>Ops... Parece que ainda não temos produtos nesta categoria, volte em breve!</h2>
                    </div>
                <?php endif; ?>    
        </section>
    </main>

</body>
</html>
