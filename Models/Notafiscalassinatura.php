<?php
namespace Models;

use \Core\Model;

class Notafiscalassinatura extends Model {
    public function createNotaFiscalAssinatura($id_user, $cpf = '', $cnpj = '', $nome = '', $razao_social = '', $inscricao_municipal = '', $telefone, $email, $cep, $endereco, $numero, $complemento='', $bairro, $municipio, $uf){

        $sql = "INSERT INTO `nota_fiscal_assinatura`(`id_user`, `cpf`, `cnpj`, `nome`, `razao_social`, `inscricao_municipal`, `telefone`, `email`, `cep`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `uf`) VALUES (:id_user, :cpf, :cnpj, :nome, :razao_social, :inscricao_municipal, :telefone, :email, :cep, :endereco, :numero, :complemento, :bairro, :municipio, :uf)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_user', $id_user);
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

    public function findNotaFiscalAssinatura($id){

		$sql = "SELECT * FROM `nota_fiscal_assinatura` WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetch(\PDO::FETCH_ASSOC);
		}
	    return $data;
    }
}