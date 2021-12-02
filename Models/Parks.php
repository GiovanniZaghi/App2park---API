<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;

class Parks extends Model {

	private $id_park;
	private $id_park_user;
	private $id_park_schedule;
	private $id_park_price;
	private $id_park_price_item;

    public function create($type, $doc, $name_park, $business_name, $cell, $postal_code,
     $street, $number, $complement, $neighborhood, $city, $state, $country, $vacancy, $subscription, $id_user) {
		if(!$this->parkExists($doc)) {
			$sql = "INSERT INTO `parks`(`type`, `doc`, `name_park`, `business_name`, `cell`,
			 `postal_code`, `street`, `number`, `complement`, `neighborhood`, `city`,
			 `state`, `country`, `vacancy`, `subscription`)
			VALUES(:type, :doc, :name_park, :business_name, :cell,
			 :postal_code, :street, :number, :complement, :neighborhood, :city,
			 :state, :country, :vacancy, :subscription)";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(':type', $type);
			$sql->bindValue(':doc', $doc);
			$sql->bindValue(':name_park', $name_park);
			$sql->bindValue(':business_name', $business_name);
			$sql->bindValue(':cell', $cell);
			$sql->bindValue(':postal_code', $postal_code);
			$sql->bindValue(':street', $street);
            $sql->bindValue(':number', $number);
            $sql->bindValue(':complement', $complement);
			$sql->bindValue(':neighborhood', $neighborhood);
			$sql->bindValue(':city', $city);
			$sql->bindValue(':state', $state);
			$sql->bindValue(':country', $country);
			$sql->bindValue(':vacancy', $vacancy);
			$sql->bindValue(':subscription', $subscription);
			$sql->execute();

			$this->id_park = $this->db->lastInsertId();

			$this->CreateparkUser($id_user, $this->id_park);

			return true;
		} else {
			return false;
		}
	}
	
	private function CreateparkUser($id_user, $id_park) {
		$sql = "INSERT INTO park_user (id_park, id_user, id_status, id_office) VALUES (:id_park, :id_user, 1, 1)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_park', $id_park);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		$this->id_park_user = $this->db->lastInsertId();
	}

	public function CreateSchedule(
	$id_park,
	$monday_daytime_open, $monday_daytime_close, $monday_nightly_open, $monday_nightly_close,
	$tuesday_daytime_open, $tuesday_daytime_close, $tuesday_nightly_open, $tuesday_nightly_close,
	$wednesday_daytime_open, $wednesday_daytime_close, $wednesday_nightly_open, $wednesday_nightly_close,
	$thursday_daytime_open, $thursday_daytime_close, $thursday_nightly_open, $thursday_nightly_close,
	$friday_daytime_open, $friday_daytime_close, $friday_nightly_open, $friday_nightly_close,
	$saturday_daytime_open, $saturday_daytime_close, $saturday_nightly_open, $saturday_nightly_close,
	$sunday_daytime_open, $sunday_daytime_close, $sunday_nightly_open, $sunday_nightly_close
	){
		$sql = "INSERT INTO park_schedule(
		id_park,
		 monday_daytime_open, monday_daytime_close, monday_nightly_open, monday_nightly_close,
		  tuesday_daytime_open, tuesday_daytime_close, tuesday_nightly_open, tuesday_nightly_close,
		   wednesday_daytime_open, wednesday_daytime_close, wednesday_nightly_open, wednesday_nightly_close,
		    thursday_daytime_open, thursday_daytime_close, thursday_nightly_open, thursday_nightly_close,
			  friday_daytime_open, friday_daytime_close, friday_nightly_open, friday_nightly_close,
			   saturday_daytime_open, saturday_daytime_close, saturday_nightly_open, saturday_nightly_close,
			    sunday_daytime_open, sunday_daytime_close, sunday_nightly_open, sunday_nightly_close
				) 
				 VALUES (
				 :id_park,
				 :monday_daytime_open, :monday_daytime_close, :monday_nightly_open, :monday_nightly_close,
				 :tuesday_daytime_open, :tuesday_daytime_close, :tuesday_nightly_open, :tuesday_nightly_close,
				 :wednesday_daytime_open, :wednesday_daytime_close, :wednesday_nightly_open, :wednesday_nightly_close,
				 :thursday_daytime_open, :thursday_daytime_close, :thursday_nightly_open, :thursday_nightly_close,
				 :friday_daytime_open, :friday_daytime_close, :friday_nightly_open, :friday_nightly_close,
				 :saturday_daytime_open, :saturday_daytime_close, :saturday_nightly_open, :saturday_nightly_close,
				 :sunday_daytime_open, :sunday_daytime_close, :sunday_nightly_open, :sunday_nightly_close
				 )";
		
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_park', $id_park);

		$sql->bindValue(':monday_daytime_open', $monday_daytime_open);
		$sql->bindValue(':monday_daytime_close', $monday_daytime_close);
		$sql->bindValue(':monday_nightly_open', $monday_nightly_open);
		$sql->bindValue(':monday_nightly_close', $monday_nightly_close);

		$sql->bindValue(':tuesday_daytime_open', $tuesday_daytime_open);
		$sql->bindValue(':tuesday_daytime_close', $tuesday_daytime_close);
		$sql->bindValue(':tuesday_nightly_open', $tuesday_nightly_open);
		$sql->bindValue(':tuesday_nightly_close', $tuesday_nightly_close);
		
		$sql->bindValue(':wednesday_daytime_open', $wednesday_daytime_open);
		$sql->bindValue(':wednesday_daytime_close', $wednesday_daytime_close);
		$sql->bindValue(':wednesday_nightly_open', $wednesday_nightly_open);
		$sql->bindValue(':wednesday_nightly_close', $wednesday_nightly_close);
		
		$sql->bindValue(':thursday_daytime_open', $thursday_daytime_open);
		$sql->bindValue(':thursday_daytime_close', $thursday_daytime_close);
		$sql->bindValue(':thursday_nightly_open', $thursday_nightly_open);
		$sql->bindValue(':thursday_nightly_close', $thursday_nightly_close);
		
		$sql->bindValue(':friday_daytime_open', $friday_daytime_open);
		$sql->bindValue(':friday_daytime_close', $friday_daytime_close);
		$sql->bindValue(':friday_nightly_open', $friday_nightly_open);
		$sql->bindValue(':friday_nightly_close', $friday_nightly_close);
		
		$sql->bindValue(':saturday_daytime_open', $saturday_daytime_open);
		$sql->bindValue(':saturday_daytime_close', $saturday_daytime_close);
		$sql->bindValue(':saturday_nightly_open', $saturday_nightly_open);
		$sql->bindValue(':saturday_nightly_close', $saturday_nightly_close);
		
		$sql->bindValue(':sunday_daytime_open', $sunday_daytime_open);
		$sql->bindValue(':sunday_daytime_close', $sunday_daytime_close);
		$sql->bindValue(':sunday_nightly_open', $sunday_nightly_open);
		$sql->bindValue(':sunday_nightly_close', $sunday_nightly_close);

		$sql->execute();

		return $this->id_park_schedule = $this->db->lastInsertId();
	}


	public function CreateParkPrice($name, $id_park, $id_vehicle_type) {
		$sql = "INSERT INTO park_price (name, id_park, id_vehicle_type) VALUES (:name, :id_park, :id_vehicle_type)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':name', $name);
		$sql->bindValue(':id_park', $id_park);
		$sql->bindValue(':id_vehicle_type', $id_vehicle_type);
		$sql->execute();

		return $this->id_park_price = $this->db->lastInsertId();
	}

	public function CreateParkPriceItem($id_park_price, $position, $name, $value, $price, $lack = ''){
		$sql = "INSERT INTO park_price_item (id_park_price, position, name, value, price, lack, status) VALUES (:id_park_price, :position, :name, :value, :price, :lack, 1)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_park_price', $id_park_price);
		$sql->bindValue(':position', $position);
		$sql->bindValue(':name', $name);
		$sql->bindValue(':value', $value);
		$sql->bindValue(':price', $price);
		$sql->bindValue(':lack', $lack);
		$sql->execute();

		return $this->id_park_price_item = $this->db->lastInsertId();
	}
    
    private function parkExists($doc) {
		$sql = "SELECT park_id FROM parks WHERE doc = :doc";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':doc', $doc);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}


	private function subscriptionIsHavingByIdUser($id_user) {
		$sql = "SELECT park_id FROM parks WHERE doc = :doc";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':doc', $doc);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}


	public function haveSubscriptionByIdUser($id_user) {
		$sql = "SELECT * FROM `subscription` WHERE id_user = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function haveParkUserByIdUser($id_user) {
		$sql = "SELECT * FROM `park_user` WHERE id_user = :id_user AND (id_office = 1 OR id_office = 2)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function infoParkUserByid_user($id_user) {
		$sql = "SELECT * FROM `park_user` WHERE id_user = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
			$array = $sql->fetch(\PDO::FETCH_ASSOC);
		}

		return $array;
	}
	
	public function infoInviteByID($id) {
		$sql = "SELECT name_park, postal_code, street, number, city, state, country FROM parks WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
			$array = $sql->fetch(\PDO::FETCH_ASSOC);
		}

		return $array;
	}
    
    public function getId() {
		return $this->id_park;
	}

	public function getInfo($id) {
		$array = array();

		$sql = "SELECT * FROM parks WHERE id = :id";
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

			if(!empty($data['name_park'])) {
				$toChange['name_park'] = $data['name_park'];
			}
			if(!empty($data['country'])) {
				$toChange['country'] = $data['country'];
			}
			if(!empty($data['business_name'])) {
				$toChange['business_name'] = $data['business_name'];
			}
			if(!empty($data['postal_code'])) {
				$toChange['postal_code'] = $data['postal_code'];
			}
			if(!empty($data['street'])) {
				$toChange['street'] = $data['street'];
			}
			if(!empty($data['number'])) {
				$toChange['number'] = $data['number'];
            }
            if(!empty($data['complement'])) {
				$toChange['complement'] = $data['complement'];
            }
            if(!empty($data['city'])) {
				$toChange['city'] = $data['city'];
            }
            if(!empty($data['state'])) {
				$toChange['state'] = $data['state'];
            }
            if(!empty($data['status'])) {
				$toChange['status'] = $data['status'];
			}

			if(!empty($data['doc'])) {
				if(!$this->parkExists($data['doc'])) {
					$toChange['doc'] = $data['doc'];
				} else {
					return 'Estacionamento comm esse documento já existe!';
				}
			}
			if(count($toChange) > 0) {

				$fields = array();
				foreach($toChange as $k => $v) {
					$fields[] = $k.' = :'.$k;
				}

				$sql = "UPDATE parks SET ".implode(',', $fields)." WHERE id = :id";
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
			$sql = "DELETE FROM parks WHERE id = :id";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(':id', $id);
			$sql->execute();

			return true;
	}

	public function updateImage($id, $photo) {
		$sql = "UPDATE parks SET photo = :photo  WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':photo', $photo);
		$sql->bindValue(':id', $id);
		$sql->execute();

		return true;
	}

	
    public function new_ServicePark($id_service_additional, $id_park, $price, $tolerance,
     $sort_order, $status) {
	
			$sql = "INSERT INTO park_service_additional (id_service_additional, id_park, price,
             tolerance, sort_order, status)
              VALUES (:id_service_additional, :id_park,
               :price, :tolerance, :sort_order, :status)";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(':id_service_additional', $id_service_additional);
			$sql->bindValue(':id_park', $id_park);
			$sql->bindValue(':price', $price);
			$sql->bindValue(':tolerance', $tolerance);
			$sql->bindValue(':sort_order', $sort_order);
			$sql->bindValue(':status', $status);
			$sql->execute();

			return $this->db->lastInsertId();
	}

	
    public function getAllServicesParkByParkId($id_park){
        $sql = "SELECT * FROM park_service_additional WHERE id_park = :id_park";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_park', $id_park);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
	  }
	  
	  public function getAllServicesParkId($id){
        $sql = "SELECT * FROM park_service_additional WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
    }

	public function getAllServicesPark(){
        $sql = "SELECT * FROM park_service_additional";
        $sql = $this->db->prepare($sql);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
	}
	
	public function selectAllServicesAdditional(){
        $sql = "SELECT * FROM `service_additional`";
        $sql = $this->db->prepare($sql);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
	}

	public function getAllServicesParkById(){
        $sql = "SELECT * FROM `park_service_additional` WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
	}

	public function getAllParkSincIdUser($id_user){
        $sql = "SELECT * FROM parks WHERE id IN (SELECT id_park FROM park_user WHERE id_user = :id_user AND id_status = 1)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
	}

	public function getParkUserByIdParkIdUserSinc($id_park, $id_user){
        $sql = "SELECT * FROM `park_user` WHERE id_park = :id_park AND id_user = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_park', $id_park);
		$sql->bindValue(':id_user', $id_user);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
	}

	
	public function getusersParkUserByIdPark($id_park){
        $sql = "SELECT U.* FROM park_user AS P INNER JOIN users AS U ON(P.id_user = U.id) WHERE P.id_park = :id_park";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_park', $id_park);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
	}

	public function getusersParkUsersRoleAdminByIdPark($id_park){
        $sql = "SELECT U.* FROM park_user AS P LEFT JOIN users AS U ON(P.id_user = U.id) WHERE P.id_park = :id_park AND P.id_office <= 3";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_park', $id_park);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
	}

	public function editparkservice($id, $data) {

		$toChange = array();

		if(!empty($data['price'])) {
			$toChange['price'] = $data['price'];
		}
		if(!empty($data['tolerance'])) {
			$toChange['tolerance'] = $data['tolerance'];
		}
		if(!empty($data['sort_order'])) {
			$toChange['sort_order'] = $data['sort_order'];
		}
		if(!empty($data['status'])) {
			$toChange['status'] = $data['status'];
		}

		if(count($toChange) > 0) {

			$fields = array();
			foreach($toChange as $k => $v) {
				$fields[] = $k.' = :'.$k;
			}

			$sql = "UPDATE `park_service_additional` SET ".implode(',', $fields)." WHERE id = :id";
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
	
	public function selectAllParksSignatureExpire($firstdate){
        $sql = "SELECT * FROM `parks` WHERE subscription = :firstdate";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':firstdate', $firstdate);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
	}

	public function selectAllParksSignatureExpireBetween(){
        $sql = "SELECT * FROM `parks`WHERE subscription BETWEEN '2020-11-26' AND '2020-11-26'";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':firstdate', $firstdate);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
	}

	public function updateSubscriptionPark($id, $subscription){

		$sql = "UPDATE `parks` SET `subscription`= :subscription WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':subscription', $subscription);

		$sql->execute();
	
		return true;
  
	  }
}