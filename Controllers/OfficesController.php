<?php
namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Offices;

class OfficesController extends Controller {

    public function index() {}
    
    public function get_Offices() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			switch($method) {
                case 'GET':
                    $office = new Offices();

					$array['status'] = 'COMPLETED';
					$array['data'] = $office->getOfficesInfo();

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
    }
}