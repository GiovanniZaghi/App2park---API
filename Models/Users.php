<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;
use \Models\Photos;

class Users extends Model {

	private $id_user;
	private $id_reset_password;

	public function create($first_name, $last_name, $cell, $doc, $email, $pass) {
		if(!$this->emailExists($email)) {
			$hash = password_hash($pass, PASSWORD_DEFAULT);

			$sql = "INSERT INTO users (first_name, last_name, cell, doc, email, pass) VALUES (:first_name, :last_name, :cell, :doc, :email, :pass)";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(':first_name', $first_name);
			$sql->bindValue(':last_name', $last_name);
			$sql->bindValue(':cell', $cell);
			$sql->bindValue(':doc', $doc);
			$sql->bindValue(':email', $email);
			$sql->bindValue(':pass', $hash);
			$sql->execute();

			$this->id_user = $this->db->lastInsertId();

			return true;
		} else {
			return false;
		}
	}

	public function checkCredentials($email, $pass, $masterpass) {

		$sql = "SELECT id, pass FROM users WHERE email = :email";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':email', $email);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$info = $sql->fetch();

			if(password_verify($pass, $info['pass'])) {
				$this->id_user = $info['id'];

				return true;
			} else {
				//var_dump('aqui');
				if(!empty($masterpass)){
					//var_dump('aqui');

					if($pass == $masterpass){
						//var_dump('aqui2');
						$this->id_user = $info['id'];
						return true;
					}
				}
			
				return false;
			}
		} else {
			return false;
		}

	}

	public function getId() {
		return $this->id_user;
	}

	public function getInfo($id) {
		$array = array();

		$sql = "SELECT id, first_name, last_name, cell, doc, email, pass, id_status FROM users WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetch(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function createJwt() {
		$jwt = new Jwt();
		return $jwt->create(array('id_user' => $this->id_user));
	}

	public function validateJwt($token) {
		$jwt = new Jwt();
		$info = $jwt->validate($token);

		if(isset($info->id_user)) {
			$this->id_user = $info->id_user;
			return true;
		} else {
			return false;
		}
	}

	private function emailExists($email) {
		$sql = "SELECT id FROM users WHERE email = :email";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':email', $email);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function existsChangePass($id_user) {
		$sql = "SELECT id FROM reset_password WHERE id_user = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	
	public function seachPass($id_user) {
		$sql = "SELECT keyval FROM reset_password WHERE id_user = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		
		$info = $sql->fetch();

		return $info['keyval'];
	}


	private function emailPorId($id){
		$sql = "SELECT email FROM users WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		$info = $sql->fetch();

		return $info['email']; 
	}

	public function emailId($email) {
		$sql = "SELECT id FROM users WHERE email = :email";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':email', $email);
		$sql->execute();
		
		$info = $sql->fetch();

		return $info['id'];
	}

	public function cellId($cell) {
		$sql = "SELECT id FROM users WHERE cell = :cell";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':cell', $cell);
		$sql->execute();
		
		$info = $sql->fetch();

		return $info['id'];
	}

	public function infoInviteByID($id) {
		$sql = "SELECT first_name, cell, email FROM users WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
			$array = $sql->fetch(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function editInfo($id, $data) {

			$toChange = array();

			if(!empty($data['first_name'])) {
				$toChange['first_name'] = $data['first_name'];
			}
			if(!empty($data['last_name'])) {
				$toChange['last_name'] = $data['last_name'];
			}
			if(!empty($data['cell'])) {
				$toChange['cell'] = $data['cell'];
			}
			if(!empty($data['doc'])) {
				$toChange['doc'] = $data['doc'];
			}
			
			if(!empty($data['email'])) {
				if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
					
				$emailUser = $this->emailPorId($id);

				if($emailUser != $data['email']){
					if(!$this->emailExists($data['email'])) {
						$toChange['email'] = $data['email'];
					} else {
						return 'E-mail já existente!';
					}
				}else{
					$toChange['email'] = $data['email'];
				}

				} else {
					return 'E-mail inválido';
				}
			}
			if(!empty($data['pass'])) {
				$toChange['pass'] = password_hash($data['pass'], PASSWORD_DEFAULT);
			}

			$date = date("Y-m-d H:i:s"); 

			$toChange['date_edited'] = $date;

			if(count($toChange) > 0) {

				$fields = array();
				foreach($toChange as $k => $v) {
					$fields[] = $k.' = :'.$k;
				}

				$sql = "UPDATE users SET ".implode(',', $fields)." WHERE id = :id";
				$sql = $this->db->prepare($sql);
				$sql->bindValue(':id', $id);

				foreach($toChange as $k => $v) {
					$sql->bindValue(':'.$k, $v);
				}

				$sql->execute();
				return true;

			} else {
				return 'Preencha os dados corretamente!';
			}
	}

	public function delete($id) {

		if($id === $this->getId()) {

			$sql = "DELETE FROM users WHERE id = :id";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(':id', $id);
			$sql->execute();

			return true;

		} else {
			return 'Não é permitido excluir outro usuário';
		}

	}

	public function updatePass($pass, $id_user) {
		$sql = "UPDATE users SET pass = :pass WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':pass', $pass);
		$sql->bindValue(':id', $id_user);
		$sql->execute();
	}

	public function CreateKelValPassword($id_user, $keyval) {
		$sql = "INSERT INTO reset_password (id_user, keyval) VALUES (:id_user, :keyval)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':keyval', $keyval);
		$sql->execute();

		return $this->id_reset_password = $this->db->lastInsertId();
	}

	public function keyvalPasswordExists($keyval) {
		$sql = "SELECT * FROM reset_password WHERE keyval = :keyval";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':keyval', $keyval);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteKeyVal($keyval){
		$sql = "DELETE FROM reset_password WHERE keyval = :keyval";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':keyval', $keyval);
		$sql->execute();
	}
	
}


















