<?php
namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Log;

class LogController extends Controller {

    public function index() {}
    

    public function new_log() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();

		if($method == 'POST') {
                $log = new Log();
                
                $log->createLog($data['id_user'], $data['id_park'], $data['error'], $data['version'], $data['created'], $data['screen_error'], $data['platform']);

				$array['status'] = 'COMPLETED';
		} else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
		}
		$this->returnJson($array);
    }
}