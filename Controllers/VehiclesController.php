<?php
namespace Controllers;

use \Core\Controller;
use \Models\Parks;
use \Models\Users;
use \Models\Vehicles;
use Guzzle\Http\Client;

class VehiclesController extends Controller {

    public function index() {}

    public function view($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $users = new Users();
        $vehicle = new Vehicles();

			switch($method) {
                case 'GET':
                    
                    $placa = strtoupper($id);

					$array['status'] = 'COMPLETED';
                    $datas = $vehicle->getInfo($id);
                    
                    if($datas != null){
                        $array['status'] = 'COMPLETED';
                        $array['data'] =  $datas;
                    }else{
                        $cURLConnection = curl_init();

                        curl_setopt($cURLConnection, CURLOPT_URL, 'https://apicarros.com/v2/consultas/'.strtoupper($id).'/a752609f3c3436018852e0e7e046c05b');
                        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYHOST, false);
                        curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, false);
                        
                        $phoneList = curl_exec($cURLConnection);
                        curl_close($cURLConnection);
                        
                        $a = json_decode($phoneList);

                        if($a->placa == null){

                            $verifica = $vehicle->getInfoPlates($id);

                            if($verifica == null){
                                $id_vehicle = $vehicle->vehicles(1, null, null, null, $id, null);

                                $datas = $vehicle->getInfoPlateID($id_vehicle);
                                $array['status'] = 'COMPLETED';
                                $array['data'] =  $datas;
                                $array['message'] = $a->mensagem;
                            }else{
                                $datas = $vehicle->getInfoPlateID($verifica['id']);
                                $array['status'] = 'COMPLETED';
                                $array['data'] =  $datas;
                                $array['message'] = $a->mensagem;
                            }
                        }else{
                            $id_maker = $vehicle->getMaker(strtoupper($a->marca)); 
                        
                            if($id_maker == null){
                                $id_maker = $vehicle->maker(strtoupper($a->marca));
                            }
    
                            $id_model = $vehicle->getModel(strtoupper($a->modelo)); 
    
                            if($id_model == null){
                                $id_model = $vehicle->model($id_maker, strtoupper($a->modelo));
                            }
    
                            $id_color = $vehicle->getColor(strtoupper($a->cor)); 
                            
                            if($id_color == null){
                                $id_color = $vehicle->color(strtoupper($a->cor));
                            }
    
                            $id_vehicle = $vehicle->vehicles(1, $id_maker, $id_model, $id_color, strtoupper($id), $a->ano);
    
                            $datas = $vehicle->getInfoID($id_vehicle);
    
                            if($datas != null){
                                $array['status'] = 'COMPLETED';
                                $array['data'] =  $datas;
                            }
                        }
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

		$this->returnJson($array);
	}
    
    public function new_vehicle() {
        $array = array('status'=>'', 'message'=>'');
        
		$method = $this->getMethod();
        $data = $this->getRequestData();
        $users = new Users();

    if(!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {

        if($method == 'POST') {
            if(!empty($data['id_vehicle_type']) && !empty($data['id_vehicle_maker']) && !empty($data['id_vehicle_model'])
                && !empty($data['id_vehicle_color']) && !empty($data['plate']) && !empty($data['year'])) {
                    $vehicle = new Vehicles();
                    
                    $vehicle->vehicles($data['id_vehicle_type'],$data['id_vehicle_maker'],$data['id_vehicle_model'],
                    $data['id_vehicle_color'],$data['plate'],$data['year']);

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


    public function new_type() {
        $array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
        $users = new Users();

    if(!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {
        
        if($method == 'POST') {
            if(!empty($data['type'])) {
                    $vehicle = new Vehicles();
                    
                    $vehicle->type($data['type']);

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

    public function new_maker() {
        $array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
        $users = new Users();

    if(!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {
        
        if($method == 'POST') {
            if(!empty($data['maker'])) {
                    $vehicle = new Vehicles();
                    
                    $vehicle->maker($data['maker']);

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

    public function new_color() {
        $array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
        $users = new Users();

    if(!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {
        
        if($method == 'POST') {
            if(!empty($data['color'])) {
                    $vehicle = new Vehicles();
                    
                    $vehicle->color($data['color']);

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

    public function new_model() {
        $array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
        $users = new Users();

    if(!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {
        
        if($method == 'POST') {
            if(!empty($data['id_vehicle_maker']) && !empty($data['model'])) {
                    $vehicle = new Vehicles();
                    
                    $vehicle->model($data['id_vehicle_maker'], $data['model']);

                $array['status'] = 'ERROR';
                $array['message'] = 'Dados não preenchidos';

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

    public function get_vehicleType() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

		$users = new Users();

		//if(!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {

			switch($method) {
                case 'GET':
                    $vehicle = new Vehicles();

					$array['status'] = 'COMPLETED';
					$array['data'] = $vehicle->getAllVehicleType();

					break;
				case 'POST':
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

		//} else {
		//	$array['status'] = 'ERROR';
		//	$array['message'] = 'Acesso negado';
		//}

		$this->returnJson($array);
	}

    public function new_vehicletypepark() {
        $array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
        $users = new Users();

    //if(!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {
        
        if($method == 'POST') {
            if(!empty($data['id_vehicle_type']) && !empty($data['id_payment_method']) && !empty($data['status']) && !empty($data['sort_order'])) {
                    $vehicle = new Vehicles();
                    
                    $id_vehicle_type_park = $vehicle->createVehicleTypePark($data['id_vehicle_type'], $data['id_park'], $data['status'],$data['sort_order']);

                    if($id_vehicle_type_park != null){
                        $array['status'] = 'COMPLETED';
                        $array['message'] = 'Vehicle Type Park criado com sucesso!';
                    }else{
                        $array['status'] = 'ERROR';
                        $array['message'] = 'Houve um erro interno, por favor entre em contato com o administrador';
                    }

            } else {
                $array['status'] = 'ERROR';
                $array['message'] = 'Dados não preenchidos';
            }
        } else {
            $array['status'] = 'ERROR';
            $array['message'] = 'Método de requisição incompatível';         
        }
    //}else{
      //  $array['status'] = 'ERROR';
        //$array['message'] = 'Acesso negado';
    //}
		$this->returnJson($array);
    }

    public function get_vehicleTypePark($id_park) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

		$users = new Users();

		//if(!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {

			switch($method) {
                case 'GET':
                    $vehicle = new Vehicles();

					$array['status'] = 'COMPLETED';
					$array['data'] = $vehicle->seachVehicleTypePark($id_park);

					break;
				case 'POST':
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

		//} else {
		//	$array['status'] = 'ERROR';
		//	$array['message'] = 'Acesso negado';
		//}

		$this->returnJson($array);
	}

    public function get_vehicleTypeParkByPark($id_park) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

		$users = new Users();

		//if(!empty($data['jwt']) && $users->validateJwt($data['jwt'])) {

			switch($method) {
                case 'GET':
                    $vehicle = new Vehicles();

					$array['status'] = 'COMPLETED';
					$array['data'] = $vehicle->seachVehicleTypeParkByIdPark($id_park);

					break;
				case 'POST':
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

		//} else {
		//	$array['status'] = 'ERROR';
		//	$array['message'] = 'Acesso negado';
		//}

		$this->returnJson($array);
    }

    public function update_vehicle_type_park($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();
		$users = new Users();
        $vehicle = new Vehicles();

			switch($method) {
				case 'POST':
					$ok = $vehicle->editvehicletypepark($id, $data);

					if($ok === true){
						$array['status'] = 'COMPLETED';
						$array['data'] = $vehicle->findvehicletypepark($id);
						$array['message'] = 'Vehicle Type Park Alterado Com Sucesso!';
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
    
    
    public function sinc_vehicleTypeParkByPark($id_park) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

		$users = new Users();

			switch($method) {
                case 'GET':
                    $vehicle = new Vehicles();

					$array['status'] = 'COMPLETED';
					$array['data'] = $vehicle->sincVehicleTypePark($id_park);

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
    }

}