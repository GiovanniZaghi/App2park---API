<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;

class Customers extends Model {
    private $id_customer;

    public function customer($id_customer_app, $cell, $email, $name, $doc){

        $sql = "INSERT INTO customers (id_customer_app, cell, email, name, doc, id_status) VALUES (:id_customer_app, :cell, :email, :name,:doc, 1)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_customer_app', $id_customer_app);
        $sql->bindValue(':cell', $cell);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':name', $name);
        $sql->bindValue(':doc', $doc);
		$sql->execute();

		return $this->db->lastInsertId();
    }

    public function findCustomersByVehicle($id_vehicle){

       $sql = "SELECT C.id, C.id_customer_app, C.cell, C.email, C.name, C.doc FROM vehicle_customer AS V INNER JOIN customers AS C ON(V.id_customer = C.id) WHERE V.id_vehicle = :id_vehicle";
       $sql = $this->db->prepare($sql);
       $sql->bindValue(':id_vehicle', $id_vehicle);
       $sql->execute();

       if($sql->rowCount() > 0) {
           $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
       }
       return $data;
   }

   public function findCustomersByPlate($plate){

    $sql = "SELECT C.* FROM `vehicle_customer` AS V INNER JOIN customers AS C ON(C.id = V.id_customer) INNER JOIN vehicles AS H ON(H.id = V.id_vehicle) WHERE H.plate = :plate";
    $sql = $this->db->prepare($sql);
    $sql->bindValue(':plate', $plate);
    $sql->execute();

    if($sql->rowCount() > 0) {
        $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    return $data;
}

public function findVehicleCustomersByPlate($plate){

    $sql = "SELECT V.* FROM `vehicle_customer` AS V INNER JOIN customers AS C ON(C.id = V.id_customer) INNER JOIN vehicles AS H ON(H.id = V.id_vehicle) WHERE H.plate = :plate";
    $sql = $this->db->prepare($sql);
    $sql->bindValue(':plate', $plate);
    $sql->execute();

    if($sql->rowCount() > 0) {
        $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    return $data;
}


   
   public function findCustomers($id){

    $sql = "SELECT * FROM `customers` WHERE id = :id";
    $sql = $this->db->prepare($sql);
    $sql->bindValue(':id', $id);
    $sql->execute();

    if($sql->rowCount() > 0) {
        $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    return $data;
}

   public function getEmailById($id){
    $sql = "SELECT email FROM customers WHERE id = :id";
    $sql = $this->db->prepare($sql);
    $sql->bindValue(':id', $id);
    $sql->execute();

    $info = $sql->fetch();

    return $info['email']; 
}

   public function findCustomersByDoc($doc){

    $sql = "SELECT id, cell, email, name, doc FROM customers  WHERE doc = :doc";
    $sql = $this->db->prepare($sql);
    $sql->bindValue(':doc', $doc);
    $sql->execute();

    if($sql->rowCount() > 0) {
        $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    return $data;
  }


  public function createVehicleCustomers($id_vehicle_customer_app, $id_customer, $id_customer_app, $id_vehicle, $id_vehicle_app){

    $sql = "INSERT INTO `vehicle_customer` (`id_vehicle_customer_app`, `id_customer`, `id_customer_app`, `id_vehicle`, `id_vehicle_app`) VALUES (:id_vehicle_customer_app, :id_customer, :id_customer_app, :id_vehicle,:id_vehicle_app)";
    $sql = $this->db->prepare($sql);
    $sql->bindValue(':id_vehicle_customer_app', $id_vehicle_customer_app);
    $sql->bindValue(':id_customer', $id_customer);
    $sql->bindValue(':id_customer_app', $id_customer_app);
    $sql->bindValue(':id_vehicle', $id_vehicle);
    $sql->bindValue(':id_vehicle_app', $id_vehicle_app);
    $sql->execute();

    return  $this->db->lastInsertId();
  }

  public function findVehicleCustomer($id){

    $sql = "SELECT * FROM `vehicle_customer` WHERE id = :id";
    $sql = $this->db->prepare($sql);
    $sql->bindValue(':id', $id);
    $sql->execute();

    if($sql->rowCount() > 0) {
        $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    return $data;
}

}