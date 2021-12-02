<?php
namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Objects;

class ObjectsController extends Controller {

    public function index() {}
    
    public function get_Objects() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			switch($method) {
                case 'GET':
                    $object = new Objects();

					$array['status'] = 'COMPLETED';
					$array['data'] = $object->getAllObjects();

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
    }
}