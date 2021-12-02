<?php
namespace Models;

use \Core\Model;

class Cart extends Model {

    public function createCart($id_nota_fiscal_assinatura, $inter_number, $bank_slip_number, $bank_slip_value, $bank_slip_issue, $bank_slip_due, $status){

        $sql = "INSERT INTO `cart`(`id_nota_fiscal_assinatura`, `inter_number`, `bank_slip_number`, `bank_slip_value`, `bank_slip_issue`, `bank_slip_due`, `status`) VALUES (:id_nota_fiscal_assinatura, :inter_number, :bank_slip_number, :bank_slip_value, :bank_slip_issue, :bank_slip_due, :status)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_nota_fiscal_assinatura', $id_nota_fiscal_assinatura);
        $sql->bindValue(':inter_number', $inter_number);
        $sql->bindValue(':bank_slip_number', $bank_slip_number);
        $sql->bindValue(':bank_slip_value', $bank_slip_value);
        $sql->bindValue(':bank_slip_issue', $bank_slip_issue);
        $sql->bindValue(':bank_slip_due', $bank_slip_due);
        $sql->bindValue(':status', $status);
		    $sql->execute();

		  return $this->db->lastInsertId();
    }

    public function findCart($id){

		$sql = "SELECT * FROM `cart` WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetch(\PDO::FETCH_ASSOC);
		}
	    return $data;
    }

    public function editCart($id, $data) {

        $toChange = array();

        if(!empty($data['id_nota_fiscal'])) {
          $toChange['id_nota_fiscal'] = $data['id_nota_fiscal'];
        }
    
        if(!empty($data['inter_number'])) {
          $toChange['inter_number'] = $data['inter_number'];
        }
        if(!empty($data['bank_slip_number'])) {
          $toChange['bank_slip_number'] = $data['bank_slip_number'];
        }
        if(!empty($data['bank_slip_value'])) {
          $toChange['bank_slip_value'] = $data['bank_slip_value'];
        }
        if(!empty($data['bank_slip_issue'])) {
          $toChange['bank_slip_issue'] = $data['bank_slip_issue'];
        }
        if(!empty($data['bank_slip_due'])) {
          $toChange['bank_slip_due'] = $data['bank_slip_due'];
        }
        if(!empty($data['bank_slip_payment'])) {
          $toChange['bank_slip_payment'] = $data['bank_slip_payment'];
        }
        if(!empty($data['status'])) {
          $toChange['status'] = $data['status'];
        }
  
        if(count($toChange) > 0) {
    
          $fields = array();
          foreach($toChange as $k => $v) {
            $fields[] = $k.' = :'.$k;
          }
    
          $sql = "UPDATE `cart` SET ".implode(',', $fields)." WHERE id = :id";
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
  
    public function createCartItem($id_cart, $id_park, $id_period, $value){

        $sql = "INSERT INTO `cart_item`(`id_cart`, `id_park`, `id_period`, `value`) VALUES (:id_cart, :id_park, :id_period, :value)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_cart', $id_cart);
        $sql->bindValue(':id_park', $id_park);
        $sql->bindValue(':id_period', $id_period);
        $sql->bindValue(':value', $value);
		$sql->execute();

		return $this->db->lastInsertId();
    }

    public function findCartItem($id){

		$sql = "SELECT * FROM `cart_item` WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetch(\PDO::FETCH_ASSOC);
		}
	    return $data;
    }

    public function editCartItem($id, $data) {

        $toChange = array();
    
        if(!empty($data['id_cart'])) {
          $toChange['id_cart'] = $data['id_cart'];
        }
        if(!empty($data['id_park'])) {
          $toChange['id_park'] = $data['id_park'];
        }
        if(!empty($data['id_period'])) {
          $toChange['id_period'] = $data['id_period'];
        }
        if(!empty($data['value'])) {
          $toChange['value'] = $data['value'];
        }
  
        if(count($toChange) > 0) {
    
          $fields = array();
          foreach($toChange as $k => $v) {
            $fields[] = $k.' = :'.$k;
          }
    
          $sql = "UPDATE `cart_item` SET ".implode(',', $fields)." WHERE id = :id";
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

      public function findCartAndCartItemCron($today, $id_park){

        $sql = "SELECT C.*, I.* FROM cart_item AS I INNER JOIN cart AS C ON(I.id_cart = C.id) WHERE C.bank_slip_issue <= :today AND C.status = 0 AND I.id_park = :id_park ORDER BY C.bank_slip_due DESC LIMIT 1";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':today', $today);
        $sql->bindValue(':id_park', $id_park);
        $sql->execute();
    
          if($sql->rowCount() > 0) {
            $data = $sql->fetch(\PDO::FETCH_ASSOC);
          }
          return $data;
        }
    
        public function findAllCartNoPayments(){

          $sql = "SELECT C.*, I.*, C.id as id_cart_pk ,I.id as id_cart_item_pk, P.* FROM `cart` AS C LEFT JOIN cart_item AS I ON(C.id = I.id_cart) LEFT JOIN parks AS P ON(I.id_park = P.id) WHERE C.status = 0";
          $sql = $this->db->prepare($sql);
          $sql->execute();
      
          if($sql->rowCount() > 0) {
            $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
          }
            return $data;
        }

        public function updateCartPaymentConfirm($id, $bank_slip_payment, $status){

          $sql = "UPDATE `cart` SET `bank_slip_payment`= :bank_slip_payment,`status`= :status WHERE id = :id";
          $sql = $this->db->prepare($sql);
          $sql->bindValue(':id', $id);
          $sql->bindValue(':bank_slip_payment', $bank_slip_payment);
          $sql->bindValue(':status', $status);
          $sql->execute();
      
          return true;
    
        }

        public function findAllParkPendingBlock($subscription){

          $sql = "SELECT C.*, I.*, C.id as id_cart_pk ,I.id as id_cart_item_pk, P.* FROM `cart` AS C INNER JOIN cart_item AS I ON(C.id = I.id_cart) INNER JOIN parks AS P ON(I.id_park = P.id) WHERE C.status = 0 AND P.subscription = :subscription";
          $sql = $this->db->prepare($sql);
          $sql->bindValue(':subscription', $subscription);
          $sql->execute();
      
          if($sql->rowCount() > 0) {
            $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
          }
            return $data;
        }

        public function findAllParkPending($subscription){

          $sql = "SELECT * FROM `parks` WHERE subscription = :subscription";
          $sql = $this->db->prepare($sql);
          $sql->bindValue(':subscription', $subscription);
          $sql->execute();
      
          if($sql->rowCount() > 0) {
            $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
          }
            return $data;
        }

        public function findAllParkPendingwithParkInCart($id_park){

          $sql = "SELECT C.*, I.*, C.id as id_cart_pk ,I.id as id_cart_item_pk, P.* FROM `cart` AS C LEFT JOIN cart_item AS I ON(C.id = I.id_cart) LEFT JOIN parks AS P ON(I.id_park = P.id) WHERE I.id_park = :id_park ORDER BY C.bank_slip_issue DESC LIMIT 1";
          $sql = $this->db->prepare($sql);
          $sql->bindValue(':id_park', $id_park);
          $sql->execute();
      
          if($sql->rowCount() > 0) {
            $data = $sql->fetch(\PDO::FETCH_ASSOC);
          }
            return $data;
        }

        public function findvaluebyticket($id_ticket){

          $sql = "SELECT value FROM `cash_movement` WHERE id_ticket = :id_ticket";
          $sql = $this->db->prepare($sql);
          $sql->bindValue(':id_ticket', $id_ticket);
          $sql->execute();
      
          if($sql->rowCount() > 0) {
            $data = $sql->fetch(\PDO::FETCH_ASSOC);
          }
            return $data;
        }
}