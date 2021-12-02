<?php
namespace Controllers;

use \Core\Controller;
use \Models\Receipt;

class ReceiptController extends Controller {

    public function index() {}
    

    public function new_receipt() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
		$receipt = new Receipt();

        if($method == 'POST') {
            if(!empty($data['id_ticket']) && !empty($data['res'])) {
        

                $id_receipt = $receipt->createReceipt($data['id_ticket'],$data['res']);

                $array['status'] = 'COMPLETED';
			    $array['data'] = $receipt->findReceipt($id_receipt);				   
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
    
    public function get_receipt($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			switch($method) {
                case 'GET':
                    $receipt = new Receipt();

					$array['status'] = 'COMPLETED';
					$array['data'] = $receipt->findReceiptByTicket($id);

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
	}
}