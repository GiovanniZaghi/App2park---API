<?php
namespace Controllers;

use \Core\Controller;
use \Models\Parks;
use \Models\Users;
use \Models\Puser;
use \Models\Tickets;
use \Models\Customers;
use \Models\Email;
use \Models\Log;
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;
use \Aws\S3\S3Client;
use \Aws\S3\Exception\S3Exception;
use Aws\Sns\SnsClient; 
use Aws\Exception\AwsException;

class TicketsController extends Controller {

    public function index() {
    }
    
    public function view($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $users = new Users();
        $ticket = new Tickets();

			switch($method) {
				case 'GET':
					$array['status'] = 'COMPLETED';
					$array['data'] = $ticket->findTicket($id);
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

		$this->returnJson($array);
	}
    
    public function new_record() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
		$users = new Users();
		$customers = new Customers();

        if($method == 'POST') {
            if(!empty($data['id_park']) && !empty($data['id_user']) && !empty($data['id_cupom'])) {
                    $ticket = new Tickets();
                    
				   $idt = $ticket->createTicketOnline($data['id_ticket_app'], $data['id_park'], $data['id_user'],
					$data['id_vehicle'], $data['id_vehicle_app'], $data['id_customer'], $data['id_customer_app'],
					$data['id_agreement'], $data['id_agreement_app'], $data['id_cupom'], $data['cupom_entrance_datetime']);

                   $array['status'] = 'COMPLETED';
				   $array['data'] = $ticket->findTicket($idt);				   
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

	public function update_tickets($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();
		$users = new Users();
		$ticket = new Tickets();

			switch($method) {
				case 'POST':
					$ok = $ticket->editTicket($id, $data);

					if($ok === true){
						$array['status'] = 'COMPLETED';
						$array['data'] = $ticket->findTicket($id);
						$array['message'] = 'Ticket Alterado Com Sucesso!';
					}else{
						$array['status'] = 'ERROR';
						$array['message'] = $ok;
					}
				break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}

		$this->returnJson($array);
	}
	
	public function get_TicketHistoricStatus() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $ticket = new Tickets();

			switch($method) {
				case 'GET':
					$array['status'] = 'COMPLETED';
					$array['data'] = $ticket->getTicketHistoricStatus();
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

		$this->returnJson($array);
	}
	
	public function get_TicketAllObject() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $ticket = new Tickets();

			switch($method) {
				case 'GET':
					$array['status'] = 'COMPLETED';
					$array['data'] = $ticket->getAllTicketObject();
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

		$this->returnJson($array);
	}

	public function get_AllTicketsOpen() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $ticket = new Tickets();

			switch($method) {
				case 'POST':
					$array['status'] = 'COMPLETED';
					$array['allticketsopen'] = $ticket->findAllTicketsOpen($data['id_user'], $data['sinc_time']);
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

		$this->returnJson($array);
	}

	public function get_AllInformationTickets($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $ticket = new Tickets();

			switch($method) {
				case 'GET':
					$array['status'] = 'COMPLETED';
					$array['tickets'] = $ticket->getTicketsSinc($id);
					$array['ticket_historic'] = $ticket->getTicketHistoricSinc($id);
					$array['ticket_object'] = $ticket->getTicketObjectSinc($id);
					$array['ticket_service_additional'] = $ticket->getTicketServiceAdditionalSinc($id);
					$array['ticket_historic_photo'] = $ticket->getTicketHistoricPhotoSinc($id);
					$array['tickets_vehicle'] = $ticket->getTicketsVehicleInfoSinc($id);
					$array['tickets_customers'] = $ticket->findTicketCustomers($id);
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

		$this->returnJson($array);
	}

	public function ticketon_ticketoff() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $ticket = new Tickets();

			switch($method) {
				case 'POST':
					$array['status'] = 'COMPLETED';
					$array['tickets'] = $ticket->searchTicketOnByOff($data['id_ticket_app'], $data['id_park'], $data['id_cupom']);
 					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}

		$this->returnJson($array);
	}

	public function information_tickets() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $ticket = new Tickets();

			switch($method) {
				case 'POST':
					$array['status'] = 'COMPLETED';
					$array['tickets'] = $ticket->infoTicket($data['id_ticket'], $data['id_cupom']);
					$array['ticket_historic'] = $ticket->infoTicketHistoric($data['id_ticket'], $data['id_cupom']);
					$array['ticket_object'] = $ticket->infoTicketObject($data['id_ticket'], $data['id_cupom']);
					$array['ticket_service_additional'] = $ticket->infoTicketServiceAdditional($data['id_ticket'], $data['id_cupom']);
					$array['ticket_historic_photo'] = $ticket->infoTicketHistoricPhoto($data['id_ticket'], $data['id_cupom']);
					$array['tickets_vehicle'] = $ticket->infoTicketVehicle($data['id_ticket'], $data['id_cupom']);
					$array['tickets_park'] = $ticket->infoTicketPark($data['id_ticket'], $data['id_cupom']);
					$array['tickets_user'] = $ticket->infoTicketUser($data['id_ticket'], $data['id_cupom']);
 					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}

		$this->returnJson($array);
	}

	public function get_TicketObjectById($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $ticket = new Tickets();

			switch($method) {
				case 'GET':
					$array['status'] = 'COMPLETED';
					$array['data'] = $ticket->getAllTicketObjectById($id);
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

		$this->returnJson($array);
	}

	public function new_ticketObject() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();

		if($method == 'POST') {
			if(!empty($data['id_ticket_object_app']) && !empty($data['id_ticket']) && !empty($data['id_ticket_app'])
				&& !empty($data['id_object'])) {
				$ticket = new Tickets();
							
				$id_ticket_object = $ticket->createTicketObject($data['id_ticket_object_app'], $data['id_ticket'],$data['id_ticket_app'],$data['id_object']);

				$array['status'] = 'COMPLETED';
				$array['data'] = $ticket->getAllTicketObjectById($id_ticket_object);

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

	public function new_ticket_service_additional() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
		$users = new Users();

        if($method == 'POST') {
            if(!empty($data['id_ticket_service_additional_app'])) {
                   $ticket = new Tickets();
                    
				   $id_service_additional = $ticket->createTicketServiceAdditional($data['id_ticket_service_additional_app'], $data['id_ticket'], $data['id_ticket_app'],
					$data['id_park_service_additional'], $data['name'], $data['price'], $data['tolerance'], $data['finish_estimate'], $data['price_justification'], $data['observation'], $data['id_status']);

                   $array['status'] = 'COMPLETED';
				   $array['data'] = $ticket->findTicketServiceAdditional($id_service_additional);				   
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
	
	public function new_ticket_historic() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
		$users = new Users();
		$customers = new Customers();

        if($method == 'POST') {
            if(!empty($data['id_ticket_historic_app'])) {
                    $ticket = new Tickets();
                    
				   $idt = $ticket->createTicketHistoricOnline($data['id_ticket_historic_app'], $data['id_ticket'], $data['id_ticket_app'],
					$data['id_user'], $data['id_ticket_historic_status'], $data['id_service_additional'], $data['date_time']);

                   $array['status'] = 'COMPLETED';
				   $array['data'] = $ticket->findTicketHistoric($idt);				   
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

	public function create_ticket_historic_photo(){
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();
		$ticket = new Tickets();
		
		if($method == 'POST') {
		 	if(isset($_FILES['file']) && !empty($data['id_park'])&& !empty($data['id_historic_photo_app'])&& !empty($data['id_ticket_historic_app'])){
			
				$file = $_FILES['file'];

				// File details
				$name = $file['name'];
				$tmp_name = $file['tmp_name'];

				$extension = explode('.', $name);
				$extension = strtolower(end($extension));

				// Tmp details
				$key = md5(uniqid());
				$tmp_file_name = "{$key}.{$extension}";
				$tmp_file_path = "files/{$tmp_file_name}";
				
				// Instantiate an Amazon S3 client.
				$s3 = new S3Client([
				'version' => 'latest',
				'region'  => 'us-east-1',
					'credentials' => [
						'key'    => 'AKIATNGEK5TFAH4WUX7W',
						'secret' => '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'
				 	]
				 ]);
				
				 $bucketName = 'app2parkstorage';				
				// // Upload a publicly accessible file. The file size and type are determined by the SDK.
				 try {
				 	$result = $s3->putObject([
				 		'Bucket' => $bucketName,
						'Key'    => "parks/{$data['id_park']}/{$tmp_file_name}",
						'body' 	 => $tmp_name,
						'SourceFile'   => $tmp_name,
						'ACL'    => 'public-read',
					 ]);

					 $id_ticket_photo = $ticket->createTicketHistoricPhoto($data['id_historic_photo_app'],$data['id_ticket_historic'],$data['id_ticket_historic_app'],$result->get('ObjectURL'),$data['date_time']);
					 
					 $array['status'] = 'COMPLETED';
					 $array['data'] = $ticket->findTicketHistoricPhotoById($id_ticket_photo);	


				 } catch (Aws\S3\Exception\S3Exception $e) {
					$array['status'] = 'ERROR';
				 	$array['message'] = $e->getMessage();
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


	    
    public function send_tickets() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
		$users = new Users();
		$mail = new Email();
		$log = new Log();

        if($method == 'POST') {
            if(!empty($data['id_ticket'])) {
                   $ticket = new Tickets();
                   $array['status'] = 'COMPLETED';
				   $array['data'] = $ticket->findTicketSend($data['id_ticket']);

				   if($array['data'] == null){
					$array['data'] = $ticket->findTicketSendNull($data['id_ticket']);

					$entrada = date("d/m/Y H:i:s", strtotime($array['data']['cupom_entrance_datetime']));

					$desc = "<div style='background-color: #29CAA8; padding:55px; color:#000000;'><p style='color:#000000; padding:20px;'>
					<div style='background-color: #ffffff; padding:30px; border-radius: 20px;'>
					<img width='150'  src='https://www.app2park.com.br/assets/img/logo-app2park-footer.png' align='center'>
					<br>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Olá ".$array['data']['nome_customer']."!</p>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Este é o seu ticket </p>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Cupom: ".$array['data']['id_cupom']."</p>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Placa: ".$array['data']['plate']."</p>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Entrada: ".$entrada."</p>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Estacionamento: ".$array['data']['name_park']."<br>
					".$array['data']['street'].", ".$array['data']['number']."
					".$array['data']['neighborhood']."
					".$array['data']['city']."-".$array['data']['state']."<br>
					".$array['data']['postal_code']."<br>
					".$array['data']['doc']."<br>
					".$array['data']['cell']."</p>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Atendente: ".$array['data']['first_name']." ".$array['data']['last_name']."</p>
					Acesso   o   link   abaxo   para: <br>
					<a href='https://app2park.com.br/nota-fiscal.php'>- Solicitar sua NF </a><br>
					- Visualizar   as   fotos   do   veículo <br>  
					- Baixar   nosso   APP   - Pagamento   pelo   APP <br>
					<a href="."https://www.app2park.com.br/ticket.php?id=".$data['id_ticket']."&cupom=".$array['data']['id_cupom'].">"."https://www.app2park.com.br/ticket.php?id=".$data['id_ticket']."&cupom=".$array['data']['id_cupom']."</a><br></div></div>
					";
				   }else{

					$entrada = date("d/m/Y H:i:s", strtotime($array['data']['cupom_entrance_datetime']));

					$desc = "<div style='background-color: #29CAA8; padding:55px; color:#000000;'><p style='color:#000000; padding:20px;'>
					<div style='background-color: #ffffff; padding:30px; border-radius: 20px;'>
					<img width='150'  src='https://www.app2park.com.br/assets/img/logo-app2park-footer.png' align='center'>
					<br>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Olá !".$array['data']['nome_customer']."</p>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Este é o seu ticket </p>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Cupom: ".$array['data']['id_cupom']."</p>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Placa: ".$array['data']['plate']."</p>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Entrada: ".$entrada."</p>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Veículo: ".$array['data']['model']." <br>
					".$array['data']['maker']."<br>
					".$array['data']['year']."<br>
					".$array['data']['color']." </p>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Estacionamento: ".$array['data']['name_park']."<br>
					".$array['data']['street'].", ".$array['data']['number']."
					".$array['data']['neighborhood']."
					".$array['data']['city']."-".$array['data']['state']."<br>
					".$array['data']['postal_code']."<br>
					".$array['data']['doc']."<br>
					".$array['data']['cell']."</p>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Atendente: ".$array['data']['first_name']." ".$array['data']['last_name']."</p><br>
					Acesso   o   link   abaxo   para: <br>
					<a href='https://app2park.com.br/nota-fiscal.php'>- Solicitar sua NF </a> <br>
					- Visualizar   as   fotos   do   veículo <br>  
					- Baixar   nosso   APP   - Pagamento   pelo   APP <br>
					<a href="."https://www.app2park.com.br/ticket.php?id=".$data['id_ticket']."&cupom=".$array['data']['id_cupom'].">"."https://www.app2park.com.br/ticket.php?id=".$data['id_ticket']."&cupom=".$array['data']['id_cupom']."</a><br><p></div></div>
				 ";
				   }
				
				   if($array['data']['email'] != null){
					$mail->sendMailDesc("Ticket APP2PARK - ", $array['data']['email'], $desc);
				   }

				if($array['data']['cell_customer'] != null){

					 $params = array(
						'credentials' => array(
							'key'    => 'AKIATNGEK5TFKLNHZYMU',
							'secret' => '7agYyreX2xE2iBn3TtemXM63dK1dND9uWcZsfl1J'
						),
						'region' => 'us-east-1', // < your aws from SNS Topic region
						'version' => 'latest'
					);
					$sns = new SnsClient($params);

					$entrada = date("d/m/Y H:i:s", strtotime($array['data']['cupom_entrance_datetime']));

					$numero = '+55'.$array['data']['cell_customer'];
					
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
						"Message" => 'App2Park -- CUPOM : '.$array['data']['id_cupom'].' - PLACA: '.$array['data']['plate'].' - ENTRADA: '.$entrada.' - ESTACIONAMENTO : '.$array['data']['name_park'].' - Detalhes: https://www.app2park.com.br/ticket.php?id='.$array['data']['id'].'&cupom='.$array['data']['id_cupom'],
						"PhoneNumber" => $numero
					);
					
					$result = $sns->publish($args);

					$log->createLog($numero.' AMAZON: '.$result);
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