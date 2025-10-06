<?php

require_once __DIR__ . "\..\bd\MySQL.php";

class Categoria {

    private int $idCategoria;
   

    public function __construct(private string $nome) {
    }

    public function getIdCategoria(): int {
        return $this->idCategoria;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setIdCategoria(int $idCategoria): void {
        $this->idCategoria = $idCategoria;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function save(): bool {
        $conexao = new MySQL();
        $sql = "INSERT INTO categoria (nome) VALUES ('{$this->nome}')";
        return $conexao->executa($sql);
    }

    public static function findAll(): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM categoria";
        $resultados = $conexao->consulta($sql);
        $categorias = [];

        foreach ($resultados as $resultado) {
            $c = new Categoria($resultado['nome']);
            $c->setIdCategoria($resultado['idCategoria']);
            $categorias[] = $c;
        }

        return $categorias;
    }

    public static function find(int $idCategoria): ?Categoria {
        $conexao = new MySQL();
        $sql = "SELECT * FROM categoria WHERE idCategoria = {$idCategoria}";
        $resultados = $conexao->consulta($sql);

        if (!empty($resultados)) {
            $resultado = $resultados[0];
            $c = new Categoria($resultado['nome']);
            $c->setIdCategoria($resultado['idCategoria']);
            return $c;
        }

        return null;
    }

    public function update(): bool {
        $conexao = new MySQL();
        $sql = "UPDATE categoria SET nome = '{$this->nome}' WHERE idCategoria = {$this->idCategoria}";
        return $conexao->executa($sql);
    }

    public function delete(): bool {
        $conexao = new MySQL();
        $sql = "DELETE FROM categoria WHERE idCategoria = {$this->idCategoria}";
        return $conexao->executa($sql);
    }
}
