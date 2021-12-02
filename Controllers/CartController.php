<?php
namespace Controllers;

use \Core\Controller;
use \Models\Cart;

class CartController extends Controller {

    public function index() {}

    public function new_cart() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
        
        if($method == 'POST') {
				$cart = new Cart();
				            
                $id_cart = $cart->createCart($data['id_nota_fiscal_assinatura'],$data['inter_number'], $data['bank_slip_number'], $data['bank_slip_value'], $data['bank_slip_issue'], $data['bank_slip_due'], $data['status']);
					
				$array['status'] = 'COMPLETED';
				$array['data'] = $cart->findCart($id_cart);
        } else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
        }
		$this->returnJson($array);
    }
    
    public function update_cart($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();
        $cart = new Cart();

			switch($method) {
				case 'POST':
					$ok = $cart->editCart($id, $data);

					if($ok === true){
						$array['status'] = 'COMPLETED';
						$array['data'] = $cart->findCart($id);
						$array['message'] = 'Cart Alterado Com Sucesso!';
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

    public function new_cartItem() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
        
        if($method == 'POST') {
                $cart = new Cart();
				            
                $id_cart_item = $cart->createCartItem($data['id_cart'], $data['id_park'], $data['id_period'], $data['value']);
					
				$array['status'] = 'COMPLETED';
				$array['data'] = $cart->findCartItem($id_cart_item);
        } else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
        }
		$this->returnJson($array);
    }


    public function update_cartItem($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();
        $cart = new Cart();

			switch($method) {
				case 'POST':
					$ok = $cart->editCartItem($id, $data);

					if($ok === true){
						$array['status'] = 'COMPLETED';
						$array['data'] = $cart->findCartItem($id);
						$array['message'] = 'Cart Item Alterado Com Sucesso!';
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