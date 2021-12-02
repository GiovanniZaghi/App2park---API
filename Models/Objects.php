<?php
namespace Models;

use \Core\Model;

class Objects extends Model {
    public function getAllObjects(){
        $sql = "SELECT * FROM objects";
        $sql = $this->db->prepare($sql);
        $sql->execute();
  
        if($sql->rowCount() > 0) {
          $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $data;
    }
}