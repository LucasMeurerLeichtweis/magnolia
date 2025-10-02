<?php

require_once __DIR__."\..\bd\MySQL.php";

class Produto{

    public int $idProduto;
    public int $idCategoria;

    public function __construct(public string $nome, public string $descricaoProduto, public float $preco, public string $foto) {
    }

    public function setIdProduto(int $idProduto):void{
        $this->idProduto = $idProduto;
    }

    public function getIdProduto():int{
        return $this->idProduto;
    }

    public function setIdCategoria(int $idProduto):void{
        $this->idCategoria = $idCategoria;
    }

    public function getIdCategoria():int{
        return $this->idCategoria;
    }

    
    public function setNome(string $nome):void{
        $this->nome = $nome;
    }

    public function setDescricaoProduto(string $descricaoProduto):void{
        $this->descricaoProduto = $descricaoProduto;
    }

    public function setPreco(float $preco):void{
        $this->preco = $preco;
    }

    public function setFoto(string $foto):void{
        $this->foto = $foto;
    }

    //------------------------------------------------------------


    public function getNome():string{
        return $this->nome;
    }

    public function getDescricaoProduto():string{
        return $this->descricaoProduto;
    }

    public function getPreco():float{
        return $this->preco;
    }

    public function getFoto():string{
        return $this->foto;
    }

    //-----------------------------------------------------------

     public function save():bool {
        $conexao = new MySQL();
        $sql = "INSERT INTO produto (nome, descricao, preco, foto, idCategoria) 
                VALUES (
                    '{$this->nome}', 
                    '{$this->descricaoProduto}', 
                    '{$this->preco}', 
                    '{$this->foto}', 
                    '{$this->idCategoria}'
                )";
        return $conexao->executa($sql);
    }


    public static function findAll(): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM produto";
        $resultados = $conexao->consulta($sql);
        $produtos = array();

        foreach ($resultados as $resultado) {
        
            $p = new Produto(
                $resultado['nome'], 
                $resultado['descricao'], 
                (float) $resultado['preco'], 
                $resultado['foto']
            );
            $p->idProduto = $resultado['idProduto'];
            $p->idCategoria = $resultado['idCategoria'];
            $produtos[] = $p;
        }

        return $produtos;
    }

    public static function findAllByCategoria(int $idCategoria): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM produto WHERE idCategoria = {$idCategoria}";
        $resultados = $conexao->consulta($sql);
        $produtos = array();

        foreach ($resultados as $resultado) {
            $p = new Produto(
                $resultado['nome'],
                $resultado['descricao'],
                (float) $resultado['preco'],
                $resultado['foto']
            );
            $p->idProduto = $resultado['idProduto'];
            $p->idCategoria = $resultado['idCategoria'];
            $produtos[] = $p;
        }

        return $produtos;
    }

    public static function find(int $idProduto): ?Produto {
    $conexao = new MySQL();
    $sql = "SELECT * FROM produto WHERE idProduto = {$idProduto}";
    $resultados = $conexao->consulta($sql);

    if (count($resultados) > 0) {
        $resultado = $resultados[0];
        $p = new Produto(
            $resultado['nome'],
            $resultado['descricao'],
            (float) $resultado['preco'],
            $resultado['foto']
        );
        $p->idProduto = $resultado['idProduto'];
        $p->idCategoria = $resultado['idCategoria'];
        return $p;
    }

        return null;
    }

    public function delete(): bool {
        $conexao = new MySQL();
        $sql = "DELETE FROM produto WHERE idProduto = {$this->idProduto}";
        return $conexao->executa($sql);
    }

    public function update(): bool {
        $conexao = new MySQL();
        $sql = "UPDATE produto 
            SET nome = '{$this->nome}', 
                descricao = '{$this->descricaoProduto}', 
                preco = '{$this->preco}', 
                foto = '{$this->foto}', 
                idCategoria = '{$this->idCategoria}'
            WHERE idProduto = {$this->idProduto}";
        return $conexao->executa($sql);
    }




}
