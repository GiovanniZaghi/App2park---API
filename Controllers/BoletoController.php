<?php
namespace Controllers;

use \Core\Controller;
use \Models\Form;
use Guzzle\Http\Client;
use \Models\Email;
use \Models\Parks;

class BoletoController extends Controller {

    public function index() {}

    public function new_boleto() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();

        $hoje = date('Y-m-d');
        $valor = $data['valor'];
        $vencimento = $data['vencimento'];

        $data = json_encode(array(
            "pagador" => array(
                "cnpjCpf" => $data['doc'],
                "nome" => $data['name'],
                "email" => $data['email'],
                "telefone" => $data['cell'],
                "cep" => $data['postal_code'],
                "numero" => $data['number'],
                "complemento" => $data['complement'],
                "bairro" => $data['neighborhood'],
                "cidade" => $data['city'],
                "uf" => $data['state'],
                "endereco" => $data['street'],
                "ddd" => $data['ddd'],
                "tipoPessoa" => $data['type']
            ),
            "dataEmissao" => $hoje,
            "seuNumero" => "1234567810",
            "dataLimite" => "SESSENTA",
            "dataVencimento" => $data['vencimento'],
            "mensagem" => array(
                "linha1" => "Mensalidade App2Park"
            ),
            "desconto1" => array(
                "codigoDesconto" => "NAOTEMDESCONTO",
                "taxa" => 0,
                "valor" => 0,
                "data" => "" 
            ),
            "desconto2" => array(
                "codigoDesconto" => "NAOTEMDESCONTO",
                "taxa" => 0,
                "valor" => 0,
                "data" => ""
            ),
            "desconto3" => array(
                "codigoDesconto" => "NAOTEMDESCONTO",
                "taxa" => 0,
                "valor" => 0,
                "data" => ""
            ),
            "valorNominal" => $data['valor'],
            "valorAbatimento" => 0,
            "multa" => array(
                "codigoMulta" => "NAOTEMMULTA",
                "valor" => 0,
                "taxa" => 0
            ),
            "mora" => array(
                "codigoMora" => "ISENTO",
                "valor" => 0,
                "taxa" => 0
            ),
            "cnpjCPFBeneficiario" => "64656465000188",
            "numDiasAgenda" => "SESSENTA"
        ));

        
        if($method == 'POST') {

            $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://apis.bancointer.com.br:8443/openbanking/v1/certificado/boletos",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSLCERT =>  "certificado.pem",
                CURLOPT_SSLKEY => "Boleto_2020-09-18_b.key",
                CURLOPT_KEYPASSWD => "Fone(11)99485-5686",
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    "accept: application/json",
                    "content-type: application/json",
                    "x-inter-conta-corrente: 14158680"
                ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);

                $decode = json_decode($response);

                $dt = array(
                    "seuNumero" => $decode->seuNumero,
                    "nossoNumero" => $decode->nossoNumero,
                    "codigoBarras" => $decode->codigoBarras,
                    "linhaDigitavel" => $decode->linhaDigitavel,
                    "criacao" => $hoje,
                    "valor" => $valor,
                    "vencimento" => $vencimento
                );

            $array['status'] = 'COMPLETED';
            $array['data'] = $dt;
        } else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
        }
		$this->returnJson($array);
    }

    public function send_boletoMail() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
        $mail = new Email();
        $parks = new Parks();
        $cart = array();

        if($method == 'POST') {
            if(!empty($data['id_park']) && !empty($data['name']) && !empty($data['type']) && !empty($data['inter_number']) && !empty($data['bank_slip_number']) && !empty($data['bank_slip_value']) && !empty($data['email'])) {

                $type = $data['type'];

                $p = $parks->getInfo($data['id_park']);

                $subs = $p['subscription'];

                if($type == '1'){
                    $subscription = date('Y-m-d', strtotime('+1 month', strtotime($subs)));
                }else{
                    $subscription = date('Y-m-d', strtotime('+12 month', strtotime($subs)));
                }
                
                $desc = "<div style='background-color: #29CAA8; padding:55px; color:#000000;'><p style='color:#000000; padding:20px;'>
                    <div style='background-color: #ffffff; padding:30px; border-radius: 20px;min-width: 350px;'>
                    <img width='150' src='https://www.app2park.com.br/assets/img/logo-app2park-footer.png' align='center'>
                    <br>
                    <p style='font-size:18px; padding:10px; color:#000000;'><b>Olá !".$data['name'].",</b> <br>
                <p style='font-size:18px; padding:10px; color:#000000;'>Segue o boleto para: </p><br>
                <p style='font-size:18px; padding:10px; color:#000000;'><b>Estacionamento:</b> <br>
                ".$p['name_park'].'<br>
                '.$p['business_name']."</p>
                <p style='font-size:18px; padding:10px; color:#000000;'>Doc: ".$p['doc'].'<br>
                '.$p['street'].', '.$p['number'].'<br>
                '.$p['city'].' '.$p['state']."</p>
                <p style='font-size:18px; padding:10px; color:#000000;'>CEP: ".$p['postal_code']."</p><br>
                <p style='font-size:18px; padding:10px; color:#000000;'>Período: <br>
                ".$subs.' a '.$subscription."</p><br>
                <p style='font-size:18px; padding:10px; color:#000000;'><b>Boleto:</b> <br>
                Link do Boleto: https://www.app2park.com.br/boleto.php?id=".$data['inter_number']."</p>
                <p style='font-size:18px; padding:10px; color:#000000;'>Linha Digitável: ".$data['bank_slip_number']."</p>
                <p style='font-size:18px; padding:10px; color:#000000;'><b>Valor:</b> ".$data['bank_slip_value'].'</p></div></div>
                ';

                $mail->sendMailDesc('Boleto Mensalidade App2Park', $data['email'], $desc);


                $array['status'] = 'COMPLETED';
				

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
    
    
    public function getbase64_boleto() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
        $mail = new Email();
        $parks = new Parks();
        $cart = array();

        if($method == 'POST') {

            $url = "https://apis.bancointer.com.br:8443/openbanking/v1/certificado/boletos/".$data['id']."/pdf";
    
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSLCERT =>  "certificado.pem",
                CURLOPT_SSLKEY => "Boleto_2020-09-18_b.key",
                CURLOPT_KEYPASSWD => "Fone(11)99485-5686",
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                  "content-type: application/base64",
                  "x-inter-conta-corrente: 14158680"
                ),
              ));
              
              $response = curl_exec($curl);

            $response = curl_exec($curl);

            curl_close($curl);

        $array['status'] = 'COMPLETED';
        $array['data'] = $response;
				
        } else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
        }

		$this->returnJson($array);
    }
    
    public function getboleto_bydate() {
		$array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
     
        $hoje = date("Y-m-d"); 

        $novaData = date('Y-m-d', strtotime('-5 days', strtotime($hoje)));
        
        if($method == 'POST') {

            $url = "https://apis.bancointer.com.br:8443/openbanking/v1/certificado/boletos?filtrarPor=TODOS&dataInicial=".$novaData."&dataFinal=".$hoje;
 
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSLCERT =>  "certificado.pem",
                CURLOPT_SSLKEY => "Boleto_2020-09-18_b.key",
                CURLOPT_KEYPASSWD => "Fone(11)99485-5686",
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                  "content-type: application/base64",
                  "x-inter-conta-corrente: 14158680"
                ),
              ));
              
              $response = curl_exec($curl);


             curl_close($curl);

             $decode = json_decode($response);

             $array['status'] = 'COMPLETED';
             $array['data'] = $decode->content;
				
        } else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
        }

		$this->returnJson($array);
    }
}