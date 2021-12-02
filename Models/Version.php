<?php
namespace Models;

use \Core\Model;

class Version extends Model {

    public function getVersion(){
          $sql = "SELECT * FROM `version`";
          $sql = $this->db->prepare($sql);
          $sql->execute();
      
          if($sql->rowCount() > 0) {
            $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
          }
          return $data;
    }
}