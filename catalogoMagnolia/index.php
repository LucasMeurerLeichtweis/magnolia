<?php
require_once __DIR__ . "\classe\Categoria.php";
require_once __DIR__ . "\classe\Produto.php";
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
        <h1>Catálogo Magnólia</h1>
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


        <section>

            <?php 
            $categoria = Categoria::find($_GET['idCategoria']);
            echo "<p>".$categoria->getDescricaoCategoria()."</p>";            
            ?>

            <p></p>
            <div class='container'>

                <?php
                    foreach($produtos as $produto){
                        Echo '<div class="item"></div>';
                    }
                ?>
            </div>
            
        </section>
    </main>

</body>
</html>
