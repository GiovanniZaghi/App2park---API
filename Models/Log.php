<?php
namespace Models;

use \Core\Model;

class Log extends Model {

    public function createLog($id_user = null, $id_park = null, $error = null, $version = null, $created = null, $screen_error = null, $platform = null){

		$sql = "INSERT INTO `log`(`id_user`, `id_park`, `error`, `version`, `created`, `screen_error`, `platform`) VALUES (:id_user, :id_park, :error, :version, :created, :screen_error, :platform)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':id_park', $id_park);
		$sql->bindValue(':error', $error);
		$sql->bindValue(':version', $version);
		$sql->bindValue(':created', $created);
		$sql->bindValue(':screen_error', $screen_error);
		$sql->bindValue(':platform', $platform);
		$sql->execute();

		return $this->db->lastInsertId();
    }
}