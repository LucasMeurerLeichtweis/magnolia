<?php

require_once __DIR__."\..\bd\MySQL.php";

class Usuario{

    private int $idUsuario;
    
    public function __construct(private string $email, private string $senha, private ?string $nome = null) {
    }


    public function setIdUsuario(int $idUsuario):void{
        $this->idUsuario = $idUsuario;
    }

    public function getIdUsuario():int{
        return $this->idUsuario;
    }

    public function setSenha(string $senha):void{
        $this->senha = $senha;
    }

    public function setEmail(string $email):void{
        $this->email = $email;
    }

    public function setNome(string $nome):void{
        $this->nome = $nome;
    }

    public function getNome():string{
        return $this->nome;
    }

    public function getSenha():string{
        return $this->senha;
    }

    public function getEmail():string{
        return $this->email;
    }

    public function save():bool{
        $conexao = new MySQL();
        $this->senha = password_hash($this->senha,PASSWORD_BCRYPT); 
        if(isset($this->idUsuario)){
            $sql = "UPDATE usuario SET email = '{$this->email}', senha = '{$this->senha}', nome = '{$this->nome}' WHERE idUsuario = {$this->idUsuario}";
        }else{
            $sql = "INSERT INTO usuario (email,senha,nome) VALUES ('{$this->email}','{$this->senha}','{$this->nome}')";
        }
        return $conexao->executa($sql);
    }

        public static function find($idUsuario):Usuario{
        $conexao = new MySQL();
        $sql = "SELECT * FROM usuario WHERE idUsuario = {$idUsuario}";
        $resultado = $conexao->consulta($sql);
        $u = new Usuario($resultado[0]['email'],$resultado[0]['senha'],$resultado[0]['nome']);
        $u->setIdUsuario($resultado[0]['idUsuario']);
        return $u;
        }

    public function authenticate():bool{
        $conexao = new MySQL();
        $sql = "SELECT idUsuario,email,senha,nome FROM usuario WHERE email = '{$this->email}'";
        $resultados = $conexao->consulta($sql);
        if(count($resultados)>0){
            if(password_verify($this->senha,$resultados[0]['senha'])){
                session_start();
                $_SESSION['idUsuario'] = $resultados[0]['idUsuario'];
                $_SESSION['email'] = $resultados[0]['email'];
                $_SESSION['nome'] = $resultados[0]['nome'];
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    public function updatePassword(string $senhaAntiga, string $senhaNova): bool {
    $conexao = new MySQL();
    $sql = "SELECT senha FROM usuario WHERE idUsuario = {$this->idUsuario}";
    $resultado = $conexao->consulta($sql);

    if(count($resultado) > 0 && password_verify($senhaAntiga, $resultado[0]['senha'])) {
        $this->senha = $senhaNova;
        return $this->save();
    }
    return false;
}

}