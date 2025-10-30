<?php
session_start();
if (!isset($_SESSION['idUsuario']) || $_SESSION['idUsuario'] != 1) {
    header("Location: fazerLogin.php");
    exit();
}
require_once __DIR__ . "\classe\Aroma.php";
$aromas = Aroma::findAll();

if(isset($_POST['buttonDelete'])){

    $idAroma = $_POST['idAroma'] ?? 0;
    $a = new Aroma($_POST['nome'],$_POST['descricao']);
    $a->setIdAroma($idAroma);
    $a->delete();
    header("location: formAroma.php");
    exit();
         
}

if(isset($_POST['button'])){

    $idAroma = $_POST['idAroma'] ?? 0;
    $a = new Aroma($_POST['nome'],$_POST['descricao']);
    if($idAroma!=0){
        $a->setIdAroma($idAroma);
        $a->update();
        header("location: formAroma.php");
        exit();
    }else{
        $a->save();
        header("location: formAroma.php");
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
    <title>Aromas</title>
</head>
<body>
    
    <header class='head'>
        <a href="index.php" class="backBlack"><img src="arquivos/logo.png" alt="Logo Magnolia" class="logo"></a>
        <h1>Controle de Aromas</h1>
        <div class="header-right">
            <a href="restrita.php">Voltar</a>
        </div>
    </header>
         

    <main>
        <aside>
            <h2>Editar Aromas:</h2>
            <?php

            echo "<ul>";
                echo '<li><a href="formAroma.php?idAroma=0" class="verTodos">Novo</a></li>';
                foreach($aromas as $aroma){
                    echo "<li>
                        <a href='formAroma.php?idAroma={$aroma->getIdAroma()}'>{$aroma->getNome()}</a>
                    </li>";
                }
            echo "</ul>";
            ?>
        </aside>

        <section>
        <div class="formularioItem">
        <img src="arquivos/logo.png" alt="Logo Magnolia" class="logo">
        <form method= "POST" action ="formAroma.php">
        <?php
        if (isset($_GET['idAroma']) && $_GET['idAroma'] != 0) {

            $c=Aroma::find($_GET['idAroma']);

            echo '<input type="hidden" name="idAroma" value="' . $c->getIdAroma() . '">';


            echo'<div class="group">
                <label for=nome>Nome do Aroma</label>
                <input id="nome" type="text" name="nome" class="campo" value="' . htmlspecialchars($c->getNome()) . '" required>
            </div>

            <div class="groupleft">
                <label for=descricao>Descrição</label>
                <textarea id="descricao" name="descricao" class="campo" rows="6" required>' . htmlspecialchars($c->getDescricaoAroma()) . '</textarea>
            </div>';
        } elseif (!isset($_GET['idAroma']) || $_GET['idAroma'] == 0) {
            echo'<div class="group">
                <label for=nome>Nome do Aroma</label>
                <input id=nome type=text name=nome class=campo required>
            </div>

            <div class="groupleft">
                <label for=descricao>Descrição</label>
                <textarea id="descricao" name="descricao" class="campo" rows="6" required placeholder="Digite a descrição do aroma..."></textarea>
            </div>';
        }        
        ?>

        <?php
        if (!isset($_GET['idAroma']) || (isset($_GET['idAroma']) && $_GET['idAroma'] == 0)) {
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
