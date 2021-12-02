<?php
namespace Controllers;

use \Core\Controller;
use \Models\Notafiscalassinatura;

class NotafiscalassinaturaController extends Controller {

    public function index() {}

    public function new_Nota_Fiscal_Assinatura() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
        
        if($method == 'POST') {
				$nf = new Notafiscalassinatura();
				            
				$id_nf = $nf->createNotaFiscalAssinatura($data['id_user'],$data['cpf'],$data['cnpj'],$data['nome'],$data['razao_social'],$data['inscricao_municipal'],$data['telefone'],$data['email'],$data['cep'],$data['endereco'],$data['numero'],$data['complemento'],$data['bairro'],$data['municipio'],$data['uf']);
					
				$array['status'] = 'COMPLETED';
				$array['data'] = $nf->findNotaFiscalAssinatura($id_nf);
        } else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
        }
		$this->returnJson($array);
    }

}