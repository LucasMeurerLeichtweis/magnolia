<?php

require_once __DIR__."\Configuracao.php";

class MySQL{
	
	private $connection;
	
	public function __construct(){
		$this->connection = new \mysqli(HOST,USUARIO,SENHA,BANCO);
		$this->connection->set_charset("utf8");
	}

	public function executa($sql): bool|mysqli_result{
		$result = $this->connection->query($sql);
		return $result;
	}
	public function consulta($sql){
		$result = $this->connection->query($sql);
		$item = array();
		$data = array();
		while($item = mysqli_fetch_array($result)){
			$data[] = $item;
		}
		return $data;
		}

	public function getUltimoIdInserido(): int {
    	return $this->connection->insert_id; 
    }	
	}

	
?>