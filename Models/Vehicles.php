<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;

class Vehicles extends Model {
    private $id_vehicle;
    private $id_vehicle_type;
    private $id_vehicle_maker;
    private $id_vehicle_color;
    private $id_vehicle_model;


    public function vehicles($id_vehicle_type, $id_vehicle_maker, $id_vehicle_model,
     $id_vehicle_color, $plate, $year){

        $sql = "INSERT INTO vehicles (id_vehicle_type, id_vehicle_maker, id_vehicle_model, 
       id_vehicle_color, plate, year) VALUES (:id_vehicle_type, :id_vehicle_maker, :id_vehicle_model,
       :id_vehicle_color, :plate, :year)";
		$sql = $this->db->prepare($sql);
        $sql->bindValue(':id_vehicle_type', $id_vehicle_type);
        $sql->bindValue(':id_vehicle_maker', $id_vehicle_maker);
        $sql->bindValue(':id_vehicle_model', $id_vehicle_model);
        $sql->bindValue(':id_vehicle_color', $id_vehicle_color);
        $sql->bindValue(':plate', $plate);
        $sql->bindValue(':year', $year);
		$sql->execute();

		return $this->id_vehicle = $this->db->lastInsertId();
    }

    public function getAllVehicleType() {
      $array = array();
  
      $sql = "SELECT * FROM vehicle_type";
      $sql = $this->db->prepare($sql);
      $sql->execute();
  
      if($sql->rowCount() > 0) {
        $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
      }
      return $data;
   }
   

      public function createVehicleTypePark($id_vehicle_type, $id_park, $status, $sort_order){
        $sql = "INSERT INTO vehicle_type_park (id_vehicle_type, id_park, status, sort_order) VALUES (:id_vehicle_type, :id_park, :status, :sort_order)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_vehicle_type', $id_vehicle_type);
        $sql->bindValue(':id_park', $id_park);
        $sql->bindValue(':status', $status);
        $sql->bindValue(':sort_order', $sort_order);
        $sql->execute();
    
        return $this->db->lastInsertId();
      }

      public function updateVehicleTypePark($id, $data) {

        $toChange = array();
  
        if(!empty($data['id_vehicle_type'])) {
          $toChange['id_vehicle_type'] = $data['id_vehicle_type'];
        }
        if(!empty($data['status'])) {
          $toChange['status'] = $data['status'];
        }
        if(!empty($data['sort_order'])) {
          $toChange['sort_order'] = $data['sort_order'];
        }
        
        if(count($toChange) > 0) {
  
          $fields = array();
          foreach($toChange as $k => $v) {
            $fields[] = $k.' = :'.$k;
          }
  
          $sql = "UPDATE payment_method_park SET ".implode(',', $fields)." WHERE id = :id";
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

      public function seachVehicleTypeParkByIdPark($id_park){
        $sql = "SELECT V.type, S.id, S.id_vehicle_type, S.id_park, S.status, S.sort_order FROM vehicle_type_park AS S INNER JOIN vehicle_type AS V ON (S.id_vehicle_type = V.id) WHERE id_park = :id_park";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_park', $id_park);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
      }

      public function seachVehicleTypePark($id_park){
        $sql = "SELECT * FROM vehicle_type_park WHERE id_park = :id_park";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_park', $id_park);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
      }

    public function maker($maker){
      $sql = "INSERT INTO vehicle_maker (maker) VALUES (:maker)";
	  	$sql = $this->db->prepare($sql);
		  $sql->bindValue(':maker', $maker);
		  $sql->execute();

		  return $this->db->lastInsertId();
    }

    public function color($color){
    $sql = "INSERT INTO vehicle_color (color) VALUES (:color)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':color', $color);
		$sql->execute();

    return $this->id_vehicle_color = $this->db->lastInsertId();
    }

    public function model($id_vehicle_maker, $model){
        $sql = "INSERT INTO vehicle_model (id_vehicle_maker, model) VALUES (:id_vehicle_maker, :model)";
		$sql = $this->db->prepare($sql);
        $sql->bindValue(':id_vehicle_maker', $id_vehicle_maker);
        $sql->bindValue(':model', $model);
		$sql->execute();

		return $this->id_vehicle_model = $this->db->lastInsertId();
    }

    public function getInfo($plate) {
		$array = array();

		$sql = "SELECT V.id, T.id AS type, M.maker, O.model, C.color, plate, year FROM vehicles as V LEFT JOIN vehicle_type AS T ON(V.id_vehicle_type = T.id) LEFT JOIN vehicle_maker AS M ON(V.id_vehicle_maker = M.id) LEFT JOIN vehicle_model AS O ON(V.id_vehicle_model = O.id) LEFT JOIN vehicle_color AS C ON(V.id_vehicle_color = C.id) WHERE plate = :plate";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':plate', $plate);
		$sql->execute();

		if($sql->rowCount() > 0) {
			return $array = $sql->fetch(\PDO::FETCH_ASSOC);
		}

		return $null;
    }

    public function getInfoPlates($plate) {
      $array = array();
  
      $sql = "SELECT * FROM `vehicles` WHERE plate = :plate";
      $sql = $this->db->prepare($sql);
      $sql->bindValue(':plate', $plate);
      $sql->execute();
  
      if($sql->rowCount() > 0) {
        return $array = $sql->fetch(\PDO::FETCH_ASSOC);
      }
  
      return $null;
      }


    public function getInfoID($id) {
      $array = array();
  
      $sql = "SELECT V.id, T.type, M.maker, O.model, C.color, plate, year FROM vehicles as V INNER JOIN vehicle_type AS T ON(V.id_vehicle_type = T.id) INNER JOIN vehicle_maker AS M ON(V.id_vehicle_maker = M.id) INNER JOIN vehicle_model AS O ON(V.id_vehicle_model = O.id) INNER JOIN vehicle_color AS C ON(V.id_vehicle_color = C.id) WHERE V.id = :id";
      $sql = $this->db->prepare($sql);
      $sql->bindValue(':id', $id);
      $sql->execute();
  
      if($sql->rowCount() > 0) {
        return $array = $sql->fetch(\PDO::FETCH_ASSOC);
      }
  
      return $null;
      }


      public function getInfoPlateID($id) {
        $array = array();
    
        $sql = "SELECT * FROM `vehicles` WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          return $array = $sql->fetch(\PDO::FETCH_ASSOC);
        }
    
        return $null;
        }

    public function getMaker($maker) {
      $sql = "SELECT id FROM vehicle_maker WHERE 	maker = :maker";
      $sql = $this->db->prepare($sql);
      $sql->bindValue(':maker', $maker);
      $sql->execute();
      
      if($sql->rowCount() > 0) {
        $info = $sql->fetch();
  
        return $info['id'];
      }
    
      return null;
    }

    public function getModel($model) {
      $sql = "SELECT id FROM vehicle_model WHERE model = :model";
      $sql = $this->db->prepare($sql);
      $sql->bindValue(':model', $model);
      $sql->execute();
      
      if($sql->rowCount() > 0) {
        $info = $sql->fetch();
  
        return $info['id'];
      }
    
      return null;
    }

    public function getColor($color) {
      $sql = "SELECT id FROM vehicle_color WHERE color = :color";
      $sql = $this->db->prepare($sql);
      $sql->bindValue(':color', $color);
      $sql->execute();
      
      if($sql->rowCount() > 0) {
        $info = $sql->fetch();
  
        return $info['id'];
      }
    
      return null;
    }

    public function editvehicletypepark($id, $data) {

      $toChange = array();

    
        $toChange['status'] = $data['status'];
    
   
      if(count($toChange) > 0) {
  
        $fields = array();
        foreach($toChange as $k => $v) {
          $fields[] = $k.' = :'.$k;
        }
  
        $sql = "UPDATE `vehicle_type_park` SET ".implode(',', $fields)." WHERE id = :id";
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

    public function findvehicletypepark($id) {
      $array = array();
  
      $sql = "SELECT * FROM `vehicle_type_park` WHERE id = :id";
      $sql = $this->db->prepare($sql);
      $sql->bindValue(':id', $id);
      $sql->execute();
  
      if($sql->rowCount() > 0) {
        $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
      }
      return $data;
   }
   
   public function sincVehicleTypePark($id_park) {
    $array = array();

    $sql = "SELECT * FROM `vehicle_type_park` WHERE id_park = :id_park";
    $sql = $this->db->prepare($sql);
    $sql->bindValue(':id_park', $id_park);
    $sql->execute();

    if($sql->rowCount() > 0) {
      $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    return $data;
  }
}