<?php
namespace Controllers;

use \Core\Controller;
use \Models\Parks;
use \Models\Users;
use \Models\Customers;

class CustomersController extends Controller {

    public function index() {}

    public function view($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $customer = new Customers();

			switch($method) {
				case 'GET':
					$array['status'] = 'COMPLETED';
					$array['data'] = $customer->findCustomersByVehicle($id);

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
	
	public function find_doc($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $customer = new Customers();

			switch($method) {
				case 'GET':
					$array['status'] = 'COMPLETED';
					$array['data'] = $customer->findCustomersByDoc($id);

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

    public function new_customer() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
        $users = new Users();

        if($method == 'POST') {
            if(!empty($data['id_customer_app'])) {
                    $customer = new Customers();
                    
					$id_customer = $customer->customer($data['id_customer_app'],$data['cell'],$data['email'],$data['name'],$data['doc']);
					
					$array['status'] = 'COMPLETED';
					$array['data'] = $customer->findCustomers($id_customer);
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
	

	public function new_vehicle_customer() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
        $users = new Users();

        if($method == 'POST') {
            if(!empty($data['id_vehicle_customer_app'])) {
                    $customer = new Customers();
                    
					$id_vehicle_customer = $customer->createVehicleCustomers($data['id_vehicle_customer_app'],$data['id_customer'],$data['id_customer_app'],$data['id_vehicle'],$data['id_vehicle_app']);
					
					$array['status'] = 'COMPLETED';
					$array['data'] = $customer->findVehicleCustomer($id_vehicle_customer);
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
	
	public function search_vehicle_customer_by_plate($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $customer = new Customers();

			switch($method) {
				case 'GET':
					$array['status'] = 'COMPLETED';
					$array['customers'] = $customer->findCustomersByPlate($id);
					$array['vehiclecustomer'] = $customer->findVehicleCustomersByPlate($id);
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
}