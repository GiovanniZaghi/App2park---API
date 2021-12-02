<?php
namespace Controllers;

use \Core\Controller;
use \Models\Parks;
use \Models\Users;
use \Models\Puser;
use \Models\Email;
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;
use \Aws\S3\S3Client;
use \Aws\S3\Exception\S3Exception;
use Aws\Sns\SnsClient; 
use Aws\Exception\AwsException;

class PuserController extends Controller {

    public function index() {
	}
    
    public function view($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $users = new Users();
        $parks = new Parks();
        $parkuser = new Puser();

		if(!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {
			switch($method) {
				case 'GET':
					$array['status'] = 'COMPLETED';
					$array['data'] = $parkuser->getInfo($id);

					if(count($array['data']) === 0) {
						$array['status'] = 'ERROR';
						$array['message'] = 'Estacionamentos não existem para esse usuário';
					}

					break;
				case 'PUT':
					break;
				case 'DELETE':
					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		} else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Acesso negado';
		}

		$this->returnJson($array);
	}


	public function accept_invite($keyval){
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $parkuser = new Puser();

		if(!empty($keyval) && $parkuser->validatekeyval($keyval)) {
	
			switch($method) {
				case 'GET':
						if($parkuser->exitsInviteByKelval($keyval)){
							header("Location: http://www.app2park.com.br/convite.php?s=2");
						}else{
							$parkuser->accept($keyval);
							header("Location: http://www.app2park.com.br/convite.php?s=1");
						}
					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}

		} else {
			header("Location: http://www.app2park.com.br/convite.php?s=2");
		}

		$this->returnJson($array);
	}


	public function invite_park(){
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();
		
		$users = new Users();
		$parks = new Parks();
		$parkuser = new Puser();
		$mail = new Email();

		if($method == 'POST') {
			if(!empty($data['id_park']) && !empty($data['id_office']) && !empty($data['first_name']) && !empty($data['id_user'])){
		
			    if(!empty($data['email']) || !empty($data['cell'])){
			
					if(!empty($data['email'])){
					  $id_user = $users->emailId($data['email']);
					}else{
					  $id_user = $users->cellId($data['cell']);
					}

					$email = $data['email'];
					$cell = $data['cell'];

					$valor_chave = md5(date('Y-m-d H:i:s').$id_user.$data['id_park']);

					$ar = array();
					$ar['usrs'] = $users->infoInviteByID($data['id_user']);
					$ar['parks'] = $parks->infoInviteByID($data['id_park']);
					$office = $parkuser->exitsJobByKelval($data['id_office']);
					$nome = $data['first_name'];

				if(!$id_user == null){
					if(!$parkuser->exitsUserInPark($id_user, $data['id_park'])){
						if(!$parkuser->exitsInvite($id_user, $data['id_park'])){
								$id_park_user = $parkuser->invite($data['id_park'], $id_user, $data['id_office'], $valor_chave);
	
								if(!is_null($id_park_user)){
									$array['status'] = 'COMPLETED';
									$data = array();
									$array['link_invite'] = BASE_URL."puser/accept/".$valor_chave;
									$array['puser'] = $parkuser->puserbyid($id_park_user);

									$desc = "<div style='background-color: #29CAA8; padding:55px; color:#000000;'><p style='color:#000000; padding:20px;'>
					<div style='background-color: #ffffff; padding:30px; border-radius: 20px;'>
					<img width='150'  src='https://www.app2park.com.br/assets/img/logo-app2park-footer.png' align='center'>
					<br>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Olá ".$nome."!<br>
									<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Este é um convite para você participar como colaborador do
									estacionamento abaixo.</p>
									<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Clique no link para aceitar:</p> <a href=".$array['link_invite'].">".$array['link_invite']."</a><br>
									<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Quem convidou:".$ar['usrs']['first_name']."</p>
									<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Telefone: ".$ar['usrs']['cell']."</p>
									<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>e-Mail: ".$ar['usrs']['email']."</p>
									<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Estacionamento: ".$ar['parks']['name_park']."</p>
									<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Endereço : ".$ar['parks']['street']." ".$ar['parks']['number']." - ".$ar['parks']['city'].", ".$ar['parks']['state']." - ".$ar['parks']['country']." - ".$ar['parks']['postal_code']."</p>
									<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Cargo/Função: ".$office."</p>
									<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Muito obrigado por escolher o App2park!</p></div></div>";

									$mail->sendMailDesc("Convite APP2PARK - ", $email, $desc);
									
									$params = array(
										'credentials' => array(
											'key' => 'AKIATNGEK5TFAH4WUX7W',
											'secret' => 'Giv2l+6JJ4INUJlMmjcfX2OpBx8Ug7Kn1ui+LsfC',
										),
										'region' => 'us-east-1', // < your aws from SNS Topic region
										'version' => 'latest'
									);
									$sns = new SnsClient($params);
									
									$args = array(
										"MessageAttributes" => [
													'AWS.SNS.SMS.SenderID' => [
														'DataType' => 'String',
														'StringValue' => 'App2Park'
													],
													'AWS.SNS.SMS.SMSType' => [
														'DataType' => 'String',
														'StringValue' => 'Transactional'
													]
												],
										"Message" => 'Convite App2Park - '.$array['link_invite'],
										"PhoneNumber" => '+550'.$cell
									);
									
									$result = $sns->publish($args);
								}else{
									$array['status'] = 'ERROR';
									$array['message'] = 'Convite não enviado!';
								}
							}else{
								$array['status'] = 'COMPLETED';
								$valor_chave = $parkuser->searchKeyval($id_user, $data['id_park']);
								$array['puser'] = $parkuser->puserbyiduseridpark($id_user, $data['id_park']);
								$array['link_invite'] = BASE_URL."puser/accept/".$valor_chave;

									$desc = "<div style='background-color: #29CAA8; padding:55px; color:#000000;'><p style='color:#000000; padding:20px;'>
					<div style='background-color: #ffffff; padding:30px; border-radius: 20px;'>
					<img width='150'  src='https://www.app2park.com.br/assets/img/logo-app2park-footer.png' align='center'>
					<br>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Olá ".$nome."!<br>
									<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Este é um convite para você participar como colaborador do
									estacionamento abaixo.</p>
									<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Clique no link para aceitar:</p> <a href=".$array['link_invite'].">".$array['link_invite']."</a><br>
									<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Quem convidou:".$ar['usrs']['first_name']."</p>
									<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Telefone: ".$ar['usrs']['cell']."</p>
									<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>e-Mail: ".$ar['usrs']['email']."</p>
									<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Estacionamento: ".$ar['parks']['name_park']."</p>
									<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Endereço : ".$ar['parks']['street']." ".$ar['parks']['number']." - ".$ar['parks']['city'].", ".$ar['parks']['state']." - ".$ar['parks']['country']." - ".$ar['parks']['postal_code']."</p>
									<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Cargo/Função: ".$office."</p>
									<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Muito obrigado por escolher o App2park!</p></div></div>";
									$mail->sendMailDesc("Convite APP2PARK - ", $email, $desc);

									$params = array(
										'credentials' => array(
											'key' => 'AKIATNGEK5TFAH4WUX7W',
											'secret' => 'Giv2l+6JJ4INUJlMmjcfX2OpBx8Ug7Kn1ui+LsfC',
										),
										'region' => 'us-east-1', // < your aws from SNS Topic region
										'version' => 'latest'
									);
									$sns = new SnsClient($params);
									
									$args = array(
										"MessageAttributes" => [
													'AWS.SNS.SMS.SenderID' => [
														'DataType' => 'String',
														'StringValue' => 'App2Park'
													],
													'AWS.SNS.SMS.SMSType' => [
														'DataType' => 'String',
														'StringValue' => 'Transactional'
													]
												],
										"Message" => 'Convite App2Park - '.$array['link_invite'],
										"PhoneNumber" => '+550'.$cell
									);
									
									$result = $sns->publish($args);
							}
									
					}else{
						$array['status'] = 'ERROR';
						$array['message'] = 'Este usuário já pertence a esse estacionamento!';
					}

				}else{
					$array['status'] = 'ERROR';
					$array['message'] = 'Usuário inexistente';
				}

			    }else{
					$array['status'] = 'ERROR';
					$array['message'] = 'Dados não preenchidos';
				}
			} else {
				$array['status'] = 'ERROR';
				$array['message'] = 'Dados não preenchidos';
			}
		} else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método '.$method.' não disponível';
		}

			$this->returnJson($array);
	}

	public function AllInvites($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $users = new Users();
        $parks = new Parks();
        $parkuser = new Puser();

		if(!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {
			switch($method) {
				case 'GET':
					$array['status'] = 'COMPLETED';
					$array['data'] = $parkuser->getAllInvites($id);

					if(count($array['data']) === 0) {
						$array['status'] = 'ERROR';
						$array['message'] = 'Estacionamentos não existem para esse usuário';
					}
				break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		} else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Acesso negado';
		}

		$this->returnJson($array);
	}

	public function AllInvitesActive($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $users = new Users();
        $parks = new Parks();
        $parkuser = new Puser();

		if(!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {
			switch($method) {
				case 'GET':
					$array['status'] = 'COMPLETED';
					$array['data'] = $parkuser->getAllInvitesActive($id);

					if(count($array['data']) === 0) {
						$array['status'] = 'ERROR';
						$array['message'] = 'Estacionamentos não existem para esse usuário';
					}
				break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		} else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Acesso negado';
		}

		$this->returnJson($array);
	}

	public function AllInvitesPending($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $users = new Users();
        $parks = new Parks();
        $parkuser = new Puser();

		if(!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {
			switch($method) {
				case 'GET':
					$array['status'] = 'COMPLETED';
					$array['data'] = $parkuser->getAllInvitesPending($id);

					if(count($array['data']) === 0) {
						$array['status'] = 'ERROR';
						$array['message'] = 'Estacionamentos não existem para esse usuário';
					}
				break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		} else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Acesso negado';
		}

		$this->returnJson($array);
	}


	public function AllInvitesInactive($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $users = new Users();
        $parks = new Parks();
        $parkuser = new Puser();

		if(!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {
			switch($method) {
				case 'GET':
					$array['status'] = 'COMPLETED';
					$array['data'] = $parkuser->getAllInvitesInactive($id);

					if(count($array['data']) === 0) {
						$array['status'] = 'ERROR';
						$array['message'] = 'Estacionamentos não existem para esse usuário';
					}
				break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		} else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Acesso negado';
		}

		$this->returnJson($array);
	}

	public function updateInvite(){
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();
		
		$users = new Users();
		$parkuser = new Puser();

		if($method == 'POST') {
			if(!empty($data['id']) && !empty($data['id_office']) && !empty($data['id_status'])) {

					$parkuser->updateInvite($data['id'], $data['id_office'], $data['id_status']);

					$array['status'] = 'COMPLETED';
					$array['data'] = $parkuser->getInviteById($data['id']);

			} else {
				$array['status'] = 'ERROR';
				$array['message'] = 'Dados não preenchidos';
			}
		} else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método '.$method.' não disponível';
		}

			$this->returnJson($array);
	}

	public function getAllPuser($id_park) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $users = new Users();
        $parks = new Parks();
        $parkuser = new Puser();

		switch($method) {
				case 'GET':
					$array['status'] = 'COMPLETED';
					$array['data'] = $parkuser->getPuser($id_park);

					if(count($array['data']) === 0) {
						$array['status'] = 'ERROR';
						$array['message'] = 'Estacionamentos não existem para esse usuário';
					}
				break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
	}

	public function sinc_Puser($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

		$users = new Users();

			switch($method) {
                case 'GET':
					$parkuser = new Puser();

					$array['status'] = 'COMPLETED';
					$array['puser'] = $parkuser->sincpuserdb($id);

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
	}
	
	public function sincOut_PuserOut($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

		$users = new Users();

			switch($method) {
                case 'GET':
					$parkuser = new Puser();

					$array['status'] = 'COMPLETED';
					$array['data'] = $parkuser->sincpuserout($id);

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
    }
}