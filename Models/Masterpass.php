<?php
namespace Models;

use \Core\Model;

class Masterpass extends Model {

    public function createMasterPass($pass){

		$sql = "INSERT INTO `masterpass`(`pass`) VALUES (:pass)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':pass', $pass);
		$sql->execute();

		return $this->db->lastInsertId();
    }

    public function deleteMasterPass($id){
		$sql = "DELETE FROM `masterpass` WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();
    }
    
    public function geMasterPass() {
		$array = array();

		$sql = "SELECT * FROM `masterpass` ORDER BY id DESC LIMIT 1";
		$sql = $this->db->prepare($sql);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetch(\PDO::FETCH_ASSOC);
		}

		return $array;
	}
}