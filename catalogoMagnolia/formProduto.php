        <?php
        session_start();
        if (!isset($_SESSION['idUsuario']) || $_SESSION['idUsuario'] != 1) {
            header("Location: fazerLogin.php");
            exit();
        }
        require_once __DIR__ . "/classe/Produto.php";
        require_once __DIR__ . "/classe/Categoria.php";
        require_once __DIR__ . "/classe/Aroma.php";
        require_once __DIR__ . "/classe/ProdutoAroma.php";
        require_once __DIR__ . "/classe/Imagem.php";

        $produtos = Produto::findAll();

        if(isset($_POST['buttonDelete'])){

            $idProduto = $_POST['idProduto'] ?? 0;

            if($idProduto != 0){
                produtoAroma::deleteByProduto($idProduto);

                $imagem = Imagem::findAllByProduto($idProduto);
                foreach ($imagem as $img) {
                    $diretorio = __DIR__ . '/arquivos/produtos/' . $img['nomeImagem'];
                    if (file_exists($diretorio)) {
                        unlink($diretorio);
                    }
                }
                Imagem::deleteByProduto($idProduto);

                Produto::deleteByIdProduto($idProduto);

                header("location: formProduto.php");
                exit();
                
            }
        }
        if(isset($_POST['button'])){
            $idProduto = $_POST['idProduto'] ?? 0;
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $preco = $_POST['preco'] ?? 0;
            $status = ($_POST['status'] === 'ativo') ? 1 : 0;
            $idCategoria = $_POST['categoria'] ?? 0;
            $aromasSelecionados = $_POST['aromas'] ?? [];


            $p = new Produto($nome, $descricao, $preco, $status);
            $p ->setIdCategoria($idCategoria);

            if($idProduto != 0){
                $p->setIdProduto($idProduto);
                $p->update();

                $prodAromasExistentes = ProdutoAroma::findByProduto($idProduto);
                foreach($prodAromasExistentes as $aroma){
                    $pe = new ProdutoAroma($aroma['idProduto'],$aroma['idAroma']);
                    $pe -> delete();
                }

                foreach ($aromasSelecionados as $idAroma) {
                    $a = new ProdutoAroma($idProduto, $idAroma);
                    $a->save();
                }
            }else{

                $p->save();
                $idProduto=$p->getIdProduto();

                foreach ($aromasSelecionados as $idAroma) {
                    $a = new ProdutoAroma($idProduto, $idAroma);
                    $a->save();
                }
            }

            if (isset($_POST['fotoCapa'])) {
                $fotoCapa = $_POST['fotoCapa'];


                if (str_starts_with($fotoCapa, 'existing-')) {
                $idImagemCapa = (int) str_replace('existing-', '', $fotoCapa);

                Imagem::ocultarByProduto($idProduto);
                $conexao = new MySQL();
                $sql = "UPDATE imagem SET fotoCapa = 1 WHERE idImagem = {$idImagemCapa}";
                $conexao->executa($sql);
            }
        }


            if (isset($_FILES['Imagens'])) {
            $fotos = $_FILES['Imagens'];
            $total = count($fotos['name']);

            for ($i = 0; $i < $total; $i++) {
                if ($fotos['error'][$i] === UPLOAD_ERR_OK) {
                    $nomeArquivo = time() . '_' . basename($fotos['name'][$i]);
                    $destino = __DIR__ . '/arquivos/produtos/' . $nomeArquivo;
                    move_uploaded_file($fotos['tmp_name'][$i], $destino);

                    $fotoCapa = (isset($_POST['fotoCapa']) && $_POST['fotoCapa'] == $i) ? 1 : 0;
                    $imagem = new Imagem($nomeArquivo, $fotoCapa);
                    $imagem->setIdProduto($idProduto);

                    
                    if ($fotoCapa) {
                        $imagem->ocultarByProduto($idProduto);
                        $imagem->setFotoCapa(1);
                    }

                    $imagem->save();
                }
            }
        }

        header("location: formProduto.php");
        exit();
                
        }//fim button
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

            <link rel="stylesheet" href="style.css">
            <title>Produtos</title>
        </head>
        <body>
            
            <header class='head'>
                <img src="arquivos/logo.png" alt="Logo Magnolia" class="logo">
                <h1>Controle de Produtos</h1>
                <div class="header-right">
                    <a href="restrita.php">Voltar</a>
                </div>
            </header>
                

            <main>
                
                <aside class='asideLimite'>
                    <h2>Editar Produtos:</h2>
                    <?php

                    echo "<ul>";
                        echo '<li><a href="formProduto.php?idProduto=0" class="verTodos">Novo</a></li>';
                        foreach($produtos as $produto){
                            echo "<li>
                                <a href='formProduto.php?idProduto={$produto->getIdProduto()}'>{$produto->getNome()}</a>
                            </li>";
                        }
                    echo "</ul>";
                    ?>
                    
                </aside>
                <section>
                
                <div class="formularioProduto">
                <img src="arquivos/logo.png" alt="Logo Magnolia" class="logo">
                <form method="POST" action="formProduto.php" enctype="multipart/form-data">

                <?php
                if (isset($_GET['idProduto']) && $_GET['idProduto'] != 0) {

                    $p=Produto::find($_GET['idProduto']);

                    $idProduto = $p->getIdProduto();

                    echo'<input type="hidden" name="idProduto" value="' . $_GET['idProduto'] . '">';


                    echo'<div class="group">
                        <label for=nome>Nome do Produto</label>
                        <input id="nome" type="text" name="nome" class="campo" value="' . htmlspecialchars($p->getNome()) . '">
                    </div>';

                    echo'<div class="groupleft">
                        <label for=descricao>Descrição</label>
                        <textarea id="descricao" name="descricao" class="campo" rows="6">' . htmlspecialchars($p->getDescricaoProduto()) . '</textarea>
                    </div>';

                    echo '<div class="group">
                        <label for=preco>Preço</label>
                        <input id="preco" type="number" step="0.01" name="preco" class="campo" value="' . htmlspecialchars($p->getPreco()) . '">
                    </div>';

                    echo '<div class="group">
                        <label for=status>Status</label>
                        <select id="status" name="status" class="campo">
                            <option value="ativo"' . ($p->getStatus() == 'ativo' ? ' selected' : '') . '>Ativo</option>
                            <option value="inativo"' . ($p->getStatus() == 'inativo' ? ' selected' : '') . '>Inativo</option>
                        </select>
                    </div>';

                    echo '<div class="group">
                        <label for="categoria">Categoria</label>
                        <select id="categoria" name="categoria" class="campo" placeholder="escolher">';
                        $categorias = Categoria::findAll();
                        foreach ($categorias as $categoria) {
                            if ($categoria->getIdCategoria()==$p->getIdCategoria()){
                                echo '<option selected value="' . $categoria->getIdCategoria() . '">' . htmlspecialchars($categoria->getNome()) . '</option>';
                            }else{
                                echo '<option value="' . $categoria->getIdCategoria() . '">' . htmlspecialchars($categoria->getNome()) . '</option>';
                            }         
                        }
                    echo '</select></div>';

                    
                    echo '<div class="group">
                        <label for="aromas">Aromas</label>
                        <div class="multiselect campo">
                            <div class="select-box" id="selectBox">Selecione os aromas</div>
                            <div class="options" id="options">';
                            $aromas = Aroma::findAll();
                            $aromasSelecionados = ProdutoAroma::findByProdutoAromas($idProduto);
                            foreach ($aromas as $aroma) {
                                if (in_array($aroma->getIdAroma(), $aromasSelecionados) ){

                                    echo '<label class="option">
                                        <input type="checkbox" checked name="aromas[]" value="' . $aroma->getIdAroma() . '">
                                        ' . htmlspecialchars($aroma->getNome()) . '
                                    </label>';

                                }else{

                                echo '<label class="option">
                                        <input type="checkbox" name="aromas[]" value="' . $aroma->getIdAroma() . '">
                                        ' . htmlspecialchars($aroma->getNome()) . '
                                    </label>';

                                }
                            }
                    echo '  </div>
                        </div>
                    </div>';

                    echo '<div class="group">
                        <label for="Imagens">Imagens</label>
                        <input type="file" name="Imagens[]" id="Imagens" multiple accept="image/*">
                    </div>

                    <table id="previewTable" class="preview-table">
                        <thead>
                            <tr>
                                <th>Prévia</th>
                                <th>Capa</th>
                                <th>Excluir</th>
                            </tr>
                        </thead>
                        <tbody>';
                        //Chamada das imagens já cadastradas:
    /*
                        $imagens = Imagem::findAllByProduto($idProduto);
                        foreach ($imagens as $imagem) {
                            if($imagem->getFotoCapa() == 1){
                                echo"<tr>
                                <td><img src='arquivos/produtos/".$imagem->getImagem()."' width='100' alt='".$imagem->getImagem()."'></td>
                                <td><input type='radio' value=".$imagem->getIdImagem()." checked name='fotoCapa'></td>
                                <td><button type='button' onclick='window.location.href=\"formProduto.php?idProduto=" . $idProduto . "&excluir=" . $imagem->getIdImagem() . "\"'>Excluir</button></td>
                                </tr>";
                            }else{
                                echo'<tr>
                                <td><img src="arquivos/produtos/'.$imagem->getImagem().'" width="100" alt="Prévia"></td>
                                <td><input type="radio" value='.$imagem->getIdImagem().' name="fotoCapa"></td>
                                <td><button type="button" onclick="window.location.href=\'formProduto.php?idProduto=' . $idProduto . '&excluir=' . $imagem->getIdImagem() . '\'">Excluir</button></td>
                                </tr>';
                            }
            
                        }
    */

                        echo '</tbody>
                    </table>';


                } elseif (!isset($_GET['idProduto']) || $_GET['idProduto'] == 0) {
                    echo '<div class="group">
                    <label for="nome">Nome do Produto</label>
                    <input id="nome" type="text" name="nome" class="campo">
                </div>

                <div class="groupleft">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" class="campo" rows="6" placeholder="Digite a descrição do produto..."></textarea>
                </div>';

            
                    echo '<div class="group">
                        <label for="preco">Preço</label>
                        <input id="preco" type="number" step="0.01" name="preco" class="campo">
                    </div>';

                    echo '<div class="group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="campo">
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>
                    </div>';

                    echo '<div class="group">
                        <label for="categoria">Categoria</label>
                        <select id="categoria" name="categoria" class="campo" placeholder="escolher">
                        <option value="" disabled selected>Selecione uma categoria</option>';
                        $categorias = Categoria::findAll();
                        foreach ($categorias as $categoria) {
                            echo '<option value="' . $categoria->getIdCategoria() . '">' . htmlspecialchars($categoria->getNome()) . '</option>';
                        }
                    echo '</select></div>';

                    echo '<div class="group">
                        <label for="aromas">Aromas</label>
                        <div class="multiselect campo">
                            <div class="select-box" id="selectBox">Selecione os aromas</div>
                            <div class="options" id="options">';
                            $aromas = Aroma::findAll();
                            foreach ($aromas as $aroma) {
                                echo '<label class="option">
                                        <input type="checkbox" name="aromas[]" value="' . $aroma->getIdAroma() . '">
                                        ' . htmlspecialchars($aroma->getNome()) . '
                                    </label>';
                            }
                    echo '  </div>
                        </div>
                    </div>';



            
                    echo '<div class="group">
                        <label for="Imagens">Imagens</label>
                        <input type="file" name="Imagens[]" id="Imagens" multiple accept="image/*">
                    </div>

                    <table id="previewTable" class="preview-table">
                        <thead>
                            <tr>
                                <th>Prévia</th>
                                <th>Capa</th>
                                <th>Excluir</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>';
                }
                ?>

                <?php
                if (!isset($_GET['idProduto']) || (isset($_GET['idProduto']) && $_GET['idProduto'] == 0)) {
                    echo'<div class=group_submit>
                        <input type=submit name=button value="Cadastrar" >
                    </div>';
                }elseif(isset($_GET['idProduto'])){
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



        <script>
            //Aromas
        const selectBox = document.getElementById('selectBox');
        const options = document.getElementById('options');

        selectBox.addEventListener('click', () => {
        options.style.display = options.style.display === 'block' ? 'none' : 'block';
        });

        options.addEventListener('change', () => {
        const selected = [...options.querySelectorAll('input:checked')]
            .map(ch => ch.parentElement.textContent.trim());
        selectBox.textContent = selected.length ? selected.join(', ') : 'Selecione os aromas';
        });

        document.addEventListener('click', e => {
        if (!e.target.closest('.multiselect')) options.style.display = 'none';
        });
        </script>

    <script>
    const fileInput = document.getElementById('Imagens');
    const tbody = document.querySelector('#previewTable tbody');

    let existingImages = [
        // Preencha com PHP no carregamento da página
        <?php
        $imagens = Imagem::findAllByProduto($idProduto ?? 0);
        foreach ($imagens as $img) {
            echo "{ src: 'arquivos/produtos/".$img->getImagem()."', idImagem: '".$img->getIdImagem()."', fotoCapa: ".$img->getFotoCapa()." },";
        }
        ?>
    ];

    let selectedFiles = []; // novas imagens

    // Função para renderizar a tabela
    function renderTable() {
        tbody.innerHTML = '';

        // Renderiza imagens existentes
        existingImages.forEach((img, idx) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><img src="${img.src}" width="100" alt="Prévia"></td>
                <td><input type="radio" name="fotoCapa" value="existing-${img.idImagem}" ${img.fotoCapa ? 'checked' : ''}></td>
                <td><button type="button" class="remove-existing-btn">Excluir</button></td>
            `;
            tbody.appendChild(row);

            row.querySelector('.remove-existing-btn').addEventListener('click', () => {
    if (confirm('Deseja realmente excluir esta imagem?')) {
        // Remove visualmente
        existingImages = existingImages.filter(imgItem => imgItem.idImagem !== img.idImagem);
        renderTable();

        // Chama exclusão no servidor
        console.log('Iniciando requisição de exclusão...', img.idImagem);
        fetch('deletaImagem.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `idImagem=${img.idImagem}`
        })
        .then(response => response.text())
        .then(res => console.log('Servidor:', res))
        .catch(err => console.error('Erro ao excluir:', err));

        console.log('Fetch disparado!');
    }
});
        });

        // Renderiza novas imagens
        selectedFiles.forEach((file, index) => {
            const row = document.createElement('tr');
            const reader = new FileReader();

            reader.onload = function(e) {
                row.innerHTML = `
                    <td><img src="${e.target.result}" width="100" alt="Prévia"></td>
                    <td><input type="radio" name="fotoCapa" value="new-${index}"></td>
                    <td><button type="button" class="remove-btn">Excluir</button></td>
                `;
                tbody.appendChild(row);

                row.querySelector('.remove-btn').addEventListener('click', () => {
                    selectedFiles.splice(index, 1);
                    renderTable();
                    updateInputFiles();
                });
            };

            reader.readAsDataURL(file);
        });
    }

    // Atualiza input.files com os arquivos selecionados
    function updateInputFiles() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(f => dataTransfer.items.add(f));
        fileInput.files = dataTransfer.files;
    }

    // Adiciona novos arquivos ao array e renderiza
    fileInput.addEventListener('change', (event) => {
        selectedFiles = selectedFiles.concat(Array.from(event.target.files));
        renderTable();
        updateInputFiles();
    });

    // Inicializa tabela com imagens existentes
    renderTable();
    </script>

    </body>
    </html>
