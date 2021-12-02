<?php
namespace Controllers;

use \Core\Controller;

use \Models\Parks;
use \Models\Users;
use \Models\Vehicles;
use \Models\Payments;
use \Models\Prices;
use \Aws\S3\S3Client;
use \Aws\S3\Exception\S3Exception;

class ParksController extends Controller {

    public function index() {}
    
    public function new_record() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
		$users = new Users();
		$vehicle = new Vehicles();
		$pay = new Payments();
		$price = new Prices();
		$parks = new Parks();

    if(!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {
        if($method == 'POST') {
            if(!empty($data['type']) && !empty($data['doc']) && !empty($data['name_park'])
                && !empty($data['business_name'])
				&& !empty($data['cell']) && !empty($data['postal_code']) 
				&& !empty($data['street']) && !empty($data['number']) && !empty($data['neighborhood'])&& !empty($data['city'])
				&& !empty($data['state']) && !empty($data['country']) && !empty($data['vacancy']) && !empty($data['id_user'])) {


					if(!$parks->haveSubscriptionByIdUser($data['id_user'])){
					
						if($parks->haveParkUserByIdUser($data['id_user'])){
						
							$a = $parks->infoParkUserByid_user($data['id_user']);
							$p = $parks->getInfo($a['id_park']);

							$subscription = $p['subscription'];

							if($parks->create($data['type'], $data['doc'], $data['name_park'], $data['business_name'], $data['cell'], $data['postal_code'],
							$data['street'], $data['number'], $data['complement'], $data['neighborhood'], $data['city'], $data['state'], $data['country'], $data['vacancy'], $subscription, $data['id_user'])) {
									$id = $parks->getId();
		
									$arrayVehiclesType = $vehicle->getAllVehicleType();
		
									foreach ($arrayVehiclesType as $value) {
										$vehicle->createVehicleTypePark($value['id'],$id,$value['status'],$value['sort_order']);
									}
		
									$arrayPaymentsMethod = $pay->seachAllPayments();
		
									foreach($arrayPaymentsMethod as $value){
										$pay->createPaymentMethodPark($id, $value['id'], $value['flat_rate'], $value['variable_rate'],$value['min_value'], $value['status'], $value['sort_order']);
									}
		
									$arrayServiceAdditional = $parks->selectAllServicesAdditional();
		
									foreach($arrayServiceAdditional as $value){
										$parks->new_ServicePark($value['id'], $id, 0.00, '00:00:00', 1, 0);
									}
		
									$now = date_create()->format('Y-m-d H:i:s');
		
									$id_price_detached = $price->createPriceDetached(0, $id, 'Tabela Padrão', '00:00:00', 1, 1, 1, 1, $now);
		
									$price->createPriceDetachedItem(0, $id_price_detached, 100, 10.0, '00:00:00');
		
									$price->createPriceDetachedItem(0, $id_price_detached, 160, 2.0, '00:00:00');
									
									$array['status'] = 'COMPLETED';
									$array['data'] = $parks->getInfo($id);
	
							} else {
								$array['status'] = 'ERROR';
								$array['message'] = 'Não foi possível criar/ Estacionamento já existe';
							}
							
						}else{
							$subscription = date('Y-m-d', strtotime('+1 month'));

							if($parks->create($data['type'], $data['doc'], $data['name_park'], $data['business_name'], $data['cell'], $data['postal_code'],
							$data['street'], $data['number'], $data['complement'], $data['neighborhood'], $data['city'], $data['state'], $data['country'], $data['vacancy'], $subscription, $data['id_user'])) {
									$id = $parks->getId();
		
									$arrayVehiclesType = $vehicle->getAllVehicleType();
		
									foreach ($arrayVehiclesType as $value) {
										$vehicle->createVehicleTypePark($value['id'],$id,$value['status'],$value['sort_order']);
									}
		
									$arrayPaymentsMethod = $pay->seachAllPayments();
		
									foreach($arrayPaymentsMethod as $value){
										$pay->createPaymentMethodPark($id, $value['id'], $value['flat_rate'], $value['variable_rate'],$value['min_value'], $value['status'], $value['sort_order']);
									}
		
									$arrayServiceAdditional = $parks->selectAllServicesAdditional();
		
									foreach($arrayServiceAdditional as $value){
										$parks->new_ServicePark($value['id'], $id, 0.00, '00:00:00', 1, 0);
									}
		
									$now = date_create()->format('Y-m-d H:i:s');
		
									$id_price_detached = $price->createPriceDetached(0, $id, 'Tabela Padrão', '00:00:00',1, 1, 1, 1, $now);
		
									$price->createPriceDetachedItem(0, $id_price_detached, 100, 10.0, '00:00:00');
		
									$price->createPriceDetachedItem(0, $id_price_detached, 160, 2.0, '00:00:00');
									
									$array['status'] = 'COMPLETED';
									$array['data'] = $parks->getInfo($id);
	
							} else {
								$array['status'] = 'ERROR';
								$array['message'] = 'Não foi possível criar/ Estacionamento já existe';
							}
						}
					}else{
						$subscription = date('Y-m-d');

							if($parks->create($data['type'], $data['doc'], $data['name_park'], $data['business_name'], $data['cell'], $data['postal_code'],
							$data['street'], $data['number'], $data['complement'], $data['neighborhood'], $data['city'], $data['state'], $data['country'], $data['vacancy'], $subscription, $data['id_user'])) {
									$id = $parks->getId();
		
									$arrayVehiclesType = $vehicle->getAllVehicleType();
		
									foreach ($arrayVehiclesType as $value) {
										$vehicle->createVehicleTypePark($value['id'],$id,$value['status'],$value['sort_order']);
									}
		
									$arrayPaymentsMethod = $pay->seachAllPayments();
		
									foreach($arrayPaymentsMethod as $value){
										$pay->createPaymentMethodPark($id, $value['id'], $value['flat_rate'], $value['variable_rate'],$value['min_value'], $value['status'], $value['sort_order']);
									}
		
									$arrayServiceAdditional = $parks->selectAllServicesAdditional();
		
									foreach($arrayServiceAdditional as $value){
										$parks->new_ServicePark($value['id'], $id, 0.00, '00:00:00', 1, 0);
									}
		
									$now = date_create()->format('Y-m-d H:i:s');
		
									$id_price_detached = $price->createPriceDetached(0, $id, 'Tabela Padrão', '00:00:00',1, 1, 1, 1, $now);
		
									$price->createPriceDetachedItem(0, $id_price_detached, 100, 10.0, '00:00:00');
		
									$price->createPriceDetachedItem(0, $id_price_detached, 160, 2.0, '00:00:00');
									
									$array['status'] = 'COMPLETED';
									$array['data'] = $parks->getInfo($id);
	
							} else {
								$array['status'] = 'ERROR';
								$array['message'] = 'Não foi possível criar/ Estacionamento já existe';
							}
					}
            } else {
				$array['status'] = 'ERROR';
				$array['message'] = 'Dados não preenchidos';
            }
        } else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
        }
    }else{
		$array['status'] = 'ERROR';
		$array['message'] = 'Acesso negado';
    }

		$this->returnJson($array);
    }
    

    public function view($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $users = new Users();
        $parks = new Parks();

		if(!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {

			switch($method) {
				case 'GET':
					$array['status'] = 'COMPLETED';
					$array['data'] = $parks->getInfo($id);

					if(count($array['data']) === 0) {
						$array['status'] = 'ERROR';
						$array['message'] = 'Estacionamento não existe';
					}
					break;
				case 'PUT':
					$ok = $parks->editInfo($id, $data);
					

					if($ok === true){
						$array['status'] = 'COMPLETED';
						$array['data'] = $parks->getInfo($id);
						$array['message'] = 'Estacionamento Alterado Com Sucesso!';
					}else{
						$array['status'] = 'ERROR';
						$array['message'] = $ok;
					}
					break;
				case 'DELETE':
					$ok = $parks->delete($id);

					if($ok ===true){
						$array['status'] = 'COMPLETED';
						$array['message'] = 'Estacionamento Deletado Com Sucesso!';
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

	public function uploadImage(){
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();
		$parks = new Parks();
		
		if($method == 'POST') {
		 	if(isset($_FILES['file']) && !empty($data['id_park'])){
			
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

				// Move the file
				move_uploaded_file($tmp_name, $tmp_file_path);
				
				// Instantiate an Amazon S3 client.
				$s3 = new S3Client([
				'version' => 'latest',
				'region'  => 'us-east-1',
					'credentials' => [
						'key'    => 'AKIATNGEK5TFLRJX6LVB',
						'secret' => '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'
				 	]
				 ]);
				
				 $bucketName = 'app2parkstorage';				
				// // Upload a publicly accessible file. The file size and type are determined by the SDK.
				 try {
				 	$result = $s3->putObject([
				 		'Bucket' => $bucketName,
						'Key'    => "logos/{$data['id_park']}/{$tmp_file_name}",
						'body' 	 => $tmp_name,
						'SourceFile'   => $tmp_name,
						'ACL'    => 'public-read',
					 ]);
 
					if($parks->updateImage($data['id_park'], $result->get('ObjectURL'))){
						$array['status'] = 'COMPLETED';
						$array['data'] = $result->get('ObjectURL');	
					} else{
						$array['status'] = 'ERROR';
						$array['message'] = 'Ocorreu um erro ao salvar a imagem no banco!';
					}	

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

	public function new_schedule() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
		$users = new Users();
		$parks = new Parks();

    if(!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {
        if($method == 'POST') {
            if(!empty($data['id_park'])) {
					$id_park_schedule = $parks->CreateSchedule(
						$data['id_park'],
						$data['monday_daytime_open'], $data['monday_daytime_close'], $data['monday_nightly_open'], $data['monday_nightly_close'],
						$data['tuesday_daytime_open'],$data['tuesday_daytime_close'],$data['tuesday_nightly_open'], $data['tuesday_nightly_close'], 
						$data['wednesday_daytime_open'], $data['wednesday_daytime_close'], $data['wednesday_nightly_open'], $data['wednesday_nightly_close'],
						$data['thursday_daytime_open'], $data['thursday_daytime_close'], $data['thursday_nightly_open'], $data['thursday_nightly_close'],
						$data['friday_daytime_open'], $data['friday_daytime_close'], $data['friday_nightly_open'], $data['friday_nightly_close'],
						$data['saturday_daytime_open'], $data['saturday_daytime_close'], $data['saturday_nightly_open'], $data['saturday_nightly_close'],
						$data['sunday_daytime_open'], $data['sunday_daytime_close'], $data['sunday_nightly_open'], $data['sunday_nightly_close']
					); 

					if($id_park_schedule != 0){ 
						$array['status'] = 'COMPLETED';
						$array['message'] = 'Horário do estacionamento cadastrado com sucesso!';
					}else{
						$array['status'] = 'ERROR';
						$array['message'] = 'Não foi inserido com sucesso!';
					}
							
            } else {
				$array['status'] = 'ERROR';
				$array['message'] = 'Dados não preenchidos';
            }
        } else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
        }
    }else{
		$array['status'] = 'ERROR';
		$array['message'] = 'Acesso negado';
    }

		$this->returnJson($array);
	}
	

	public function new_park_price() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
		$users = new Users();
		$parks = new Parks();

    if(!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {
        if($method == 'POST') {
            if(!empty($data['name']) && !empty($data['id_park']) && !empty($data['id_vehicle_type'])) {
                   
					$id_park_price = $parks->CreateParkPrice($data['name'], $data['id_park'], $data['id_vehicle_type']);

					if(!is_null($id_park_price)){
						$array['status'] = 'COMPLETED';
						$data = array();
						$data['id_park_price'] = $id_park_price;
						$array['data'] = $data;
					}else{
						$array['status'] = 'ERROR';
						$array['message'] = 'Park Price não criado!';
					}

            } else {
				$array['status'] = 'ERROR';
				$array['message'] = 'Dados não preenchidos';
            }
        } else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
        }
    }else{
		$array['status'] = 'ERROR';
		$array['message'] = 'Acesso negado';
    }

		$this->returnJson($array);
    }

	public function new_park_price_item() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
		$users = new Users();
		$parks = new Parks();

    if(!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {

        if($method == 'POST') {
			if(!empty($data['id_park_price']) && !empty($data['position']) && !empty($data['name'])
				&& !empty($data['value'])&& !empty($data['price'])) {
                   
					$id_park_price_item = $parks->CreateParkPriceItem($data['id_park_price'], $data['position'],
					 $data['name'],$data['value'],$data['price'],$data['lack']);

					if(!is_null($id_park_price_item)){
						$array['status'] = 'COMPLETED';
						$data = array();
						$data['id_park_price_item'] = $id_park_price_item;
						$array['data'] = $data;
					}else{
						$array['status'] = 'ERROR';
						$array['message'] = 'Park Price Item não criado!';
					}

            } else {
				$array['status'] = 'ERROR';
				$array['message'] = 'Dados não preenchidos';
            }
        } else {
            $array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
        }
    }else{
		$array['status'] = 'ERROR';
		$array['message'] = 'Acesso negado';
    }

		$this->returnJson($array);
	}
	
	public function get_AllServicePark() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			switch($method) {
                case 'GET':
					$parks = new Parks();

					$array['status'] = 'COMPLETED';
					$array['data'] = $parks->getAllServicesPark();

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
	}
	
	public function get_AllServiceParkByIdPark($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			switch($method) {
                case 'GET':
					$parks = new Parks();

					$array['status'] = 'COMPLETED';
					$array['data'] = $parks->getAllServicesParkByParkId($id);

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
	}
	
	public function get_AllServiceParkById($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			switch($method) {
                case 'GET':
					$parks = new Parks();

					$array['status'] = 'COMPLETED';
					$array['data'] = $parks->getAllServicesParkId($id);

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
	}
	
	public function new_ServicePark() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();

		if($method == 'POST') {
			if(!empty($data['id_service_additional']) && !empty($data['id_park']) && !empty($data['price'])
				&& !empty($data['tolerance']) && !empty($data['sort_order']) && !empty($data['status']) && !empty($data['date_edited'])) {
				$parks = new Parks();
							
				$id_service_park = $parks->new_ServicePark($data['id_service_additional'],$data['id_park'],$data['price'],$data['tolerance'],$data['sort_order'],$data['status'],$data['date_edited']);

				$array['status'] = 'COMPLETED';
				$array['data'] = $parks->getAllServicesParkByParkId($id_service_park);

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
	
	public function update_service_park($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();
		$users = new Users();
		$parks = new Parks();

			switch($method) {
				case 'POST':
					$ok = $parks->editparkservice($id, $data);

					if($ok === true){
						$array['status'] = 'COMPLETED';
						$array['data'] = $parks->getAllServicesParkById($id);
						$array['message'] = 'Park Service Additional Alterado Com Sucesso!';
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

	public function sinc_parksByIdUser() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

		$users = new Users();
		$parks = new Parks();

			switch($method) {
				case 'POST':
					$array['status'] = 'COMPLETED';
					$array['data'] = $parks->getAllParkSincIdUser($data['id_user']);
 					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}

		$this->returnJson($array);
	}

	
	public function sinc_parksUserByIdParkIdUser() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

		$users = new Users();
		$parks = new Parks();

			switch($method) {
				case 'POST':
					$array['status'] = 'COMPLETED';
					$array['data'] = $parks->getParkUserByIdParkIdUserSinc($data['id_park'], $data['id_user']);
 					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}

		$this->returnJson($array);
	}

	public function sinc_userParkUserByIdPark() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

		$users = new Users();
		$parks = new Parks();

			switch($method) {
				case 'POST':
					$array['status'] = 'COMPLETED';
					$array['data'] = $parks->getusersParkUserByIdPark($data['id_park']);
 					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}

		$this->returnJson($array);
	}

	public function listallParksByIdUser($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			switch($method) {
                case 'GET':
					$parks = new Parks();

					$array['status'] = 'COMPLETED';
					$array['data'] = $parks->getAllParkSincIdUser($id);

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
	}
	
}