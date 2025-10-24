<?php
session_start();
if (!isset($_SESSION['idUsuario']) || $_SESSION['idUsuario'] != 1) {
    header("Location: fazerLogin.php");
    exit();
}
require_once __DIR__ . "\classe\Categoria.php";
$categorias = Categoria::findAll();

if(isset($_POST['buttonDelete'])){

    $idCategoria = $_POST['idCategoria'] ?? 0;
    $c = new Categoria($_POST['nome'],$_POST['descricao']);
    $c->setIdCategoria($idCategoria);
    $c->delete();
    header("location: formCategoria.php");
    exit();
         
}

if(isset($_POST['button'])){

    $idCategoria = $_POST['idCategoria'] ?? 0;
    $c = new Categoria($_POST['nome'],$_POST['descricao']);
    if($idCategoria!=0){
        $c->setIdCategoria($idCategoria);
        $c->update();
        header("location: formCategoria.php");
        exit();
    }else{
        $c->save();
        header("location: formCategoria.php");
        exit();
    }
         
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Categorias</title>
</head>
<body>
    
    <header class='head'>
        <img src="arquivos/logo.png" alt="Logo Magnolia" class="logo">
        <h1>Controle de Categorias</h1>
        <div class="header-right">
            <a href="restrita.php">Voltar</a>
        </div>
    </header>
         

    <main>
        <aside>
            <h2>Editar Categorias:</h2>
            <?php

            echo "<ul>";
                echo '<li><a href="formCategoria.php?idCategoria=0" class="verTodos">Novo</a></li>';
                foreach($categorias as $categoria){
                    echo "<li>
                        <a href='formCategoria.php?idCategoria={$categoria->getIdCategoria()}'>{$categoria->getNome()}</a>
                    </li>";
                }
            echo "</ul>";
            ?>
        </aside>
                
        <section>
        <div class="formularioItem"> 
        <img src="arquivos/logo.png" alt="Logo Magnolia" class="logo">
        <form method= "POST" action ="formCategoria.php">
        <?php
        if (isset($_GET['idCategoria']) && $_GET['idCategoria'] != 0) {

            $c=Categoria::find($_GET['idCategoria']);

            echo '<input type="hidden" name="idCategoria" value="' . $c->getIdCategoria() . '">';


            echo'<div class="group">
                <label for=nome>Nome da Categoria</label>
                <input id="nome" type="text" name="nome" class="campo" value="' . htmlspecialchars($c->getNome()) . '" required>
            </div>

            <div class="groupleft">
                <label for=descricao>Descrição</label>
                <textarea id="descricao" name="descricao" class="campo" rows="6" required>' . htmlspecialchars($c->getDescricaoCategoria()) . ' </textarea>
            </div>';
        } elseif (!isset($_GET['idCategoria']) || $_GET['idCategoria'] == 0) {
            echo'<div class="group">
                <label for=nome>Nome da Categoria</label>
                <input id=nome type=text name=nome class=campo required>
            </div>

            <div class="groupleft">
                <label for=descricao>Descrição</label>
                <textarea id="descricao" name="descricao" class="campo" rows="6" placeholder="Digite a descrição da categoria..." required></textarea>
            </div>';
        }        
        ?>

        <?php
        if (!isset($_GET['idCategoria']) || (isset($_GET['idCategoria']) && $_GET['idCategoria'] == 0)) {
            echo'<div class=group_submit>
                <input type=submit name=button value="Cadastrar" >
            </div>';
        }else{
            echo'<div class=group_submit>
                <input type=submit name=button value="Salvar" >
                <input type=submit name=buttonDelete value="Excluir" >
            </div>';
            
        }

        
        ?>
        
        </form>
        
        </div>
        </section>
    </main>

</body>
</html>
