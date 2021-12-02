<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;

class Puser extends Model {
	private $id_park_user;

    public function getInfo($id) {
		$array = array();

		$sql = "SELECT * FROM park_user WHERE id_user = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;
	}


	public function invite($id_park, $id_user, $id_office, $valor_chave){

		$sql = "INSERT INTO park_user (id_park, id_user, id_status, id_office, keyval) VALUES (:id_park, :id_user, 4, :id_office, :keyval)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_park', $id_park);
		$sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':id_office', $id_office);
		$sql->bindValue(':keyval', $valor_chave);
		$sql->execute();

		return $last_id_park_user = $this->db->lastInsertId();

	}


	
	public function updateInvite($id, $id_office, $id_status){

		$sql = "UPDATE park_user SET id_office = :id_office, id_status = :id_status WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_office', $id_office);
		$sql->bindValue(':id_status', $id_status);
		$sql->execute();

		return true;

	}
	
	public function validatekeyval($keyval) {
		$sql = "SELECT id FROM park_user WHERE keyval = :keyval";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':keyval', $keyval);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function searchKeyval($id_user, $id_park) {
		$sql = "SELECT keyval FROM park_user WHERE id_user = :id_user AND id_park = :id_park";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':id_park', $id_park);
		$sql->execute();
		
		$info = $sql->fetch();

		return $info['keyval'];
	}

	public function exitsInviteByKelval($keyval) {
		$sql = "SELECT id FROM park_user WHERE keyval = :keyval AND id_status = 1";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':keyval', $keyval);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function exitsJobByKelval($id) {
		$sql = "SELECT office FROM offices WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();
		$info = $sql->fetch();

		return $info['office'];
	}


	public function exitsInvite($id_user, $id_park) {
		$sql = "SELECT id FROM park_user WHERE id_user = :id_user AND id_park = :id_park";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':id_park', $id_park);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function exitsUserInPark($id_user, $id_park) {
		$sql = "SELECT id FROM park_user WHERE id_user = :id_user AND id_park = :id_park AND id_status = 1";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':id_park', $id_park);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function accept($keyval) {
		$sql = "UPDATE park_user SET id_status = 1 WHERE keyval = :keyval";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':keyval', $keyval);
		$sql->execute();
	}


	public function getAllInvites($id_park) {
		$array = array();

		$sql = "SELECT * FROM park_user WHERE id_park = :id_park";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_park', $id_park);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;
	}

	public function getAllInvitesUser($id_user, $id_park) {
		$array = array();

		$sql = "SELECT P.id, U.first_name, U.doc, U.email, U.cell, P.id_park, O.office, S.status FROM park_user AS P INNER JOIN users as U ON (P.id_user = U.id) INNER JOIN offices AS O ON (P.id_office = O.id) INNER JOIN status AS S ON (P.id_status = S.id) WHERE P.id_park = :id_park AND U.id = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':id_park', $id_park);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;
	}

	public function getAllInvitesActive($id_park) {
		$array = array();

		$sql = "SELECT * FROM `park_user` WHERE id_park = :id_park AND id_status = 1";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_park', $id_park);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;
	}

	public function getInviteById($id) {
		$array = array();

		$sql = "SELECT * FROM `park_user` WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;
	}


	public function getAllInvitesPending($id_park) {
		$array = array();

		$sql = "SELECT * FROM `park_user` WHERE id_park = :id_park AND id_status = 4";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_park', $id_park);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;
	}

	
	public function getAllInvitesInactive($id_park) {
		$array = array();

		$sql = "SELECT * FROM `park_user` WHERE id_park = :id_park AND id_status = 2";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_park', $id_park);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;
	}

	public function getPuser($id_park) {
		$array = array();

		$sql = "SELECT * FROM `park_user` WHERE id_park = :id_park";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_park', $id_park);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;
	}

	public function puserbyid($id) {
		$array = array();

		$sql = "SELECT * FROM `park_user` WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;
	}

	public function puserbyiduseridpark($id_user, $id_park) {
		$array = array();

		$sql = "SELECT * FROM `park_user` WHERE id_user = :id_user AND id_park = :id_park";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':id_park', $id_park);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $data;
	}

	public function sincpuserdb($id_park) {
		$array = array();

		$sql = "SELECT * FROM `park_user` WHERE id_park = :id_park";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_park', $id_park);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;
	}

	public function sincpuserout($id_user) {
		$array = array();

		$sql = "SELECT * FROM `park_user` WHERE id_user = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;
	}

	public function sincinvetedb($id_park) {
		$array = array();

		$sql = "SELECT P.id, U.first_name, U.doc, U.email, U.cell, P.id_park, O.office, S.status FROM park_user AS P INNER JOIN users as U ON (P.id_user = U.id) INNER JOIN offices AS O ON (P.id_office = O.id) INNER JOIN status AS S ON (P.id_status = S.id) WHERE P.id_park = :id_park";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_park', $id_park);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;
	}

	public function cronAllUserFromPark($id_park) {
		$array = array();

		$sql = "SELECT U.*, P.* FROM `park_user` AS P INNER JOIN users AS U ON(U.id = P.id_user) WHERE P.id_park = :id_park AND P.id_office < 3";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_park', $id_park);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;
	}
}