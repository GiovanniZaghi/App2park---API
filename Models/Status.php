<?php
namespace Models;

use \Core\Model;

class Status extends Model {

	public function getStatusInfo(){
        $sql = "SELECT * FROM status";
        $sql = $this->db->prepare($sql);
        $sql->execute();
    
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
	}

}