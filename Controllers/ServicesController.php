<?php
namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Services;

class ServicesController extends Controller {

    public function index() {}
    
    public function get_Services() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			switch($method) {
                case 'GET':
                    $service = new Services();

					$array['status'] = 'COMPLETED';
					$array['data'] = $service->getServices();

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
	}
	
	public function sinc_parkServiceAdditional($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();


			switch($method) {
                case 'GET':
                    $service = new Services();

					$array['status'] = 'COMPLETED';
					$array['data'] = $service->sincParkServiceAdditional($id);

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
    }
}