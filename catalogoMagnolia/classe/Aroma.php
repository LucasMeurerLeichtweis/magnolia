<?php

require_once __DIR__ . "\..\bd\MySQL.php";

class Aroma {

    private int $idAroma;


    public function __construct(
        private string $nome,
        private string $descricao
    ) {

    }

    public function getIdAroma(): int {
         return $this->idAroma; 
        }
    public function getNome(): string {
         return $this->nome; 
        }
    public function getDescricao(): string {
         return $this->descricao; 
        }

    public function setIdAroma(int $idAroma): void {
         $this->idAroma = $idAroma; 
        }
    public function setNome(string $nome): void {
         $this->nome = $nome; 
        }
    public function setDescricao(string $descricao): void {
         $this->descricao = $descricao; 
        }

    public function save(): bool {
        $conexao = new MySQL();
        $sql = "INSERT INTO aroma (nome, descricao) VALUES ('{$this->nome}', '{$this->descricao}')";
        return $conexao->executa($sql);
    }

    public static function findAll(): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM aroma";
        $resultados = $conexao->consulta($sql);
        $aromas = [];

        foreach ($resultados as $resultado) {
            $a = new Aroma($resultado['nome'], $resultado['descricao']);
            $a->setIdAroma($resultado['idAroma']);
            $aromas[] = $a;
        }

        return $aromas;
    }

    public static function find(int $idAroma): ?Aroma {
        $conexao = new MySQL();
        $sql = "SELECT * FROM aroma WHERE idAroma = {$idAroma}";
        $resultados = $conexao->consulta($sql);

        if (!empty($resultados)) {
            $resultado = $resultados[0];
            $a = new Aroma($resultado['nome'], $resultado['descricao']);
            $a->setIdAroma($resultado['idAroma']);
            return $a;
        }

        return null;
    }

    public function update(): bool {
        $conexao = new MySQL();
        $sql = "UPDATE aroma SET nome = '{$this->nome}', descricao = '{$this->descricao}' WHERE idAroma = {$this->idAroma}";
        return $conexao->executa($sql);
    }

    public function delete(): bool {
        $conexao = new MySQL();
        $sql = "DELETE FROM aroma WHERE idAroma = {$this->idAroma}";
        return $conexao->executa($sql);
    }
}
