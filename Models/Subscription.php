<?php
namespace Models;

use \Core\Model;

class Subscription extends Model {

    public function createSubscription($id_user, $subscription_price, $id_period, $id_send, $doc, $name, $email, $postal_code, $street, $number, $complement = '', $neighborhood, $city, $state, $ddd, $cell, $type){

        $sql = "INSERT INTO `subscription`(`id_user`, `subscription_price`, `id_period`, `id_send`, `doc`, `name`, `email`, `postal_code`, `street`, `number`, `complement`, `neighborhood`, `city`, `state`, `ddd`, `cell`, `type`)  VALUES (:id_user, :subscription_price, :id_period, :id_send, :doc, :name, :email, :postal_code, :street, :number, :complement, :neighborhood, :city, :state, :ddd, :cell, :type)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_user', $id_user);
        $sql->bindValue(':subscription_price', $subscription_price);
        $sql->bindValue(':id_period', $id_period);
        $sql->bindValue(':id_send', $id_send);
        $sql->bindValue(':doc', $doc);
        $sql->bindValue(':name', $name);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':postal_code', $postal_code);
        $sql->bindValue(':street', $street);
        $sql->bindValue(':number', $number);
        $sql->bindValue(':complement', $complement);
        $sql->bindValue(':neighborhood', $neighborhood);
        $sql->bindValue(':city', $city);
        $sql->bindValue(':state', $state);
        $sql->bindValue(':ddd', $ddd);
        $sql->bindValue(':cell', $cell);
        $sql->bindValue(':type', $type);
		$sql->execute();

		return $this->db->lastInsertId();
    }

    public function findSubscription($id){

		$sql = "SELECT * FROM `subscription` WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
	    return $data;
    }

    public function editSubscription($id, $data) {

        $toChange = array();
    
        if(!empty($data['id_user'])) {
          $toChange['id_user'] = $data['id_user'];
        }
        if(!empty($data['subscription_price'])) {
          $toChange['subscription_price'] = $data['subscription_price'];
        }
        if(!empty($data['id_period'])) {
          $toChange['id_period'] = $data['id_period'];
        }
        if(!empty($data['id_send'])) {
          $toChange['id_send'] = $data['id_send'];
        }
        if(!empty($data['doc'])) {
          $toChange['doc'] = $data['doc'];
        }
        if(!empty($data['name'])) {
          $toChange['name'] = $data['name'];
        }
        if(!empty($data['email'])) {
          $toChange['email'] = $data['email'];
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
          if(!empty($data['neighborhood'])) {
            $toChange['neighborhood'] = $data['neighborhood'];
          }
          if(!empty($data['city'])) {
            $toChange['city'] = $data['city'];
          }
          if(!empty($data['state'])) {
            $toChange['state'] = $data['state'];
          }
          if(!empty($data['ddd'])) {
            $toChange['ddd'] = $data['ddd'];
          }
          if(!empty($data['cell'])) {
            $toChange['cell'] = $data['cell'];
          }
          if(!empty($data['type'])) {
            $toChange['type'] = $data['type'];
          }
  
        if(count($toChange) > 0) {
    
          $fields = array();
          foreach($toChange as $k => $v) {
            $fields[] = $k.' = :'.$k;
          }
    
          $sql = "UPDATE `subscription` SET ".implode(',', $fields)." WHERE id = :id";
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
  
    public function createSubscriptionItem($id_subscription, $id_park){

        $sql = "INSERT INTO `subscription_item`(`id_subscription`, `id_park`) VALUES (:id_subscription, :id_park)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_subscription', $id_subscription);
        $sql->bindValue(':id_park', $id_park);
		$sql->execute();

		return $this->db->lastInsertId();
    }

    public function findSubscriptionItem($id){

		$sql = "SELECT * FROM `subscription_item` WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
	    return $data;
    }

    public function editSubscriptionItem($id, $data) {

        $toChange = array();
    
        if(!empty($data['id_subscription'])) {
          $toChange['id_subscription'] = $data['id_subscription'];
        }
        if(!empty($data['id_park'])) {
          $toChange['id_park'] = $data['id_park'];
        }
  
        if(count($toChange) > 0) {
    
          $fields = array();
          foreach($toChange as $k => $v) {
            $fields[] = $k.' = :'.$k;
          }
    
          $sql = "UPDATE `subscription_item` SET ".implode(',', $fields)." WHERE id = :id";
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
      
      public function selectParkExistSubscription($id_park){
        $sql = "SELECT * FROM `subscription_item` WHERE id_park = :id_park";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_park', $id_park);
        $sql->execute();
          
          if($sql->rowCount() > 0) {
            $data = $sql->fetch(\PDO::FETCH_ASSOC);
          }
        return $data;
      }
      
      public function cronSubscriptionGet($id){
        $sql = "SELECT * FROM `subscription` WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();
          
          if($sql->rowCount() > 0) {
            $data = $sql->fetch(\PDO::FETCH_ASSOC);
          }
        return $data;
	    }

      public function cronSubscriptionNewByIdPark($id_park){
        $sql = "SELECT N.id_user as id_user, P.doc, P.name_park, U.email, P.cell, P.postal_code, P.number, P.neighborhood, P.city, P.state, P.street, P.subscription FROM park_user AS N LEFT JOIN users AS U ON(N.id_user = U.id) LEFT JOIN parks AS P ON(N.id_park = P.id) WHERE N.id_park = :id_park AND N.id_office = 1 LIMIT 1";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_park', $id_park);
        $sql->execute();
          
          if($sql->rowCount() > 0) {
            $data = $sql->fetch(\PDO::FETCH_ASSOC);
          }
        return $data;
	    }
}