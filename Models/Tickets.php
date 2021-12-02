<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;

class Tickets extends Model {
	private $id_ticket;

	public function createTicketOnline($id_ticket_app, $id_park, $id_user, $id_vehicle, $id_vehicle_app, $id_customer, $id_customer_app, $id_agreement, $id_agreement_app, $id_cupom, $cupom_entrance_datetime){

		$sql = "INSERT INTO `tickets` ( `id_ticket_app`, `id_park`, `id_user`, `id_vehicle`, `id_vehicle_app`, `id_customer`, `id_customer_app`, `id_agreement`, `id_agreement_app`, `id_cupom`, `cupom_entrance_datetime`) VALUES (:id_ticket_app, :id_park, :id_user, :id_vehicle, :id_vehicle_app, :id_customer, :id_customer_app, :id_agreement, :id_agreement_app, :id_cupom, :cupom_entrance_datetime)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_ticket_app', $id_ticket_app);
		$sql->bindValue(':id_park', $id_park);
		$sql->bindValue(':id_user', $id_user);
        $sql->bindValue(':id_vehicle', $id_vehicle);
		$sql->bindValue(':id_vehicle_app', $id_vehicle_app);
		$sql->bindValue(':id_customer', $id_customer);
		$sql->bindValue(':id_customer_app', $id_customer_app);
		$sql->bindValue(':id_agreement', $id_agreement);
		$sql->bindValue(':id_agreement_app', $id_agreement_app);
		$sql->bindValue(':id_cupom', $id_cupom);
		$sql->bindValue(':cupom_entrance_datetime', $cupom_entrance_datetime);
		$sql->execute();

		return $id_ticket = $this->db->lastInsertId();

	}

	
	public function createTicketHistoricOnline($id_ticket_historic_app, $id_ticket, $id_ticket_app, $id_user, $id_ticket_historic_status, $id_service_additional, $date_time){

		$sql = "INSERT INTO `ticket_historic` (`id_ticket_historic_app`, `id_ticket`, `id_ticket_app`, `id_user`, `id_ticket_historic_status`, `id_service_additional`, `date_time`) VALUES (:id_ticket_historic_app, :id_ticket, :id_ticket_app, :id_user, :id_ticket_historic_status, :id_service_additional, :date_time)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_ticket_historic_app', $id_ticket_historic_app);
		$sql->bindValue(':id_ticket', $id_ticket);
		$sql->bindValue(':id_ticket_app', $id_ticket_app);
        $sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':id_ticket_historic_status', $id_ticket_historic_status);
		$sql->bindValue(':id_service_additional', $id_service_additional);
		$sql->bindValue(':date_time', $date_time);
		$sql->execute();

		return $this->db->lastInsertId();
	}

	public function findTicket($id){

		$sql = "SELECT * FROM `tickets` WHERE id =:id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetch(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function findTicketWithCupomAndId($id, $id_cupom){

		$sql = "SELECT * FROM `tickets` WHERE id =:id AND id_cupom = :id_cupom";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_cupom', $id_cupom);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetch(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function findTicketHistoric($id){

		$sql = "SELECT * FROM `ticket_historic` WHERE id =:id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetch(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function findTicketSend($id){

		$sql = "SELECT T.id, T.id_cupom, V.plate, C.color, V.year, M.maker, J.model, T.cupom_entrance_datetime, P.name_park, P.doc, P.postal_code, P.street, P.number, P.city, P.state, P.neighborhood, P.cell,  U.first_name, U.last_name, A.id as id_customer, A.email, A.cell as cell_customer, A.name AS nome_customer FROM tickets AS T LEFT JOIN vehicles AS V ON(T.id_vehicle = V.id) LEFT JOIN parks AS P ON(T.id_park = P.id) LEFT JOIN users AS U ON (T.id_user = U.id) LEFT JOIN vehicle_maker AS M ON(V.id_vehicle_maker = M.id) LEFT JOIN vehicle_model AS J ON (V.id_vehicle_model = J.id) LEFT JOIN vehicle_color AS C ON(V.id_vehicle_color = C.id) LEFT JOIN customers AS A ON(T.id_customer = A.id) WHERE T.id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetch(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	
	public function findTicketSendNull($id){

		$sql = "SELECT T.id, T.id_cupom, V.plate, T.cupom_entrance_datetime, P.name_park, P.doc, P.postal_code, P.street, P.number, P.city, P.state, P.neighborhood, P.cell, U.first_name, U.last_name, A.id as id_customer, A.email, A.cell as cell_customer, A.name AS nome_customer FROM tickets AS T LEFT JOIN vehicles AS V ON(T.id_vehicle = V.id) LEFT JOIN parks AS P ON(T.id_park = P.id) LEFT JOIN users AS U ON (T.id_user = U.id) LEFT JOIN customers AS A ON(T.id_customer = A.id) WHERE T.id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetch(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function getTicketHistoricStatus(){

		$sql = "SELECT * FROM ticket_historic_status";
		$sql = $this->db->prepare($sql);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function createTicketObject($id_ticket_object_app, $id_ticket, $id_ticket_app, $id_object){

		$sql = "INSERT INTO `ticket_object` (`id_ticket_object_app`, `id_ticket`, `id_ticket_app`, `id_object`)  VALUES (:id_ticket_object_app, :id_ticket, :id_ticket_app, :id_object)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_ticket_object_app', $id_ticket_object_app);
		$sql->bindValue(':id_ticket', $id_ticket);
		$sql->bindValue(':id_ticket_app', $id_ticket_app);
        $sql->bindValue(':id_object', $id_object);
		$sql->execute();

		return $this->db->lastInsertId();
	}

	public function createTicketHistoricPhoto($id_historic_photo_app, $id_ticket_historic, $id_ticket_historic_app, $photo, $date_time){

		$sql = "INSERT INTO `ticket_historic_photo` (`id_historic_photo_app`, `id_ticket_historic`, `id_ticket_historic_app`, `photo`, `date_time`)  VALUES (:id_historic_photo_app, :id_ticket_historic, :id_ticket_historic_app, :photo, :date_time)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_historic_photo_app', $id_historic_photo_app);
		$sql->bindValue(':id_ticket_historic', $id_ticket_historic);
		$sql->bindValue(':id_ticket_historic_app', $id_ticket_historic_app);
		$sql->bindValue(':photo', $photo);
		$sql->bindValue(':date_time', $date_time);
		$sql->execute();

		return $this->db->lastInsertId();
	}

	public function createTicketServiceAdditional($id_ticket_service_additional_app, $id_ticket, $id_ticket_app, $id_park_service_additional, $name,
		$price, $tolerance, $finish_estimate, $price_justification, $observation, $id_status){

		$sql = "INSERT INTO `ticket_service_additional`(`id_ticket_service_additional_app`, `id_ticket`, `id_ticket_app`, `id_park_service_additional`, `name`, `price`, `tolerance`, `finish_estimate`, `price_justification`, `observation`, `id_status`)  VALUES (:id_ticket_service_additional_app, :id_ticket, :id_ticket_app, :id_park_service_additional, :name, :price, :tolerance, :finish_estimate, :price_justification, :observation, :id_status)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_ticket_service_additional_app', $id_ticket_service_additional_app);
		$sql->bindValue(':id_ticket', $id_ticket);
		$sql->bindValue(':id_ticket_app', $id_ticket_app);
		$sql->bindValue(':id_park_service_additional', $id_park_service_additional);
		$sql->bindValue(':name', $name);
		$sql->bindValue(':price', $price);
		$sql->bindValue(':tolerance', $tolerance);
		$sql->bindValue(':finish_estimate', $finish_estimate);
		$sql->bindValue(':price_justification', $price_justification);
		$sql->bindValue(':observation', $observation);
		$sql->bindValue(':id_status', $id_status);
		$sql->execute();

		return $this->db->lastInsertId();
	}

	public function findTicketHistoricPhotoById($id){

		$sql = "SELECT * FROM `ticket_historic_photo` WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetch(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function findAllTicketsOpen($id_user, $sinc_time){

		$sql = "SELECT H.id_ticket, T.id_park, H.id_ticket_historic_status, T.sinc_time FROM tickets AS T LEFT JOIN ticket_historic AS H ON(H.id_ticket = T.id) WHERE T.id_park IN (SELECT id_park FROM park_user WHERE id_user = :id_user) AND T.sinc_time >= :sinc_time ORDER BY T.id DESC";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':sinc_time', $sinc_time);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function findTicketServiceAdditional($id){

		$sql = "SELECT * FROM `ticket_service_additional` WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetch(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function findTicketCustomers($id){

		$sql = "SELECT C.* FROM `tickets` AS T LEFT JOIN customers AS C ON(T.id_customer = C.id) WHERE T.id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

	}
	
	public function getAllTicketObject(){

		$sql = "SELECT * FROM ticket_object";
		$sql = $this->db->prepare($sql);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function getAllTicketObjectById($id){

		$sql = "SELECT * FROM ticket_object WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function getTicketsSinc($id){

		$sql = "SELECT * FROM `tickets` WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	
	public function getTicketHistoricSinc($id){

		$sql = "SELECT * FROM `ticket_historic` WHERE id_ticket = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function getTicketObjectSinc($id){

		$sql = "SELECT * FROM `ticket_object` WHERE id_ticket = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function getTicketServiceAdditionalSinc($id){

		$sql = "SELECT * FROM `ticket_service_additional` WHERE id_ticket = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function getTicketHistoricPhotoSinc($id){

		$sql = "SELECT S.* FROM `ticket_historic_photo` AS S LEFT JOIN ticket_historic AS H ON(S.id_ticket_historic = H.id) WHERE H.id_ticket = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function getTicketsVehicleInfoSinc($id){

		$sql = "SELECT V.id, T.id AS type, M.maker, O.model, C.color, plate, year FROM tickets AS J LEFT JOIN vehicles as V ON(J.id_vehicle = V.id) LEFT JOIN vehicle_type AS T ON(V.id_vehicle_type = T.id) LEFT JOIN vehicle_maker AS M ON(V.id_vehicle_maker = M.id) LEFT JOIN vehicle_model AS O ON(V.id_vehicle_model = O.id) LEFT JOIN vehicle_color AS C ON(V.id_vehicle_color = C.id) WHERE J.id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	
	public function infoTicketPark($id, $id_cupom){

		$sql = "SELECT P.name_park, P.postal_code, P.cell, P.street, P.number, P.complement, P.neighborhood, P.city, P.state, P.doc FROM `tickets` AS T LEFT JOIN parks AS P ON(T.id_park = P.id) WHERE T.id = :id AND T.id_cupom = :id_cupom";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_cupom', $id_cupom);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function infoTicketUser($id, $id_cupom){

		$sql = "SELECT U.first_name, U.last_name FROM tickets AS T LEFT JOIN users AS U ON(T.id_user = U.id) WHERE T.id = :id AND T.id_cupom = :id_cupom";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_cupom', $id_cupom);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function infoTicketVehicle($id, $id_cupom){

		$sql = "SELECT T.type, M.maker, O.model, C.color, plate, year FROM tickets AS J LEFT JOIN vehicles as V ON(J.id_vehicle = V.id) LEFT JOIN vehicle_type AS T ON(V.id_vehicle_type = T.id) LEFT JOIN vehicle_maker AS M ON(V.id_vehicle_maker = M.id) LEFT JOIN vehicle_model AS O ON(V.id_vehicle_model = O.id) LEFT JOIN vehicle_color AS C ON(V.id_vehicle_color = C.id) WHERE J.id = :id AND J.id_cupom = :id_cupom";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_cupom', $id_cupom);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function infoTicket($id, $id_cupom){

		$sql = "SELECT id, id_cupom, cupom_entrance_datetime, sinc_time FROM tickets WHERE id = :id AND id_cupom = :id_cupom";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_cupom', $id_cupom);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function infoTicketHistoric($id, $id_cupom){

		$sql = "SELECT S.name, H.date_time, H.id_ticket_historic_status FROM `ticket_historic` AS H LEFT JOIN ticket_historic_status AS S ON(H.id_ticket_historic_status = S.id) LEFT JOIN tickets AS X ON(H.id_ticket = X.id) WHERE X.id = :id AND X.id_cupom = :id_cupom";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_cupom', $id_cupom);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	
	public function infoTicketHistoricPhoto($id, $id_cupom){

		$sql = "SELECT S.photo, S.date_time FROM `ticket_historic_photo` AS S LEFT JOIN ticket_historic AS H ON(S.id_ticket_historic = H.id) LEFT JOIN tickets AS X ON(H.id_ticket = X.id) WHERE X.id = :id AND X.id_cupom = :id_cupom";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_cupom', $id_cupom);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function infoTicketObject($id, $id_cupom){

		$sql = "SELECT A.name FROM `ticket_object` AS O LEFT JOIN objects AS A ON(O.id_object = A.id) LEFT JOIN tickets AS X ON(O.id_ticket = X.id) WHERE X.id = :id AND X.id_cupom = :id_cupom";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_cupom', $id_cupom);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function infoTicketServiceAdditional($id, $id_cupom){

		$sql = "SELECT name, price, tolerance, observation FROM `ticket_service_additional` AS S LEFT JOIN tickets AS T ON(S.id_ticket = T.id) WHERE T.id = :id AND T.id_cupom = :id_cupom";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_cupom', $id_cupom);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

	}

	public function searchTicketOnByOff($id_ticket_app, $id_park, $id_cupom){

		$sql = "SELECT id, id_cupom FROM tickets WHERE id_ticket_app = :id_ticket_app AND id_park = :id_park AND id_cupom = :id_cupom";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_ticket_app', $id_ticket_app);
		$sql->bindValue(':id_park', $id_park);
		$sql->bindValue(':id_cupom', $id_cupom);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

	}


	public function editTicket($id, $data) {

		$toChange = array();

		if(!empty($data['id_ticket_app'])) {
			$toChange['id_ticket_app'] = $data['id_ticket_app'];
		}
		if(!empty($data['id_park'])) {
			$toChange['id_park'] = $data['id_park'];
		}
		if(!empty($data['id_user'])) {
			$toChange['id_user'] = $data['id_user'];
		}
		if(!empty($data['id_vehicle'])) {
			$toChange['id_vehicle'] = $data['id_vehicle'];
		}
		if(!empty($data['id_vehicle_app'])) {
			$toChange['id_vehicle_app'] = $data['id_vehicle_app'];
		}
		if(!empty($data['id_customer'])) {
			$toChange['id_customer'] = $data['id_customer'];
		}
		if(!empty($data['id_customer_app'])) {
			$toChange['id_customer_app'] = $data['id_customer_app'];
		}
		if(!empty($data['id_agreement'])) {
			$toChange['id_agreement'] = $data['id_agreement'];
		}
		if(!empty($data['id_agreement_app'])) {
			$toChange['id_agreement_app'] = $data['id_agreement_app'];
		}
		if(!empty($data['id_cupom'])) {
			$toChange['id_cupom'] = $data['id_cupom'];
		}

		if(!empty($data['cupom_entrance_datetime'])) {
			$toChange['cupom_entrance_datetime'] = $data['cupom_entrance_datetime'];
		}

		if(count($toChange) > 0) {

			$fields = array();
			foreach($toChange as $k => $v) {
				$fields[] = $k.' = :'.$k;
			}

			$sql = "UPDATE `tickets` SET ".implode(',', $fields)." WHERE id = :id";
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
}