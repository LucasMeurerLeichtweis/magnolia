<?php

require_once __DIR__ . "\..\bd\MySQL.php";

class Imagem {

    private int $idImagem;
    private int $idProduto;

    public function __construct(
        private string $imagem,
        private int $fotoCapa 
    ){     
    }

    public function getIdImagem(): int {
        return $this->idImagem;
    }

    public function getIdProduto(): int {
        return $this->idProduto;
    }

    public function getImagem(): string {
        return $this->imagem;
    }

    public function getFotoCapa(): int {
        return $this->fotoCapa;
    }

    
    public function setIdImagem(int $idImagem): void {
        $this->idImagem = $idImagem;
    }

    public function setIdProduto(int $idProduto): void {
        $this->idProduto = $idProduto;
    }

    public function setImagem(string $imagem): void {
        $this->imagem = $imagem;
    }

    public function setFotoCapa(int $fotoCapa): void {
        $this->fotoCapa = $fotoCapa;
    }

//-------------------------

    public function save(): bool {
        $conexao = new MySQL();
        $sql = "INSERT INTO imagem (idProduto, imagem, fotoCapa) 
                VALUES (
                    '{$this->idProduto}',
                    '{$this->imagem}', 
                    '{$this->fotoCapa}'
                )";
        return $conexao->executa($sql);
    }

    public static function findAll(): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM imagem";
        $resultados = $conexao->consulta($sql);
        $imagens = [];

        foreach ($resultados as $resultado) {
            $p = new Imagem(
                $resultado['imagem'], 
                $resultado['fotoCapa']
            );
            $p->setIdProduto($resultado['idProduto']);
            $p->setIdImagem($resultado['idImagem']);
            $imagens[] = $p;
        }

        return $imagens;
    }

    public static function findAllByProduto(int $idProduto): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM imagem WHERE idProduto = {$idProduto}";
        $resultados = $conexao->consulta($sql);
        $imagens = [];

        foreach ($resultados as $resultado) {
            $p = new Imagem(
                $resultado['imagem'], 
                $resultado['fotoCapa']
            );
            $p->setIdProduto($resultado['idProduto']);
            $p->setIdImagem($resultado['idImagem']);
            $imagens[] = $p;
        }

        return $imagens;
    }

    public static function findFotoCapaById(int $idProduto): ?Imagem {
        $conexao = new MySQL();
        $sql = "SELECT * FROM imagem 
                WHERE idProduto = {$idProduto} AND fotoCapa = 1
                LIMIT 1";
        $resultado = $conexao->consulta($sql);

        if (empty($resultado)) {
            return null;
        }

        $r = $resultado[0];
        $img = new Imagem(
            $r['imagem'], 
            $r['fotoCapa']
        );
        $img->setIdProduto($r['idProduto']);
        $img->setIdImagem($r['idImagem']);

        return $img;
    }

    public function delete(): bool {
        $conexao = new MySQL();
        $sql = "DELETE FROM imagem WHERE idImagem = {$this->idImagem}";
        return $conexao->executa($sql);
    }

    public function ocultar(): bool {
        $conexao = new MySQL();
        $sql = "UPDATE imagem SET fotoCapa = 0 WHERE idProduto = {$this->idProduto}";
        return $conexao->executa($sql);
    }

    public function update(): bool {
        $conexao = new MySQL();
        $sql = "UPDATE imagem 
                SET imagem = '{$this->imagem}', 
                    fotoCapa = '{$this->fotoCapa}'
                WHERE idImagem = {$this->idImagem}";
        return $conexao->executa($sql);
    }
}

