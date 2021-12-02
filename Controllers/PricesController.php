<?php
namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Prices;

class PricesController extends Controller {

    public function index() {}
    
    public function new_PriceDetached() {
        $array = array('status'=>'', 'message'=>'');
        
		$method = $this->getMethod();
        $data = $this->getRequestData();

        if($method == 'POST') {

            $price = new Prices();
                    
            $id_price_detached = $price->createPriceDetached($data['id_price_detached_app'],$data['id_park'],$data['name'],
            $data['daily_start'], $data['id_vehicle_type'], $data['id_status'],  $data['cash'], $data['sort_order'], $data['data_sinc']);

            $array['status'] = 'COMPLETED';
            $array['data'] = $price->getPriceDetachedById($id_price_detached);
        } else {
            $array['status'] = 'ERROR';
            $array['message'] = 'Método de requisição incompatível';
        }
        
		$this->returnJson($array);
    }

    public function update_priceDetached($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();
        $price = new Prices();

			switch($method) {
				case 'POST':
					$ok = $price->editPriceDetached($id, $data);

					if($ok === true){
						$array['status'] = 'COMPLETED';
						$array['data'] = $price->getPriceDetachedById($id);
						$array['message'] = 'Price Detached Alterado Com Sucesso!';
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

    public function get_PriceDetached($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			switch($method) {
                case 'GET':
                    $price = new Prices();

					$array['status'] = 'COMPLETED';
					$array['data'] = $price->getPriceDetached($id);

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
    }

    public function new_PriceDetachedItem() {
        $array = array('status'=>'', 'message'=>'');
        
		$method = $this->getMethod();
        $data = $this->getRequestData();

        if($method == 'POST') {
                $price = new Prices();
                    
                $id_price_detached_item = $price->createPriceDetachedItem($data['id_price_detached_item_app'],$data['id_price_detached'],$data['id_price_detached_item_base'],
                $data['price'], $data['tolerance']);

                $array['status'] = 'COMPLETED';
                $array['data'] = $price->getPriceDetachedItemById($id_price_detached_item);
        } else {
            $array['status'] = 'ERROR';
            $array['message'] = 'Método de requisição incompatível';
        }
        
		$this->returnJson($array);
    }

    public function update_priceDetachedItem($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();
        $price = new Prices();

			switch($method) {
				case 'POST':
					$ok = $price->editPriceDetachedItem($id, $data);

					if($ok === true){
						$array['status'] = 'COMPLETED';
						$array['data'] = $price->getPriceDetachedItemById($id);
						$array['message'] = 'Price Detached Item Alterado Com Sucesso!';
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
    
    public function del_PriceDetachedItem() {
        $array = array('status'=>'', 'message'=>'');
        
		$method = $this->getMethod();
        $data = $this->getRequestData();

        if($method == 'POST') {
                $price = new Prices();
                    
                $price->deletePriceDetachedItem($data['id']);

                $array['status'] = 'COMPLETED';
                $array['message'] = 'Price Detached Item Deletado Com sucesso';
        } else {
            $array['status'] = 'ERROR';
            $array['message'] = 'Método de requisição incompatível';
        }
        
		$this->returnJson($array);
    }

    public function get_PriceDetachedItem($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			switch($method) {
                case 'GET':
                    $price = new Prices();

					$array['status'] = 'COMPLETED';
					$array['data'] = $price->getPriceDetachedItem($id);

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
	}
	
	public function sinc_priceDetached($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();
        $price = new Prices();

			switch($method) {
				case 'POST':
					$a = $price->getPriceDetachedByIdSinc($id);
					$dataServidor = $a['data_sinc'];
					$dataMobile = $data['data_sinc'];

					if(strtotime($dataMobile) > strtotime($dataServidor)){
						//Atualizar
						$array['status'] = 'COMPLETED';
						$array['mode'] = '1';
						$price->editPriceDetached($id, $data);
						$array['data'] = $price->getPriceDetachedItem($id);
					}else if(strtotime($dataMobile) == strtotime($dataServidor)){
						//Fazer nada
						$array['status'] = 'COMPLETED';
						$array['mode'] = '2';
					}else if(strtotime($dataMobile) < strtotime($dataServidor)){
						//Baixar Informações		
						$array['status'] = 'COMPLETED';
						$array['mode'] = '3';
						$array['data'] = $price->getPriceDetachedById($id);
					}else{
						$array['status'] = 'COMPLETED';
						$array['mode'] = '2';
					}
				break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}

		$this->returnJson($array);
	}

	public function sincGetPriceDetachedItem($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			switch($method) {
                case 'GET':
                    $price = new Prices();

					$array['status'] = 'COMPLETED';
					$array['data'] = $price->getPriceDetachedItem($id);

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
	}

    public function getallpricesitembase() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();

			switch($method) {
                case 'GET':
                    $price = new Prices();

					$array['status'] = 'COMPLETED';
					$array['data'] = $price->getPriceDetachedItemBase();

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
	}
}