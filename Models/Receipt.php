<?php
namespace Models;

use \Core\Model;

class Receipt extends Model {

	public function createReceipt($id_ticket, $id_cupom, $res){

		$sql = "INSERT INTO `receipt`(`id_ticket`, `id_cupom`, `res`) VALUES(:id_ticket, :id_cupom, :res)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_ticket', $id_ticket);
		$sql->bindValue(':id_cupom', $id_cupom);
		$sql->bindValue(':res', $res);
		$sql->execute();

		return $this->db->lastInsertId();
    }
    
    public function findReceipt($id){

		$sql = "SELECT * FROM `receipt` WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetch(\PDO::FETCH_ASSOC);
		}
        return $data;
	}

    public function findReceiptByTicket($id_ticket, $id_cupom){

		$sql = "SELECT * FROM `receipt` WHERE id_ticket = :id_ticket AND id_cupom = :id_cupom";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_ticket', $id_ticket);
		$sql->bindValue(':id_cupom', $id_cupom);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetch(\PDO::FETCH_ASSOC);
		}
        return $data;
	}
}