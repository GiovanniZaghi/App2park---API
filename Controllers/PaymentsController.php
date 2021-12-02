<?php
namespace Controllers;

use \Core\Controller;
use \Models\Parks;
use \Models\Users;
use \Models\Payments;

class PaymentsController extends Controller {

    public function index() {}
    
    public function get_PaymentsTypePark($id_park) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

		$users = new Users();

			switch($method) {
                case 'GET':
                    $pay = new Payments();

					$array['status'] = 'COMPLETED';
					$array['data'] = $pay->seachAllPaymentPark($id_park);

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
    }

    public function get_AllPaymentsMethod() {
        $array = array('status'=>'', 'message'=>'');
		$method = $this->getMethod();
        $data = $this->getRequestData();
        $payments = new Payments();

			switch($method) {
                case 'GET':
                    $array['status'] = 'COMPLETED';
                    $array['data'] = $payments->seachAllPayments();

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
    }

    public function get_PaymentMethodParkInnerJoinPaymentMethod($id_park) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

		$users = new Users();

			switch($method) {
                case 'GET':
                    $pay = new Payments();

					$array['status'] = 'COMPLETED';
					$array['data'] = $pay->seachPaymentsParkInnerJoinByPaymentsParkIdPark($id_park);

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
    }
	
	public function update_payment_method_park($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();
		$users = new Users();
		$pay = new Payments();

			switch($method) {
				case 'POST':
					$ok = $pay->editpaymentmethodpark($id, $data);

					if($ok === true){
						$array['status'] = 'COMPLETED';
						$array['data'] = $pay->findpaymentmethodparkbyid($id);
						$array['message'] = 'Payment Method Park Alterado Com Sucesso!';
					}else{
						$array['status'] = 'ERROR';
						$array['message'] = $ok;
					}
				break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}

		$this->returnJson($array);
	}

	public function sinc_paymentsMethodPark($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

		$users = new Users();

			switch($method) {
                case 'GET':
					$pay = new Payments();

					$array['status'] = 'COMPLETED';
					$array['data'] = $pay->sincpaymentmethodparkbyidpark($id);

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
    }
}