<?php
namespace Models;

use \Core\Model;

class Prices extends Model {

    public function createPriceDetached($id_price_detached_app, $id_park, $name, $daily_start, $id_vehicle_type, $id_status, $cash, $sort_order, $data_sinc) {
        $sql = "INSERT INTO price_detached (id_price_detached_app, id_park, name, daily_start, id_vehicle_type, id_status, `cash`, sort_order, data_sinc) 
        VALUES (:id_price_detached_app, :id_park, :name, :daily_start, :id_vehicle_type, :id_status, :cash, :sort_order, :data_sinc)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_price_detached_app', $id_price_detached_app);
        $sql->bindValue(':id_park', $id_park);
        $sql->bindValue(':name', $name);
        $sql->bindValue(':daily_start', $daily_start);
        $sql->bindValue(':id_vehicle_type', $id_vehicle_type);
        $sql->bindValue(':id_status', $id_status);
        $sql->bindValue(':cash', $cash);
        $sql->bindValue(':sort_order', $sort_order);
        $sql->bindValue(':data_sinc', $data_sinc);
        $sql->execute();

        return $this->db->lastInsertId();
    }

    public function getPriceDetachedById($id){
        $sql = "SELECT * FROM price_detached WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
      }

      
    public function getPriceDetachedByIdSinc($id){
      $sql = "SELECT * FROM price_detached WHERE id = :id";
      $sql = $this->db->prepare($sql);
      $sql->bindValue(':id', $id);
      $sql->execute();
  
      if($sql->rowCount() > 0) {
        $data = $sql->fetch(\PDO::FETCH_ASSOC);
      }
      return $data;
    }
    
    public function getPriceDetached($id_park){
        $sql = "SELECT * FROM price_detached WHERE id_park = :id_park";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_park', $id_park);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
      }

    public function createPriceDetachedItem($id_price_detached_item_app, $id_price_detached, $id_price_detached_item_base, $price, $tolerance) {
        $sql = "INSERT INTO `price_detached_item`(`id_price_detached_item_app`, `id_price_detached`, `id_price_detached_item_base`, `price`, `tolerance`) VALUES (:id_price_detached_item_app, :id_price_detached, :id_price_detached_item_base, :price, :tolerance)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_price_detached_item_app', $id_price_detached_item_app);
        $sql->bindValue(':id_price_detached', $id_price_detached);
        $sql->bindValue(':id_price_detached_item_base', $id_price_detached_item_base);
        $sql->bindValue(':price', $price);
        $sql->bindValue(':tolerance', $tolerance);
        $sql->execute();

        return $this->db->lastInsertId();
    }

    public function getPriceDetachedItem($id_price_detached){
        $sql = "SELECT * FROM price_detached_item WHERE id_price_detached = :id_price_detached";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_price_detached', $id_price_detached);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
    }

    public function deletePriceDetachedItem($id){
      $sql = "DELETE FROM `price_detached_item` WHERE id = :id";
      $sql = $this->db->prepare($sql);
      $sql->bindValue(':id', $id);
      $sql->execute();
    }

    public function editPriceDetached($id, $data) {

      $toChange = array();
  
      if(!empty($data['id_price_detached_app'])) {
        $toChange['id_price_detached_app'] = $data['id_price_detached_app'];
      }
      if(!empty($data['id_park'])) {
        $toChange['id_park'] = $data['id_park'];
      }
      if(!empty($data['name'])) {
        $toChange['name'] = $data['name'];
      }
      if(!empty($data['daily_start'])) {
        $toChange['daily_start'] = $data['daily_start'];
      }
      if(!empty($data['id_vehicle_type'])) {
        $toChange['id_vehicle_type'] = $data['id_vehicle_type'];
      }
      if($data['id_status'] != '' || $data['id_status'] != null) {
        $toChange['id_status'] = $data['id_status'];
      }
      if(!empty($data['cash'])) {
        $toChange['cash'] = $data['cash'];
      }
      if(!empty($data['sort_order'])) {
        $toChange['sort_order'] = $data['sort_order'];
      }
      if(!empty($data['data_sinc'])) {
        $toChange['data_sinc'] = $data['data_sinc'];
      }

      if(count($toChange) > 0) {
  
        $fields = array();
        foreach($toChange as $k => $v) {
          $fields[] = $k.' = :'.$k;
        }
  
        $sql = "UPDATE `price_detached` SET ".implode(',', $fields)." WHERE id = :id";
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

    public function editPriceDetachedItem($id, $data) {

      $toChange = array();
  
      if(!empty($data['id_price_detached_item_app'])) {
        $toChange['id_price_detached_item_app'] = $data['id_price_detached_item_app'];
      }
      if(!empty($data['id_price_detached'])) {
        $toChange['id_price_detached'] = $data['id_price_detached'];
      }
      if(!empty($data['id_price_detached_item_base'])) {
        $toChange['id_price_detached_item_base'] = $data['id_price_detached_item_base'];
      }
      if(!empty($data['price'])) {
        $toChange['price'] = $data['price'];
      }
      if(!empty($data['tolerance'])) {
        $toChange['tolerance'] = $data['tolerance'];
      }

      if(count($toChange) > 0) {
  
        $fields = array();
        foreach($toChange as $k => $v) {
          $fields[] = $k.' = :'.$k;
        }
  
        $sql = "UPDATE `price_detached_item` SET ".implode(',', $fields)." WHERE id = :id";
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

    public function getPriceDetachedItemById($id){
      $sql = "SELECT * FROM `price_detached_item` WHERE id = :id";
      $sql = $this->db->prepare($sql);
      $sql->bindValue(':id', $id);
      $sql->execute();
  
      if($sql->rowCount() > 0) {
        $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
      }
      return $data;
  }

      public function getPriceDetachedItemBase(){
        $sql = "SELECT * FROM price_detached_item_base";
        $sql = $this->db->prepare($sql);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
    }
}