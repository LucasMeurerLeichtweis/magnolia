<?php

require_once __DIR__ . "\..\bd\MySQL.php";
require_once __DIR__ ."\Categoria.php";
class Produto {

    private int $idProduto;
    private int $idCategoria;

    public function __construct(
        private string $nome,
        private string $descricaoProduto,
        private float $preco,
        private int $status = 1
    ){     
    }

    public function getIdProduto(): int {
        return $this->idProduto;
    }

    public function getIdCategoria(): int {
        return $this->idCategoria;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getDescricaoProduto(): string {
        return $this->descricaoProduto;
    }

    public function getPreco(): float {
        return $this->preco;
    }

    public function getStatus(): int {
        return $this->status;
    }

    public function setIdProduto(int $idProduto): void {
        $this->idProduto = $idProduto;
    }

    public function setIdCategoria(int $idCategoria): void {
        $this->idCategoria = $idCategoria;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function setDescricaoProduto(string $descricaoProduto): void {
        $this->descricaoProduto = $descricaoProduto;
    }

    public function setPreco(float $preco): void {
        $this->preco = $preco;
    }

    public function setStatus(int $status): void {
        $this->status = $status;
    }



    public function save(): bool {
    $conexao = new MySQL();
    $sql = "INSERT INTO produto (nome, descricaoProduto, preco, idCategoria, status) 
            VALUES (
                '{$this->nome}', 
                '{$this->descricaoProduto}', 
                '{$this->preco}',  
                '{$this->idCategoria}', 
                '{$this->status}'
            )";
        $executou = $conexao->executa($sql);

        if ($executou) {
            $this->idProduto = $conexao->getUltimoIdInserido();
            return true;
        }

        return false;
    }


    public static function findAll(): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM produto ORDER BY nome ASC";
        $resultados = $conexao->consulta($sql);
        $produtos = [];

        foreach ($resultados as $resultado) {
            $p = new Produto($resultado['nome'], $resultado['descricaoProduto'], $resultado['preco'],$resultado['status']);
            $p->setIdProduto($resultado['idProduto']);
            $p->setIdCategoria($resultado['idCategoria']);
            $produtos[] = $p;
        }

        return $produtos;
    }


    public static function findAllByCategoria(int $idCategoria): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM produto WHERE idCategoria = {$idCategoria} AND status = 1";
        $resultados = $conexao->consulta($sql);
        $produtos = [];

        foreach ($resultados as $resultado) {
            $p = new Produto(
                $resultado['nome'],
                $resultado['descricaoProduto'],
                $resultado['preco'],
                $resultado['status']
            );
            $p->setIdProduto($resultado['idProduto']);
            $p->setIdCategoria($resultado['idCategoria']);
            $produtos[] = $p;
        }

        return $produtos;
    }

    public static function find(int $idProduto): ?Produto {
        $conexao = new MySQL();
        $sql = "SELECT * FROM produto WHERE idProduto = {$idProduto} LIMIT 1";
        $resultados = $conexao->consulta($sql);

        if (count($resultados) > 0) {
            $resultado = $resultados[0];
            $p = new Produto(
                $resultado['nome'],
                $resultado['descricaoProduto'],
                $resultado['preco'],
                $resultado['status']
            );
            $p->setIdProduto($resultado['idProduto']);
            $p->setIdCategoria($resultado['idCategoria']);
            return $p;
        }

        return null;
    }


    public function delete(): bool {
        $conexao = new MySQL();
        $sql = "DELETE FROM produto WHERE idProduto = {$this->idProduto}";
        return $conexao->executa($sql);
    }

    public function ocultar(): bool {
        $conexao = new MySQL();
        $sql = "UPDATE produto SET status = 0 WHERE idProduto = {$this->idProduto}";
        return $conexao->executa($sql);
    }

    public function update(): bool {
        $conexao = new MySQL();
        $sql = "UPDATE produto 
                SET nome = '{$this->nome}', 
                    descricaoProduto = '{$this->descricaoProduto}', 
                    preco = '{$this->preco}',  
                    idCategoria = '{$this->idCategoria}',
                    status = '{$this->status}'
                WHERE idProduto = {$this->idProduto}";
        return $conexao->executa($sql);
    }

    public static function deleteByIdProduto(int $idProduto): bool {
    $conexao = new MySQL();
    $sql = "DELETE FROM produto WHERE idProduto = {$idProduto}";
    return $conexao->executa($sql);
    }

}
