<?php
namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Cashs;

class CashsController extends Controller {

    public function index() {}
    
    public function new_Cashs() {
        $array = array('status'=>'', 'message'=>'');
        
		$method = $this->getMethod();
        $data = $this->getRequestData();

        if($method == 'POST') {
                    $cash = new Cashs();
                    
                    $id_cash = $cash->createCashs($data['id_cash_app'],$data['id_park'],$data['id_user']);

                    $array['status'] = 'COMPLETED';
                    $array['data'] = $cash->getCashsInfo($id_cash);
        } else {
            $array['status'] = 'ERROR';
            $array['message'] = 'Método de requisição incompatível';
        }
        
		$this->returnJson($array);
	}
	
	public function sinc_allcashs() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

		$cash = new Cashs();

			switch($method) {
				case 'POST':
					$array['status'] = 'COMPLETED';
					$array['data'] = $cash->getAllCashsSinc($data['id_user'], $data['sinc_time']);
					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}

		$this->returnJson($array);
	}


    public function new_CashMovement() {
        $array = array('status'=>'', 'message'=>'');
        
		$method = $this->getMethod();
        $data = $this->getRequestData();

        if($method == 'POST') {
                    $cash = new Cashs();
                    
                    $id_cash_movemen = $cash->createCashMovement($data['id_cash'],$data['id_ticket'], $data['id_agreement'],
                    $data['id_cash_movement_app'],$data['id_ticket_app'], $data['id_agreement_app'], $data['date_added'],
                    $data['id_cash_type_movement'],$data['id_payment_method'],$data['value'], $data['comment']);

                    $array['status'] = 'COMPLETED';
                    $array['data'] = $cash->getCashMovementInfo($id_cash_movemen);
        } else {
            $array['status'] = 'ERROR';
            $array['message'] = 'Método de requisição incompatível';
        }
        
		$this->returnJson($array);
	}
	
	public function get_cashMovement($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			switch($method) {
                case 'GET':
                    $cash = new Cashs();

					$array['status'] = 'COMPLETED';
					$array['data'] = $cash->getCashMovementSinc($id);

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
    }

    public function get_cashs($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			switch($method) {
                case 'GET':
                    $cash = new Cashs();

					$array['status'] = 'COMPLETED';
					$array['data'] = $cash->getCashsInfo($id);

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
    }

    public function get_cashsByIdPark($id_park) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			switch($method) {
                case 'GET':
                    $cash = new Cashs();

					$array['status'] = 'COMPLETED';
					$array['data'] = $cash->getAllCashsByIdPark($id_park);

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
    }

    public function get_AllCashsMovementType() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			switch($method) {
                case 'GET':
                    $cash = new Cashs();

					$array['status'] = 'COMPLETED';
					$array['data'] = $cash->getAllCashTypeMovement();

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
    }
}