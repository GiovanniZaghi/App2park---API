<?php
namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Photos;
use \Models\Email;
use \Models\Masterpass;
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

class UsersController extends Controller {

	public function index() {}

	public function login() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

		if($method == 'POST') {
			if(!empty($data['email']) && !empty($data['pass'])) {
				$users = new Users();
				$master = new Masterpass();

				$arraypass = $master->geMasterPass();

				//var_dump($arraypass);

				if($users->checkCredentials($data['email'], $data['pass'], $arraypass['pass'])) {
					$array['jwt'] = $users->createJwt();
					$id = $users->getId();
					$array['status'] = 'COMPLETED';
					$array['data'] = $users->getInfo($id);
				} else {
					$array['status'] = 'ERROR';
					$array['message'] = 'Acesso negado';
				}
			} else {
				$array['status'] = 'ERROR';
				$array['message'] = 'E-mail e/ou senha não preenchido.';
			}
		} else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
		}

		$this->returnJson($array);
	}

	public function new_record() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			if($method == 'POST') {
				if(!empty($data['first_name']) && !empty($data['last_name']) && !empty($data['cell'])
				 && !empty($data['doc']) && !empty($data['email'])&& !empty($data['pass'])) {
					if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
						$users = new Users();
						if($users->create($data['first_name'], $data['last_name'], $data['cell'], $data['doc'],$data['email'],$data['pass'])) {
							$array['jwt'] = $users->createJwt();
							$id = $users->getId();
							$array['status'] = 'COMPLETED';
							$array['data'] = $users->getInfo($id);
						} else {
							$array['status'] = 'ERROR';
							$array['message'] = 'Esse e-mail ja esta cadastrado para um usuário.';
						}
					} else {
						$array['status'] = 'ERROR';
						$array['message'] = 'E-mail inválido';
					}
				} else {
					$array['status'] = 'ERROR';
					$array['message'] = 'Dados não preenchidos';
				}
			} else {
				$array['status'] = 'ERROR';
				$array['message'] = 'Método de requisição incompatível';
			}

		$this->returnJson($array);
	}

	public function view($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

		$users = new Users();

		if(!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {

			switch($method) {
				case 'GET':
					$array['status'] = 'COMPLETED';
					$array['data'] = $users->getInfo($id);

					if(count($array['data']) === 0) {
						$array['status'] = 'ERROR';
						$array['message'] = 'Usuário não existe';
					}
					break;
				case 'POST':
					$ok = $users->editInfo($id, $data);

					if($ok === true){
						$array['status'] = 'COMPLETED';
						$array['data'] = $users->getInfo($id);
						$array['message'] = 'Usuário Alterado Com Sucesso!';
					}else{
						$array['status'] = 'ERROR';
						$array['message'] = $ok;
					}
				break;
				case 'PUT':
					break;
				case 'DELETE':

					$ok = $users->delete($id);

					if($ok ===true){
						$array['status'] = 'COMPLETED';
						$array['message'] = 'Usuário Deletado Com Sucesso!';
					}else{
						$array['status'] = 'ERROR';
						$array['message']= $ok;
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

	public function reset_pass() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			if($method == 'POST') {
				if(!empty($data['email'])) {
					if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
						$users = new Users();

						$id_email_user = $users->emailId($data['email']);

						if($id_email_user != null){

							if($users->existsChangePass($id_email_user)){
								$array['status'] = 'COMPLETED';
								$dado = $users->seachPass($id_email_user);
								$array['data'] = $dado;
							}else{
								$valor_chave = md5(date('Y-m-d H:i:s').$data['email'].$id_email_user);

								$valor_chave = substr($valor_chave,0,4);

								$id_reset_password = $users->CreateKelValPassword($id_email_user, $valor_chave);

								$array['status'] = 'COMPLETED';
								$array['data'] = $valor_chave;

							}

							$mail = new Email();

							$mail->sendMail('Código de recuperação APP2PARK',$data['email'], 'O seu código de recuperação é', $array['data']);

						}else{
							$array['status'] = 'ERROR';
							$array['message'] = 'E-mail não existe cadastrado no sistema';
						}

					} else {
						$array['status'] = 'ERROR';
						$array['message'] = 'E-mail inválido';
					}
				} else {
					$array['status'] = 'ERROR';
					$array['message'] = 'Dados não preenchidos';
				}
			} else {
				$array['status'] = 'ERROR';
				$array['message'] = 'Método de requisição incompatível';
			}

		$this->returnJson($array);
	}

	public function new_pass() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			if($method == 'POST') {
				if(!empty($data['keyval']) && !empty($data['pass']) && !empty($data['email'])) {
					if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
						$users = new Users();

						if($users->keyvalPasswordExists($data['keyval'])){
							
							$id_user_pass = $users->emailId($data['email']);

							$ok = $users->editInfo($id_user_pass, $data);

							if($ok === true){

								$users->deleteKeyVal($data['keyval']);

								$array['status'] = 'COMPLETED';
								$array['data'] = $users->getInfo($id_user_pass);
								$array['message'] = 'Usuário Alterado Com Sucesso!';
							}else{
								$array['status'] = 'ERROR';
								$array['message'] = $ok;
							}

						}else{
							$array['status'] = 'ERROR';
							$array['message'] = 'Chave para alteração Inválida!';
						}

					} else {
						$array['status'] = 'ERROR';
						$array['message'] = 'E-mail inválido';
					}
				} else {
					$array['status'] = 'ERROR';
					$array['message'] = 'Dados não preenchidos';
				}
			} else {
				$array['status'] = 'ERROR';
				$array['message'] = 'Método de requisição incompatível';
			}

		$this->returnJson($array);
	}

}



















