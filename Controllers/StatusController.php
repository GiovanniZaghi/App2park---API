<?php
namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Status;

class StatusController extends Controller {

    public function index() {}
    
    public function get_Status() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			switch($method) {
                case 'GET':
                    $status = new Status();

					$array['status'] = 'COMPLETED';
					$array['data'] = $status->getStatusInfo();

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
    }
}