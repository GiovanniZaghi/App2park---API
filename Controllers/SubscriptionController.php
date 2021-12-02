<?php
namespace Controllers;

use \Core\Controller;
use \Models\Subscription;

class SubscriptionController extends Controller {

    public function index() {}

    public function new_subscription() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
        
        if($method == 'POST') {
				$subscription = new Subscription();
				            
                $id_subscription = $subscription->createSubscription($data['id_user'], $data['subscription_price'], $data['id_period'], $data['id_send'], $data['doc'], $data['name'], $data['email'], $data['postal_code'], $data['street'], $data['number'], $data['complement'], $data['neighborhood'], $data['city'], $data['state'], $data['ddd'], $data['cell'], $data['type']);
					
				$array['status'] = 'COMPLETED';
				$array['data'] = $subscription->findSubscription($id_subscription);
        } else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
        }
		$this->returnJson($array);
    }
    
    public function update_subscription($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();
        $subscription = new Subscription();

			switch($method) {
				case 'POST':
					$ok = $subscription->editSubscription($id, $data);

					if($ok === true){
						$array['status'] = 'COMPLETED';
						$array['data'] = $subscription->findSubscription($id);
						$array['message'] = 'Subscription Alterado Com Sucesso!';
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

    public function new_subscriptionItem() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
        
        if($method == 'POST') {
				$subscription = new Subscription();
				            
                $id_subscription_item = $subscription->createSubscriptionItem($data['id_subscription'], $data['id_park']);
					
				$array['status'] = 'COMPLETED';
				$array['data'] = $subscription->findSubscriptionItem($id_subscription_item);
        } else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
        }
		$this->returnJson($array);
    }


    public function update_subscriptionItem($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();
        $subscription = new Subscription();

			switch($method) {
				case 'POST':
					$ok = $subscription->editSubscriptionItem($id, $data);

					if($ok === true){
						$array['status'] = 'COMPLETED';
						$array['data'] = $subscription->findSubscriptionItem($id);
						$array['message'] = 'Subscription Item Alterado Com Sucesso!';
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
}