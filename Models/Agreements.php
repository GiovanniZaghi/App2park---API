<?php
namespace Models;

use \Core\Model;

class Agreements extends Model {

    public function createAgreement(
    $id_agreement_app, $id_park, $id_user, $agreement_type,
    $date_time, $agreement_begin, $agreement_end, $accountable_name, $accountable_doc, $accountable_cell,
    $accountable_email, $send_nf, $doc_nf, $company_name, $company_doc, $company_cell, $company_email,
    $bank_slip_send, $payment_day, $mon, $tue, $wed, $thur, $fri, $sat, $sun, $time_on, $time_off, $id_price_detached,
    $parking_spaces, $price, $plates, $comment, $status_payment, $until_payment
    ){
		$sql = "INSERT INTO `agreements`(`id_agreement_app`, `id_park`, `id_user`, `agreement_type`, `date_time`, `agreement_begin`, `agreement_end`, `accountable_name`, `accountable_doc`, `accountable_cell`, `accountable_email`, `send_nf`, `doc_nf`, `company_name`, `company_doc`, `company_cell`, `company_email`, `bank_slip_send`, `payment_day`, `mon`, `tue`, `wed`, `thur`, `fri`, `sat`, `sun`, `time_on`, `time_off`, `id_price_detached`, `parking_spaces`, `price`, `plates`, `comment`, `status_payment`, `until_payment`) VALUES(:id_agreement_app, :id_park, :id_user, :agreement_type, :date_time, :agreement_begin, :agreement_end, :accountable_name, :accountable_doc, :accountable_cell, :accountable_email, :send_nf, :doc_nf, :company_name, :company_doc, :company_cell, :company_email, :bank_slip_send, :payment_day, :mon, :tue, :wed, :thur, :fri, :sat, :sun, :time_on, :time_off, :id_price_detached, :parking_spaces, :price, :plates, :comment, :status_payment, :until_payment)";
		$sql = $this->db->prepare($sql);
		    $sql->bindValue(':id_agreement_app', $id_agreement_app);
	    	$sql->bindValue(':id_park', $id_park);
		    $sql->bindValue(':id_user', $id_user);
        $sql->bindValue(':agreement_type', $agreement_type);
        $sql->bindValue(':date_time', $date_time);
        $sql->bindValue(':agreement_begin', $agreement_begin);
        $sql->bindValue(':agreement_end', $agreement_end);
        $sql->bindValue(':accountable_name', $accountable_name);
        $sql->bindValue(':accountable_doc', $accountable_doc);
        $sql->bindValue(':accountable_cell', $accountable_cell);
        $sql->bindValue(':accountable_email', $accountable_email);
        $sql->bindValue(':send_nf', $send_nf);
        $sql->bindValue(':doc_nf', $doc_nf);
        $sql->bindValue(':company_name', $company_name);
        $sql->bindValue(':company_doc', $company_doc);
        $sql->bindValue(':company_cell', $company_cell);
        $sql->bindValue(':company_email', $company_email);
        $sql->bindValue(':bank_slip_send', $bank_slip_send);
        $sql->bindValue(':payment_day', $payment_day);
        $sql->bindValue(':mon', $mon);
        $sql->bindValue(':tue', $tue);
        $sql->bindValue(':wed', $wed);
        $sql->bindValue(':thur', $thur);
        $sql->bindValue(':fri', $fri);
        $sql->bindValue(':sat', $sat);
        $sql->bindValue(':sun', $sun);
        $sql->bindValue(':time_on', $time_on);
        $sql->bindValue(':time_off', $time_off);
        $sql->bindValue(':id_price_detached', $id_price_detached);
        $sql->bindValue(':parking_spaces', $parking_spaces);
        $sql->bindValue(':price', $price);
        $sql->bindValue(':plates', $plates);
        $sql->bindValue(':comment', $comment);
        $sql->bindValue(':status_payment', $status_payment);
        $sql->bindValue(':until_payment', $until_payment);
        $sql->execute();

        return $this->db->lastInsertId();
  }
    
    public function findAgreementById($id){

		$sql = "SELECT * FROM `agreements` WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetch(\PDO::FETCH_ASSOC);
		}
		return $data;

  }

  public function sincFindAgreementsInParks($id_user){

		$sql = "SELECT * FROM `agreements` WHERE id_park IN (SELECT id_park FROM park_user WHERE id_user = :id_user)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$data = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}
		return $data;

  }
  
  public function editAgreements($id, $data) {

		$toChange = array();

		if(!empty($data['id_agreement_app'])) {
			$toChange['id_agreement_app'] = $data['id_agreement_app'];
		}
		if(!empty($data['id_park'])) {
			$toChange['id_park'] = $data['id_park'];
		}
		if(!empty($data['id_user'])) {
			$toChange['id_user'] = $data['id_user'];
		}
		if(!empty($data['agreement_type'])) {
			$toChange['agreement_type'] = $data['agreement_type'];
		}
		if(!empty($data['date_time'])) {
			$toChange['date_time'] = $data['date_time'];
		}
		if(!empty($data['agreement_begin'])) {
			$toChange['agreement_begin'] = $data['agreement_begin'];
		}
		if(!empty($data['agreement_end'])) {
			$toChange['agreement_end'] = $data['agreement_end'];
		}
		if(!empty($data['accountable_name'])) {
			$toChange['accountable_name'] = $data['accountable_name'];
		}
		if(!empty($data['accountable_doc'])) {
			$toChange['accountable_doc'] = $data['accountable_doc'];
		}
		if(!empty($data['accountable_cell'])) {
			$toChange['accountable_cell'] = $data['accountable_cell'];
		}
    if($data['send_nf'] != '' || $data['send_nf'] != null) {
			$toChange['send_nf'] = $data['send_nf'];
    }
    if($data['doc_nf'] != '' || $data['doc_nf'] != null) {
			$toChange['doc_nf'] = $data['doc_nf'];
    }
    if(!empty($data['company_name'])) {
			$toChange['company_name'] = $data['company_name'];
    }
    if(!empty($data['company_doc'])) {
			$toChange['company_doc'] = $data['company_doc'];
    }
    if(!empty($data['company_cell'])) {
			$toChange['company_cell'] = $data['company_cell'];
    }
    if(!empty($data['company_email'])) {
			$toChange['company_email'] = $data['company_email'];
    }
    if(!empty($data['bank_slip_send'])) {
			$toChange['bank_slip_send'] = $data['bank_slip_send'];
    }
    if(!empty($data['payment_day'])) {
			$toChange['payment_day'] = $data['payment_day'];
    }
    if($data['mon'] != '' || $data['mon'] != null) {
			$toChange['mon'] = $data['mon'];
    }
    if($data['tue'] != '' || $data['tue'] != null) {
			$toChange['tue'] = $data['tue'];
    }
    if($data['wed'] != '' || $data['wed'] != null) {
			$toChange['wed'] = $data['wed'];
    }
    if($data['thur'] != '' || $data['thur'] != null) {
			$toChange['thur'] = $data['thur'];
    }
    if($data['fri'] != '' || $data['fri'] != null) {
			$toChange['fri'] = $data['fri'];
    }
    if($data['sat'] != '' || $data['sat'] != null) {
			$toChange['sat'] = $data['sat'];
    }
    if($data['sun'] != '' || $data['sun'] != null) {
			$toChange['sun'] = $data['sun'];
    }
    if(!empty($data['time_on'])) {
			$toChange['time_on'] = $data['time_on'];
    }
    if(!empty($data['time_off'])) {
			$toChange['time_off'] = $data['time_off'];
    }
    if(!empty($data['id_price_detached'])) {
			$toChange['id_price_detached'] = $data['id_price_detached'];
    }
    if(!empty($data['parking_spaces'])) {
			$toChange['parking_spaces'] = $data['parking_spaces'];
    }
    if(!empty($data['price'])) {
			$toChange['price'] = $data['price'];
    }
    if(!empty($data['plates'])) {
			$toChange['plates'] = $data['plates'];
    }
    if(!empty($data['comment'])) {
			$toChange['comment'] = $data['comment'];
    }
    if($data['status_payment'] != '' || $data['status_payment'] != null) {
			$toChange['status_payment'] = $data['status_payment'];
    }
    if(!empty($data['until_payment'])) {
			$toChange['until_payment'] = $data['until_payment'];
    }
    
		if(count($toChange) > 0) {

			$fields = array();
			foreach($toChange as $k => $v) {
				$fields[] = $k.' = :'.$k;
			}

			$sql = "UPDATE `agreements` SET ".implode(',', $fields)." WHERE id = :id";
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