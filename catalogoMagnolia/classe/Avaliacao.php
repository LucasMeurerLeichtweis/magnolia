<?php

require_once __DIR__ . "\..\bd\MySQL.php";

class Avaliacao {

    private int $idAvaliacao;

    public function __construct(
        private int $nota,
        private string $descricaoAvaliacao,
        private string $data,
        private int $idProduto,
        private int $idUsuario,
    ) {

    }

    public function getIdAvaliacao(): int { 
        return $this->idAvaliacao; 
    }
    public function getNota(): int {
         return $this->nota; 
        }
    public function getDescricaoAvaliacao(): string {
         return $this->descricaoAvaliacao; 
        }
    public function getData(): string {
         return $this->data; 
        }
    public function getIdProduto(): int {
         return $this->idProduto; 
        }
    public function getIdUsuario(): int {
         return $this->idUsuario; 
        }

  
    public function setIdAvaliacao(int $idAvaliacao): void {
         $this->idAvaliacao = $idAvaliacao; 
        }
    public function setNota(int $nota): void {
         $this->nota = $nota; 
        }
    public function setDescricaoAvaliacao(string $descricaoAvaliacao): void {
         $this->descricaoAvaliacao = $descricaoAvaliacao; 
        }
    public function setData(string $data): void {
         $this->data = $data; 
        }
    public function setIdProduto(int $idProduto): void {
         $this->idProduto = $idProduto; 
        }
    public function setIdUsuario(int $idUsuario): void {
         $this->idUsuario = $idUsuario; 
        }

    public function save(): bool {
        $conexao = new MySQL();
        $sql = "INSERT INTO avaliacao (nota, descricaoAvaliacao, data, idProduto, idUsuario) 
                VALUES ('{$this->nota}', '{$this->descricaoAvaliacao}', '{$this->data}', '{$this->idProduto}', '{$this->idUsuario}')";
        return $conexao->executa($sql);
    }

    public static function findAll(): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM avaliacao";
        $resultados = $conexao->consulta($sql);
        $avaliacoes = [];

        foreach ($resultados as $resultado) {
            $a = new Avaliacao(
                $resultado['nota'],
                $resultado['descricaoAvaliacao'],
                $resultado['data'],
                $resultado['idProduto'],
                $resultado['idUsuario']
            );
            $a->setIdAvaliacao($resultado['idAvaliacao']);
            $avaliacoes[] = $a;
        }

        return $avaliacoes;
    }

    public static function find(int $idAvaliacao): ?Avaliacao {
        $conexao = new MySQL();
        $sql = "SELECT * FROM avaliacao WHERE idAvaliacao = {$idAvaliacao}";
        $resultados = $conexao->consulta($sql);

        if (!empty($resultados)) {
            $resultado = $resultados[0];
            $a = new Avaliacao(
                $resultado['nota'],
                $resultado['descricaoAvaliacao'],
                $resultado['data'],
                $resultado['idProduto'],
                $resultado['idUsuario']
            );
            $a->setIdAvaliacao($resultado['idAvaliacao']);
            return $a;
        }

        return null;
    }

    public function update(): bool {
        $conexao = new MySQL();
        $sql = "UPDATE avaliacao 
                SET nota = '{$this->nota}', 
                    descricaoAvaliacao = '{$this->descricaoAvaliacao}', 
                    data = '{$this->data}' 
                WHERE idAvaliacao = {$this->idAvaliacao}";
        return $conexao->executa($sql);
    }

    public function delete(): bool {
        $conexao = new MySQL();
        $sql = "DELETE FROM avaliacao WHERE idAvaliacao = {$this->idAvaliacao}";
        return $conexao->executa($sql);
    }
}
