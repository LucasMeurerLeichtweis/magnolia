<?php

require_once __DIR__ . "\..\bd\MySQL.php";

class ProdutoAroma {

    

    public function __construct(
        private int $idProduto,
        private int $idAroma
    ) {
        
    }

    public function getIdProduto(): int {
         return $this->idProduto; 
        }
    public function getIdAroma(): int {
         return $this->idAroma; 
        }

    public function setIdProduto(int $idProduto): void {
         $this->idProduto = $idProduto; 
        }
    public function setIdAroma(int $idAroma): void {
         $this->idAroma = $idAroma; 
        }

    public function save(): bool {
        $conexao = new MySQL();
        $sql = "INSERT INTO produto_aroma (idProduto, idAroma) VALUES ('{$this->idProduto}', '{$this->idAroma}')";
        return $conexao->executa($sql);
    }

    public static function findAll(): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM produto_aroma";
        $resultados = $conexao->consulta($sql);
        $produtoAromas = [];

        foreach ($resultados as $resultado) {
            $pa = new ProdutoAroma(
                $resultado['idProduto'],
                $resultado['idAroma']
            );
            $produtoAromas[] = $pa;
        }

        return $produtoAromas;
    }

    public static function findByProdutoAromas(int $idProduto): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM produto_aroma WHERE idProduto = {$idProduto}";
        $resultados = $conexao->consulta($sql);
        $produtoAromas = [];

        foreach ($resultados as $resultado) {
            $produtoAromas[] = $resultado['idAroma'];
        }
        return $produtoAromas;
    }    


    public static function findByProduto(int $idProduto): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM produto_aroma WHERE idProduto = {$idProduto}";
        return $conexao->consulta($sql);
    }

    public static function findByAroma(int $idAroma): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM produto_aroma WHERE idAroma = {$idAroma}";
        return $conexao->consulta($sql);
    }

    public function delete(): bool {
        $conexao = new MySQL();
        $sql = "DELETE FROM produto_aroma WHERE idProduto = {$this->idProduto} AND idAroma = {$this->idAroma}";
        return $conexao->executa($sql);
    }
    public static function deleteByProduto(int $idProduto): bool {
        $conexao = new MySQL();
        $sql = "DELETE FROM produto_aroma WHERE idProduto = {$idProduto}";
        return $conexao->executa($sql);
    }
}
