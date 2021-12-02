<?php
namespace Controllers;

use \Core\Controller;
use \Models\Notafiscal;
use \Models\Tickets;
use \Models\Parks;
use \Models\Cart;
use \Models\Email;
use \Models\Vehicles;

class NotafiscalController extends Controller {

    public function index() {}

    public function new_Nota_Fiscal() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
        
        if($method == 'POST') {
				$nf = new Notafiscal();
				$ticket = new Tickets();
				$parks = new Parks();
				$cart = new Cart();
				$mail = new Email();
				$vehicle = new Vehicles();

				$tickets = $ticket->findTicketWithCupomAndId($data['id_ticket'], $data['id_cupom']);

				//var_dump($tickets);

				//var_dump($tickets['id_vehicle']);

				$vehicles = $vehicle->getInfoID($tickets['id_vehicle']);

				//var_dump($vehicles);

				if($tickets != null){

				$ListUsers = $parks->getusersParkUsersRoleAdminByIdPark($tickets['id_park']);
		
				$value = $cart->findvaluebyticket($data['id_ticket']);

				$park = $parks->getInfo($tickets['id_park']);

				if($value == null){

					$value = 'Aguardando pagamento.';
				} else {

					$value = $value['value'];
				}

				foreach($ListUsers as $user){

					//var_dump($data);

					if($data['cpf'] != ''){
						$desc = "<div style='background-color: #29CAA8; padding:55px; color:#000000;'><p style='color:#000000; padding:20px;'>
					<div style='background-color: #ffffff; padding:30px; border-radius: 20px;'>
					<img width='150'  src='https://www.app2park.com.br/assets/img/logo-app2park-footer.png' align='center'>
					<br>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Olá ".$user['first_name']." ! </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>O cliente abaixo solicitou envio de NF. </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Nome: ".$data['nome']." </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>CPF: ".$data['cpf']." </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Telefone: ".$data['telefone']." </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>E-mail: ".$data['email']." </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Endereço: ".$data['endereco'].', '.$data['numero'].' 
						'.$data['bairro'].' 
						'.$data['municipio'].'-'.$data['uf'].' 
						'.$data['cep']."</p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Valor da Nota: ".$value."</p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Veículo: </p>
						Tipo: ".$vehicles['type']." <br>
						Marca: ".$vehicles['maker']."<br>
						Modelo: ".$vehicles['model']."<br>
						Cor : ".$vehicles['color']." <br>
						Placa: ".$vehicles['plate']."<br>
						Ano : ".$vehicles['year']."<br>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Estacionamento: ".$park['name_park'].'</p>
						'.$park['street'].', '.$park['number'].'
						'.$park['neighborhood'].'
						'.$park['city'].'-'.$park['state'].'<br>
						'.$park['postal_code'].'<br>
						'.$park['doc'].'<br>
						'.$park['cell'].'</div></div>
						';
					}else{
						$desc = "<div style='background-color: #29CAA8; padding:55px; color:#000000;'><p style='color:#000000; padding:20px;'>
					<div style='background-color: #ffffff; padding:30px; border-radius: 20px;'>
					<img width='150'  src='https://www.app2park.com.br/assets/img/logo-app2park-footer.png' align='center'>
					<br>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Olá ".$user['first_name']." ! </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>O cliente abaixo solicitou envio de NF. <br>
						Razão Social: ".$data['razao_social']." </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>CNPJ: ".$data['cnpj']." </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Inscrição Municiapl: ".$data['inscricao_municipal']." </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Telefone: ".$data['telefone']." </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>E-mail: ".$data['email']." </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Endereço: ".$data['endereco'].', '.$data['numero'].' 
						'.$data['bairro'].' 
						'.$data['municipio'].'-'.$data['uf'].' 
						'.$data['cep']."</p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Valor da Nota: ".$value."</p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Veículo: </p>
						Tipo: ".$vehicles['type']." <br>
						Marca: ".$vehicles['maker']."<br>
						Modelo: ".$vehicles['model']."<br>
						Cor : ".$vehicles['color']." <br>
						Placa: ".$vehicles['plate']."<br>
						Ano : ".$vehicles['year']."<br>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Estacionamento: ".$park['name_park'].'</p>
						'.$park['street'].', '.$park['number'].'
						'.$park['neighborhood'].'
						'.$park['city'].'-'.$park['state'].'<br>
						'.$park['postal_code'].'<br>
						'.$park['doc'].'<br>
						'.$park['cell'].'</div></div>
						';
					}

					//var_dump($desc);

					$mail->sendMailDesc('App2Park - NF solicitada por cliente - Ticket: '.$data['id_ticket'], $user['email'], $desc);
    
					sleep(5);
				}

				if($data['cpf'] != ''){
				$desc = "<div style='background-color: #29CAA8; padding:55px; color:#000000;'><p style='color:#000000; padding:20px;'>
					<div style='background-color: #ffffff; padding:30px; border-radius: 20px;'>
					<img width='150'  src='https://www.app2park.com.br/assets/img/logo-app2park-footer.png' align='center'>
					<br>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Olá ".$data['nome']." ! </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Sua solicitação de Nota Fiscal foi enviada com sucesso! <br> Por favor, aguarde o retorno por este e-mail. </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Nome: ".$data['nome']." </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>CPF: ".$data['cpf']." </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Telefone: ".$data['telefone']." </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>E-mail: ".$data['email']." </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Endereço: ".$data['endereco'].', '.$data['numero'].' 
						'.$data['bairro'].' 
						'.$data['municipio'].'-'.$data['uf'].' 
						'.$data['cep']."</p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Valor da Nota: ".$value."</p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Estacionamento: ".$park['name_park'].'</p>
						'.$park['street'].', '.$park['number'].'
						'.$park['neighborhood'].'
						'.$park['city'].'-'.$park['state'].'<br>
						'.$park['postal_code'].'<br>
						'.$park['doc'].'<br>
						'.$park['cell'].'</div></div>
						';
				}else{
				$desc = "<div style='background-color: #29CAA8; padding:55px; color:#000000;'><p style='color:#000000; padding:20px;'>
					<div style='background-color: #ffffff; padding:30px; border-radius: 20px;'>
					<img width='150'  src='https://www.app2park.com.br/assets/img/logo-app2park-footer.png' align='center'>
					<br>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Olá ".$data['razao_social']." ! </p>
					<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Sua solicitação de Nota Fiscal foi enviada com sucesso! <br> Por favor, aguarde o retorno por este e-mail. </p>
						Razão Social: ".$data['razao_social']." </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>CNPJ: ".$data['cnpj']." </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Inscrição Municiapl: ".$data['inscricao_municipal']." </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Telefone: ".$data['telefone']." </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>E-mail: ".$data['email']." </p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Endereço: ".$data['endereco'].', '.$data['numero'].' 
						'.$data['bairro'].' 
						'.$data['municipio'].'-'.$data['uf'].' 
						'.$data['cep']."</p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Valor da Nota: ".$value."</p>
						<p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'>Estacionamento: ".$park['name_park'].'</p>
						'.$park['street'].', '.$park['number'].'
						'.$park['neighborhood'].'
						'.$park['city'].'-'.$park['state'].'<br>
						'.$park['postal_code'].'<br>
						'.$park['doc'].'<br>
						'.$park['cell'].'</div></div>
						';
				}

				//var_dump($desc);

				$mail->sendMailDesc('App2Park - NF solicitada - Ticket: '.$data['id_ticket'], $data['email'], $desc);


				$id_nf = $nf->createNotaFiscal($data['cpf'],$data['cnpj'],$data['nome'],$data['razao_social'],$data['inscricao_municipal'],$data['telefone'],$data['email'],$data['cep'],$data['endereco'],$data['numero'],$data['complemento'],$data['bairro'],$data['municipio'],$data['uf']);
					
				$array['status'] = 'COMPLETED';
				$array['data'] = $nf->findNotaFiscal($id_nf);
			}else{
				$array['status'] = 'ERROR';
				$array['message'] = 'Não existe nota fiscal para esse ticket';
			}

        } else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
        }
		$this->returnJson($array);
    }
    
    public function new_Nota_Fiscal_Log() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
        
        if($method == 'POST') {
				$nf = new Notafiscal();
				            
				$id_nf_log = $nf->createNotaFiscalLog($data['id_ticket'],$data['id_park'],$data['id_nota_fiscal'],$data['status']);
					
				$array['status'] = 'COMPLETED';
				$array['data'] = $nf->findNotaFiscalLog($id_nf_log);
        } else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
        }
		$this->returnJson($array);
	}

	public function get_Nota_Fiscal_CPF($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();
			switch($method) {
                case 'GET':
					$nf = new Notafiscal();

					$array['status'] = 'COMPLETED';
					$array['data'] = $nf->findNotaFiscalByCPF($id);

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
	}
	
	public function get_Nota_Fiscal_CNPJ($id) {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
		$data = $this->getRequestData();
			switch($method) {
                case 'GET':
					$nf = new Notafiscal();

					$array['status'] = 'COMPLETED';
					$array['data'] = $nf->findNotaFiscalByCNPJ($id);

					break;
				default:
					$array['status'] = 'ERROR';
					$array['message'] = 'Método '.$method.' não disponível';
					break;
			}
		$this->returnJson($array);
    }
}