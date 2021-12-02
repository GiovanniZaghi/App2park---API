<?php
namespace Models;

use \Core\Model;

class Offices extends Model {

	public function getOfficesInfo(){
        $sql = "SELECT * FROM offices";
        $sql = $this->db->prepare($sql);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
	}
}