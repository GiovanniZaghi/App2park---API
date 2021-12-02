<?php
namespace Controllers;

use \Core\Controller;
use \Models\Form;

class FormController extends Controller {

    public function index() {}

    public function new_form() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
        
        if($method == 'POST') {
				$form = new Form();
				            
				$id_form = $form->createForm($data['nome'],$data['email'],$data['telefone'],$data['cidade'],$data['uf'],$data['mensagem']);
					
				$array['status'] = 'COMPLETED';
				$array['data'] = $form->findForm($id_form);
        } else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
        }
		$this->returnJson($array);
	}
}