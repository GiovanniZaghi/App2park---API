<?php
namespace Models;

use \Core\Model;

class Services extends Model {

	public function getServices(){
        $sql = "SELECT * FROM service_additional";
        $sql = $this->db->prepare($sql);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
	}

  public function sincParkServiceAdditional($id_park) {
    $array = array();

    $sql = "SELECT * FROM park_service_additional WHERE id_park = :id_park";
    $sql = $this->db->prepare($sql);
    $sql->bindValue(':id_park', $id_park);
    $sql->execute();

    if($sql->rowCount() > 0) {
      $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    return $data;
  }
}