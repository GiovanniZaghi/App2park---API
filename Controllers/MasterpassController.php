<?php
namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Masterpass;

class MasterpassController extends Controller {

    public function index() {}
    

    public function new_masterpass() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();

		if($method == 'POST') {
                $master = new Masterpass();
                
                $value = rand(100000,300000);
                //var_dump($value);

                $hoje = date("Ymd"); 

                //var_dump($hoje);

                $pass = $value.$hoje.'nov@123';

                //var_dump($pass);
							
                $id_masterpass = $master->createMasterPass($pass);
                
                sleep(300);

                $master->deleteMasterPass($id_masterpass);

				$array['status'] = 'COMPLETED';
		} else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
		}
		$this->returnJson($array);
    }
}