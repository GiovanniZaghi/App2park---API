<?php
namespace Models;

use \Core\Model;

class Form extends Model {
    public function createForm($nome, $email, $telefone, $cidade = '', $uf = '', $mensagem = ''){

        $sql = "INSERT INTO `form` (`nome`, `email`, `telefone`, `cidade`, `uf`, `mensagem`)  VALUES (:nome, :email, :telefone, :cidade, :uf, :mensagem)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':telefone', $telefone);
        $sql->bindValue(':cidade', $cidade);
        $sql->bindValue(':uf', $uf);
        $sql->bindValue(':mensagem', $mensagem);
		$sql->execute();

		return $this->db->lastInsertId();
    }

    public function findForm($id){

		$sql = "SELECT * FROM `form` WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetch(\PDO::FETCH_ASSOC);
		}
	    return $data;
    }
}