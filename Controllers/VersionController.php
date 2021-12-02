<?php
namespace Controllers;

use \Core\Controller;
use \Models\Version;

class VersionController extends Controller {

    public function index() {}

    public function get_Version() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			switch($method) {
                case 'GET':
                    $version = new Version();

					$array['status'] = 'COMPLETED';
					$array['data'] = $version->getVersion();

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
    }
}