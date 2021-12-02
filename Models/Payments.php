<?php
namespace Models;

use \Core\Model;

class Payments extends Model {

    public function createPaymentMethodPark($id_park, $id_payment_method, $flat_rate, $variable_rate, $min_value, $status, $sort_order) {
			$sql = "INSERT INTO payment_method_park (id_park, id_payment_method, flat_rate, variable_rate, min_value, status, sort_order) VALUES (:id_park, :id_payment_method, :flat_rate, :variable_rate, :min_value, :status, :sort_order)";
			$sql = $this->db->prepare($sql);
			$sql->bindValue(':id_park', $id_park);
			$sql->bindValue(':id_payment_method', $id_payment_method);
			$sql->bindValue(':flat_rate', $flat_rate);
			$sql->bindValue(':variable_rate', $variable_rate);
			$sql->bindValue(':min_value', $min_value);
			$sql->bindValue(':status', $status);
			$sql->bindValue(':sort_order', $sort_order);
			$sql->execute();

			return $this->db->lastInsertId();
	}


	public function seachPaymentsParkInnerJoinByPaymentsParkIdPark($id_park){
        $sql = "SELECT P.name, S.id, S.id_park, S.id_payment_method, S.flat_rate, S.variable_rate, S.min_value, S.status, S.sort_order FROM payment_method_park AS S INNER JOIN payments_method AS P ON(S.id_payment_method = P.id) WHERE S.id_park = :id_park";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_park', $id_park);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
	  }
	  
	public function seachAllPaymentPark($id_park){
        $sql = "SELECT * FROM payment_method_park WHERE id_park = :id_park";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_park', $id_park);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
	}
	  
	public function seachAllPayments(){

		$sql = "SELECT * FROM `payments_method`";
		$sql = $this->db->prepare($sql);
		$sql->execute();
	
		if($sql->rowCount() > 0) {
		  $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;
	}

	public function editpaymentmethodpark($id, $data) {

		$toChange = array();
  
		if(!empty($data['flat_rate'])) {
			$toChange['flat_rate'] = $data['flat_rate'];
		}
		if(!empty($data['variable_rate'])) {
			$toChange['variable_rate'] = $data['variable_rate'];
		}
		if(!empty($data['min_value'])) {
			$toChange['min_value'] = $data['min_value'];
		}

		$toChange['status'] = $data['status'];
	
		if(!empty($data['sort_order'])) {
			$toChange['sort_order'] = $data['sort_order'];
		}
	 
		if(count($toChange) > 0) {
	
		  $fields = array();
		  foreach($toChange as $k => $v) {
			$fields[] = $k.' = :'.$k;
		  }
	
		  $sql = "UPDATE `payment_method_park` SET ".implode(',', $fields)." WHERE id = :id";
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

	  public function findpaymentmethodparkbyid($id) {
		$array = array();
	
		$sql = "SELECT * FROM `payment_method_park` WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();
	
		if($sql->rowCount() > 0) {
		  $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;
	 }
	  
	 public function sincpaymentmethodparkbyidpark($id_park) {
		$array = array();
	
		$sql = "SELECT * FROM `payment_method_park` WHERE id_park = :id_park";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_park', $id_park);
		$sql->execute();
	
		if($sql->rowCount() > 0) {
		  $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;
	 }
}