<?php
namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Agreements;

class AgreementsController extends Controller {

    public function index() {}

    public function new_Agreement() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();

		if($method == 'POST') {
				$agreement = new Agreements();
							
				$id_agreement = $agreement->createAgreement(
                $data['id_agreement_app'],$data['id_park'],$data['id_user'],$data['agreement_type'],
                $data['date_time'], $data['agreement_begin'], $data['agreement_end'], $data['accountable_name'], $data['accountable_doc'], $data['accountable_cell'],
                $data['accountable_email'], $data['send_nf'], $data['doc_nf'], $data['company_name'], $data['company_doc'], $data['company_cell'], $data['company_email'],
                $data['bank_slip_send'], $data['payment_day'], $data['mon'], $data['tue'], $data['wed'], $data['thur'], $data['fri'], $data['sat'], $data['sun'], $data['time_on'], $data['time_off'], $data['id_price_detached'],
                $data['parking_spaces'], $data['price'], $data['plates'], $data['comment'], $data['status_payment'], $data['until_payment']
                );

				$array['status'] = 'COMPLETED';
				$array['data'] = $agreement->findAgreementById($id_agreement);
		} else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
		}
		$this->returnJson($array);
    }

    public function get_AgreementById($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $agreement = new Agreements();

			switch($method) {
				case 'GET':
					$array['status'] = 'COMPLETED';
					$array['data'] = $agreement->findAgreementById($id);
					break;
				case 'PUT':
					break;
				case 'DELETE':
					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}

		$this->returnJson($array);
	}

	public function update_agreement($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();
		$users = new Users();
        $agreement = new Agreements();

			switch($method) {
				case 'POST':
					$ok = $agreement->editAgreements($id, $data);

					if($ok === true){
						$array['status'] = 'COMPLETED';
						$array['data'] = $agreement->findAgreementById($id);
						$array['message'] = 'Agreements Alterado Com Sucesso!';
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

	public function sinc_AgreementByIdUser($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

        $agreement = new Agreements();

			switch($method) {
				case 'GET':
					$array['status'] = 'COMPLETED';
					$array['data'] = $agreement->sincFindAgreementsInParks($id);
					break;
				case 'PUT':
					break;
				case 'DELETE':
					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}

		$this->returnJson($array);
	}
}