<?php
namespace Models;

use \Core\Model;

class Cashs extends Model {

    public function createCashs($id_cash_app, $id_park, $id_user) {
        $sql = "INSERT INTO cashs (id_cash_app, id_park, id_user) VALUES (:id_cash_app, :id_park, :id_user)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_cash_app', $id_cash_app);
        $sql->bindValue(':id_park', $id_park);
        $sql->bindValue(':id_user', $id_user);
        $sql->execute();

        return $this->db->lastInsertId();
    }

    public function getCashsInfo($id){
          $sql = "SELECT * FROM cashs WHERE id = :id";
          $sql = $this->db->prepare($sql);
          $sql->bindValue(':id', $id);
          $sql->execute();
      
          if($sql->rowCount() > 0) {
            $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
          }
          return $data;
    }

    public function getAllCashsByIdPark($id_park){
      $sql = "SELECT * FROM cashs WHERE id_park = :id_park";
      $sql = $this->db->prepare($sql);
      $sql->bindValue(':id_park', $id_park);
      $sql->execute();
  
      if($sql->rowCount() > 0) {
        $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
      }
      return $data;
  }

    public function getAllCashsSinc($id_user, $sinc_time){
      $sql = "SELECT * FROM `cashs` WHERE id_park IN (SELECT id_park FROM park_user WHERE id_user = :id_user) AND sinc_time >= :sinc_time ORDER BY id";
      $sql = $this->db->prepare($sql);
      $sql->bindValue(':id_user', $id_user);
      $sql->bindValue(':sinc_time', $sinc_time);
      $sql->execute();

      if($sql->rowCount() > 0) {
        $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
      }
      return $data;
    }


    public function getAllCashTypeMovement(){
      $sql = "SELECT * FROM cash_type_movement";
      $sql = $this->db->prepare($sql);
      $sql->execute();

      if($sql->rowCount() > 0) {
        $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
      }
      return $data;
    }
  
    public function createCashMovement($id_cash, $id_ticket, $id_agreement, $id_cash_movement_app, $id_ticket_app, $id_agreement_app, $date_added,
    $id_cash_type_movement, $id_payment_method, $value, $comment) {
      $sql = "INSERT INTO cash_movement (id_cash, id_ticket, id_agreement, id_cash_movement_app, id_ticket_app, id_agreement_app, date_added, id_cash_type_movement, id_payment_method, value, comment) VALUES (:id_cash, :id_ticket, :id_agreement, :id_cash_movement_app, :id_ticket_app, :id_agreement_app, :date_added, :id_cash_type_movement, :id_payment_method, :value, :comment)";
      $sql = $this->db->prepare($sql);
      $sql->bindValue(':id_cash', $id_cash);
      $sql->bindValue(':id_ticket', $id_ticket);
      $sql->bindValue(':id_agreement', $id_agreement);
      $sql->bindValue(':id_cash_movement_app', $id_cash_movement_app);
      $sql->bindValue(':id_ticket_app', $id_ticket_app);
      $sql->bindValue(':id_agreement_app', $id_agreement_app);
      $sql->bindValue(':date_added', $date_added);
      $sql->bindValue(':id_cash_type_movement', $id_cash_type_movement);
      $sql->bindValue(':id_payment_method', $id_payment_method);
      $sql->bindValue(':value', $value);
      $sql->bindValue(':comment', $comment);
      $sql->execute();

      return $this->db->lastInsertId();
  }

  public function getCashMovementSinc($id){
    $sql = "SELECT * FROM `cash_movement` WHERE id_cash = :id ORDER BY id";
    $sql = $this->db->prepare($sql);
    $sql->bindValue(':id', $id);
    $sql->execute();

    if($sql->rowCount() > 0) {
      $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    return $data;
  }

  public function getCashMovementInfo($id){
    $sql = "SELECT * FROM `cash_movement` WHERE id = :id";
    $sql = $this->db->prepare($sql);
    $sql->bindValue(':id', $id);
    $sql->execute();

    if($sql->rowCount() > 0) {
      $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    return $data;
  }

  public function getAllCashMovementByIdCash($id_cash){
    $sql = "SELECT * FROM `cash_movement` WHERE id_cash = :id_cash";
    $sql = $this->db->prepare($sql);
    $sql->bindValue(':id_cash', $id_cash);
    $sql->execute();

    if($sql->rowCount() > 0) {
      $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    return $data;
  }


}