<?php
namespace Models;

use \Core\Model;

class Notafiscal extends Model {
    public function createNotaFiscal($cpf, $cnpj, $nome, $razao_social, $inscricao_municipal, $telefone, $email, $cep, $endereco, $numero, $complemento, $bairro, $municipio, $uf){

        $sql = "INSERT INTO `nota_fiscal`(`cpf`, `cnpj`, `nome`, `razao_social`, `inscricao_municipal`, `telefone`, `email`, `cep`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `uf`)   VALUES (:cpf, :cnpj, :nome, :razao_social, :inscricao_municipal, :telefone, :email, :cep, :endereco, :numero, :complemento, :bairro, :municipio, :uf)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':cpf', $cpf);
        $sql->bindValue(':cnpj', $cnpj);
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':razao_social', $razao_social);
        $sql->bindValue(':inscricao_municipal', $inscricao_municipal);
        $sql->bindValue(':telefone', $telefone);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':cep', $cep);
        $sql->bindValue(':endereco', $endereco);
        $sql->bindValue(':numero', $numero);
        $sql->bindValue(':complemento', $complemento);
        $sql->bindValue(':bairro', $bairro);
        $sql->bindValue(':municipio', $municipio);
        $sql->bindValue(':uf', $uf);
		$sql->execute();

		return $this->db->lastInsertId();
    }

    public function findNotaFiscal($id){

		$sql = "SELECT * FROM `nota_fiscal` WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetch(\PDO::FETCH_ASSOC);
		}
	    return $data;
    }

    public function createNotaFiscalLog($id_ticket, $id_park, $id_nota_fiscal, $status){

        $sql = "INSERT INTO `nota_fiscal_log`(`id_ticket`, `id_park`, `id_nota_fiscal`, `status`)  VALUES (:id_ticket, :id_park, :id_nota_fiscal, :status)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_ticket', $id_ticket);
        $sql->bindValue(':id_park', $id_park);
        $sql->bindValue(':id_nota_fiscal', $id_nota_fiscal);
        $sql->bindValue(':status', $status);
		$sql->execute();

		return $this->db->lastInsertId();
    }

    public function findNotaFiscalLog($id){

        $sql = "SELECT * FROM `nota_fiscal_log` WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
          $data = $sql->fetch(\PDO::FETCH_ASSOC);
        }
      return $data;
    }

    public function findNotaFiscalByCPF($cpf){

      $sql = "SELECT * FROM `nota_fiscal` WHERE cpf = :cpf";
      $sql = $this->db->prepare($sql);
      $sql->bindValue(':cpf', $cpf);
      $sql->execute();

      if($sql->rowCount() > 0) {
        $data = $sql->fetch(\PDO::FETCH_ASSOC);
      }
    return $data;
  }

  public function findNotaFiscalByCNPJ($cnpj){

    $sql = "SELECT * FROM `nota_fiscal` WHERE cnpj = :cnpj";
    $sql = $this->db->prepare($sql);
    $sql->bindValue(':cnpj', $cnpj);
    $sql->execute();

    if($sql->rowCount() > 0) {
      $data = $sql->fetch(\PDO::FETCH_ASSOC);
    }
  return $data;
}
}