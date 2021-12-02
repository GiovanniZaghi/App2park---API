<?php
namespace Controllers;

use \Core\Controller;
use \Models\Form;
use Guzzle\Http\Client;
use \Models\Email;
use \Models\Parks;
use \Models\Subscription;
use \Models\Cart;
use \Models\Puser;

class CronController extends Controller {

    public function index() {}

    public function atualizar_pag(){
        $array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
        $parks = new Parks();
        $subs = new Subscription();
        $cart = new Cart();
        $mail = new Email();
        $puser = new Puser();
     
        $hoje = date("Y-m-d"); 

        $hojes = date('Y-m-d', strtotime('+1 month', strtotime($hoje)));

        $novaData = date('Y-m-d', strtotime('-1 month', strtotime($hoje)));

        //var_dump($hoje);

        //var_dump($novaData);
        
        if($method == 'POST') {

            $url = "https://apis.bancointer.com.br:8443/openbanking/v1/certificado/boletos?filtrarPor=PAGOS&dataInicial=".$novaData."&dataFinal=".$hojes;
 
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

              $listInter = $decode->content;

              //var_dump($listInter);

              foreach($listInter as $liIn){

                //var_dump($liIn);

                $listCartInPayments = $cart->findAllCartNoPayments();

                foreach($listCartInPayments as $cartp){
                   // var_dump($cartp);

                   $id_park = $cartp['id_park'];
                   $id_cart_pk = $cartp['id_cart_pk'];

                    if($cartp['inter_number'] == $liIn->nossoNumero){

                        if($liIn->situacao == 'PAGO'){

                           // var_dump($cartp);
                            //var_dump($liIn);
                            //var_dump('PAGO');

                            $date_new_s = implode("-",array_reverse(explode("/",$liIn->dataPagtoBaixa)));

                            //var_dump('AQUIIIIIIIIIIIIIII'.$date_new_s);

                            if($cartp['id_period'] == 1){

                               //var_dump('1 mes');
                                $ok = $cart->updateCartPaymentConfirm($id_cart_pk, $date_new_s, 1);

                                if($ok){

                                    $novaDataSubscription = date('Y-m-d', strtotime('+1 month', strtotime($cartp['subscription'])));

                                    $parks->updateSubscriptionPark($id_park, $novaDataSubscription);

                                }

                            }else{

                               // var_dump('1 ano');
                                $ok = $cart->updateCartPaymentConfirm($id_cart_pk, $date_new_s, 1);

                                if($ok){

                                    $novaDataSubscription = date('Y-m-d', strtotime('+1 year', strtotime($cartp['subscription'])));

                                    $parks->updateSubscriptionPark($id_park, $novaDataSubscription);

                                }

                            }
                            
                        }
                    }

                }
              }


             $array['status'] = 'COMPLETED';
             $array['data'] = 'CRON EXECUTADO COM SUCESSO!';
				
        } else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
        }

		$this->returnJson($array);
    }

    public function criarboleto_pag(){
        $array = array('status'=>'', 'message'=>'');

		$method = $this->getMethod();
        $data = $this->getRequestData();
        $parks = new Parks();
        $subs = new Subscription();
        $cart = new Cart();
        $mail = new Email();
        $puser = new Puser();

        $hoje = date("Y-m-d"); 

        $firstDate = date('Y-m-d', strtotime('+15 days', strtotime($hoje)));

        $lastDate = date('Y-m-d', strtotime('+16 days', strtotime($hoje)));


        if($method == 'POST') {

        $listParks = $parks->selectAllParksSignatureExpire($firstDate);


        if($listParks != null){
            foreach($listParks as $park){

                $a = $subs->selectParkExistSubscription($park['id']);

                if($a != null){

                    //Tem Subscription

                    $subcription = $subs->cronSubscriptionGet($a['id_subscription']);

                    //var_dump($subcription);

                    $verifyExistCart = $cart->findCartAndCartItemCron($hoje,$park['id']);
                    
                    if($verifyExistCart == null){
                    
                        if($subcription['id_period'] == '1'){
                            $newSubsIn = date('Y-m-d', strtotime('+1 month', strtotime($park['subscription'])));
                        }else{
                            $newSubsIn = date('Y-m-d', strtotime('+1 year', strtotime($park['subscription'])));
                        }

                        $venc = date('Y-m-d', strtotime('-10 days', strtotime($park['subscription'])));


                        $dats = json_encode(array(
                            "pagador" => array(
                                "cnpjCpf" => $subcription['doc'],
                                "nome" => $subcription['name'],
                                "email" => $subcription['email'],
                                "telefone" => $subcription['cell'],
                                "cep" => $subcription['postal_code'],
                                "numero" => $subcription['number'],
                                "complemento" => '',
                                "bairro" => $subcription['neighborhood'],
                                "cidade" => $subcription['city'],
                                "uf" => $subcription['state'],
                                "endereco" => $subcription['street'],
                                "ddd" => $subcription['ddd'],
                                "tipoPessoa" => $subcription['type']
                            ),
                            "dataEmissao" => $hoje,
                            "seuNumero" => "1234567810",
                            "dataLimite" => "SESSENTA",
                            "dataVencimento" => $venc,
                            "mensagem" => array(
                                "linha1" => "Mensalidade App2Park",
                                "linha1" => "Período: ".$park['subscription']." a ".$newSubsIn,
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
                            "valorNominal" => $subcription['subscription_price'],
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
                        CURLOPT_POSTFIELDS => $dats,
                        CURLOPT_HTTPHEADER => array(
                            "accept: application/json",
                            "content-type: application/json",
                            "x-inter-conta-corrente: 14158680"
                        ),
                        ));
        
                        $response = curl_exec($curl);
        
                        curl_close($curl);
        
                        $decode = json_decode($response);

                        $codigoBarras = $decode->linhaDigitavel;
                        $numeroInter = $decode->nossoNumero;
                        $preco = $subcription['subscription_price'];
                        $valo_format = number_format($preco,2,",",".");

                        $id_cart = $cart->createCart(1, $numeroInter, $codigoBarras, $preco, $hoje, $firstDate, 0);

        
                        $cart->createCartItem($id_cart, $park['id'], $subcription['id_period'], $subcription['subscription_price']);

                        //Determina até a inscrição E-mail

                        $vencimento = date("d/m/Y", strtotime($park['subscription']));

                        $newvencimento = date("d/m/Y", strtotime($newSubsIn));

                
                        $desc = "<div style='background-color: #29CAA8; padding:55px; color:#000000;'><p style='color:#000000; padding:20px;'>
                    <div style='background-color: #ffffff; padding:30px; border-radius: 20px;min-width: 350px;'>
                    <img width='150' class=''  src='https://www.app2park.com.br/assets/img/logo-app2park-footer.png' align='right'>
                    <br>
                    <p style='font-size:18px; padding:10px; color:#000000;'><b>Olá ".$subcription['name'].", </b></p>
                        <p style='font-size:18px; padding:10px; color:#000000;'>Gostaria de lembrá-lo(a) que a sua assinatura vence dia: ".$vencimento."</p>
                        <p style='font-size:18px; padding:10px; color:#000000;'>Estamos enviando o link para fazer o download do boleto ou, se preferir, abaixo também
                        está a linha digitável para copiar e colar: </p>  
                        <p style='font-size:18px; padding:10px; color:#000000;'><b>Boleto:</b><br>
                        Link do Boleto: https://www.app2park.com.br/boleto.php?id=".$numeroInter."<br>
                        Linha Digitável: ".$codigoBarras."<br>
                        <b>Valor:</b> ".$valo_format."</p>
                        <p style='font-size:18px; padding:10px; color:#000000;'>Caso você tenha interesse em uma Assinatura Anual, estamos oferecendo 10% de desconto <br>
                        Veja abaixo como fazer sua Assinatura Anual: </p>
                        <p style='font-size:18px; padding:10px; color:#000000;'><b>Android</b> - Acesse “Assinatura” no menu principal do App2Park.<br>
                        <b>iOS</b> - Por favor, entre em contato pelo WhatsAPP: 11 93316-5686</p>
                        <p style='font-size:18px; padding:10px; color:#000000;'><b>Estacionamento:</b> <br>
                        ".$park['name_park']."<br>
                        ".$park['business_name']."<br>
                        Doc: ".$park['doc']."<br>
                        ".$park['street'].", ".$park['number']."<br>
                        ".$park['city']." ".$park['state']."<br>
                        CEP: ".$park['postal_code']."<br>
                        <b>Período:</b> <br>
                        ".$vencimento." a ".$newvencimento."</p><br>
                        <p style='font-size:18px; padding:10px; color:#000000;'>Agradecemos por você utilizar o App2Park <br>
                        Equipe App2Park<br>
                        app2park.com.br<br>
                        11 93316-5686 (WhatsAPP)</p></div></div>
                        ";

                        $mail->sendMailDescCron('Boleto -'.$park['name_park'], $subcription['email'], $desc);
                        sleep(5);
                    }

                }else{
                    // Não tem Subscription - Mensagem para fazer assinatura. Enviar email para fazer uma assinatura.

                    $listParkSubs = $subs->cronSubscriptionNewByIdPark($park['id']);

                    //var_dump($listParkSubs);

                    if(strlen($listParkSubs['doc']) > 14) {
                        $type = 'JURIDICA';
                        $part1 = str_replace('.', '', $listParkSubs['doc']);
                        $par2 = str_replace('-', '', $part1);
                        $doc  = str_replace('/', '', $par2);
                        //var_dump($doc);

                    }else{
                        $type = 'FISICA';
                        $part1 = str_replace('.', '', $listParkSubs['doc']);
                        $doc = str_replace('-', '', $part1);

                        //var_dump($doc);
                    }

                    $p1 = explode("(", $listParkSubs['cell']);

                    $p2 = explode(')', $p1[1]);

                    $ps2 = str_replace('-', '', $p2[1]);

                    $cepsplode = explode("-", $listParkSubs['postal_code']);

                    $newcep = $cepsplode[0].$cepsplode[1];

                    //var_dump($newcep);

                    //var_dump($p2);

                    $venc = date('Y-m-d', strtotime('-10 days', strtotime($listParkSubs['subscription'])));
                    
                    $newvenc = date('Y-m-d', strtotime('+1 month', strtotime($listParkSubs['subscription'])));

                    //var_dump($newvenc);

                    $dats = json_encode(array(
                        "pagador" => array(
                            "cnpjCpf" => $doc,
                            "nome" => $listParkSubs['name_park'],
                            "email" => $listParkSubs['email'],
                            "telefone" => $ps2,
                            "cep" => $newcep,
                            "numero" => $listParkSubs['number'],
                            "complemento" => '',
                            "bairro" => $listParkSubs['neighborhood'],
                            "cidade" => $listParkSubs['city'],
                            "uf" => $listParkSubs['state'],
                            "endereco" => $listParkSubs['street'],
                            "ddd" => $p2[0],
                            "tipoPessoa" => $type
                        ),
                        "dataEmissao" => $hoje,
                        "seuNumero" => "1234567810",
                        "dataLimite" => "SESSENTA",
                        "dataVencimento" => $venc,
                        "mensagem" => array(
                            "linha1" => "Mensalidade App2Park",
                            "linha1" => "Período: ".$listParkSubs['subscription']." a ".$newvenc,
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
                        "valorNominal" => 100,
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

                    //var_dump($dats);

                    
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
                    CURLOPT_POSTFIELDS => $dats,
                    CURLOPT_HTTPHEADER => array(
                        "accept: application/json",
                        "content-type: application/json",
                        "x-inter-conta-corrente: 14158680"
                    ),
                    ));
    
                    $response = curl_exec($curl);
    
                    curl_close($curl);
    
                    $decode = json_decode($response);

                    //var_dump($response);

                    $codigoBarras= $decode->linhaDigitavel;
                    $numeroInter = $decode->nossoNumero;
                    $preco = "100.0";
                    $valo_format = number_format($preco,2,",",".");

                    $id_cart = $cart->createCart(1, $numeroInter, $codigoBarras, $preco, $hoje, $venc, 0);

                    $cart->createCartItem($id_cart, $park['id'], 1, $preco);

                    $id_subs = $subs->createSubscription($listParkSubs['id_user'], $preco, 1, 1, $doc, $listParkSubs['name_park'], $listParkSubs['email'], $newcep, $listParkSubs['street'], $listParkSubs['number'], '', $listParkSubs['neighborhood'], $listParkSubs['city'], $listParkSubs['state'], $p2[0], $ps2, $type);

                    //var_dump($id_subs);

                    $subs->createSubscriptionItem($id_subs, $park['id']);

                    $vencimento = date("d/m/Y", strtotime($park['subscription']));

                    //var_dump($id_subs);

                    $listParksUser = $puser->cronAllUserFromPark($park['id']);

                    foreach($listParksUser as $pu){
                        $desc = "<div style='background-color: #29CAA8; padding:55px; color:#000000;'><p style='color:#000000; padding:20px;'>
                    <div style='background-color: #ffffff; padding:30px; border-radius: 20px;min-width: 350px;'>
                    <img width='150'  src='https://www.app2park.com.br/assets/img/logo-app2park-footer.png' align='right'>
                    <br>
                    <p style='font-size:18px; padding:10px; font-weight:bold; color:#000000;'><b>Olá ".$pu['first_name']."!</b></p>
                        <p style='font-size:18px; padding:10px; color:#000000;'>Seu período de teste gratuito do App2Park está terminando! </p>
                        <p style='font-size:18px; padding:10px; color:#000000;'>Esperamos que tenha gostado! </p>
                        <p style='font-size:18px; padding:10px; color:#000000;'>Estamos enviando o link para fazer o download do boleto ou, se preferir, abaixo também
                        está a linha digitável para copiar e colar: </p>  
                        <p style='font-size:18px; padding:10px; color:#000000;'><b>Boleto:</b> <br>
                        Link do Boleto: https://www.app2park.com.br/boleto.php?id=".$numeroInter."<br>
                        Linha Digitável: ".$codigoBarras."<br>
                        <b>Valor:</b> ".$valo_format."</p>
                        <p style='font-size:18px; padding:10px; color:#000000;'>Caso tenha interesse em nossa Assinatura Anual, estamos oferecendo 10% de desconto.</p>
                        <p style='font-size:18px; padding:10px; color:#000000;'><b>Veja abaixo como fazer sua Assinatura Anual:</b><br>
                        <b>Android</b> - Acesse “Assinatura” no menu principal do App2Park.<br>
                        <b>iOS</b> - Por favor, entre em contato pelo WhatsAPP: 11 93316-5686</p>
                        <p style='font-size:18px; padding:10px; color:#000000;'><b>Dados do Estacionamento:</b><br>
                        ".$park['name_park']."<br>
                        ".$park['business_name']."<br>
                        Doc: ".$park['doc']."<br>
                        ".$park['street'].", ".$park['number']."<br>
                        ".$park['city']." ".$park['state']."</p>
                        <p style='font-size:18px; padding:10px; color:#000000;'>CEP: ".$park['postal_code']."</p>
                        <p style='font-size:18px; padding:10px; color:#000000;'><b>Data de término do teste:</b> ".$vencimento."</p>
                        <p style='font-size:18px; padding:10px; color:#000000;'>Agradecemos o seu interesse pelo App2Park!</p>
                        <p style='font-size:18px; padding:10px; color:#000000;'>Equipe App2Park</p>
                        <p style='font-size:18px; padding:10px; color:#000000;'>app2park.com.br</p>
                        <p style='font-size:18px; padding:10px; color:#000000;'>11 93316-5686 (WhatsAPP)</p></div></div>";
                        $mail->sendMailDescCron('Término do Período de Teste -'.$park['name_park'], $pu['email'], $desc);

                        sleep(5);

                        //var_dump($desc);
                    }
                }
            }
        }else{
        
        }
        

        $breakDate = date('Y-m-d', strtotime('+5 days', strtotime($hoje)));


        $listParksBlock = $cart->findAllParkPending($breakDate);


        //var_dump($listParksBlock);

        if($listParksBlock != null){

           foreach($listParksBlock as $publock){

            //var_dump($publock);


                $listHavaSubscription = $cart->findAllParkPendingwithParkInCart($publock['id']);

                //var_dump($listHavaSubscription);

                if($listHavaSubscription != null){

                    $pulist = $puser->cronAllUserFromPark($publock['id']);

                    $vencimentoboleto = date("d/m/Y", strtotime($listHavaSubscription['bank_slip_due']));

                    $bloqueado = date("d/m/Y", strtotime($publock['subscription']));
                    

                    foreach($pulist as $ussSend){

                        $desc = "<div style='background-color: #29CAA8; padding:55px; color:#000000;'><p style='color:#000000; padding:20px;'>
                    <div style='background-color: #ffffff; padding:30px; border-radius: 20px;min-width: 350px;'>
                    <img width='150'  src='https://www.app2park.com.br/assets/img/logo-app2park-footer.png' align='right'>
                    <br>
                    <p style='font-size:18px; padding:10px; color:#000000;'><b>Olá ".$ussSend['first_name']."! </b></p>
                        <p style='font-size:18px; padding:10px; color:#000000;'>Gostaria de informá-lo que não identificamos o pagamento do boleto do App2Park vencido no dia ".$vencimentoboleto."</p>
                        <p style='font-size:18px; padding:10px; color:#000000;'>Caso o pagamento já tenha sido realizado, solicitamos a gentileza de enviar o comprovante para: app2park@app2park.com.br </p>
                        <p style='font-size:18px; padding:10px; color:#000000;'>Por favor, mantenha os pagamentos em dia para evitar bloqueio do aplicativo. </p>
                        <p style='font-size:18px; padding:10px; color:#000000;'><b>Dados do Estacionamento:</b> <br>
                        ".$publock['name_park']."<br>
                        ".$publock['business_name']."</p>
                        <p style='font-size:18px; padding:10px; color:#000000;'>Doc: ".$publock['doc']."<br>
                        ".$publock['street'].", ".$publock['number']."<br>
                        ".$publock['city']." ".$publock['state']."</p>
                         <p style='font-size:18px; padding:10px; color:#000000;'>CEP: ".$publock['postal_code']."</p>
                        <p style='font-size:18px; padding:10px; color:#000000;'>App2Park será bloqueado dia: ".$bloqueado."</p>
                    
                        <p style='font-size:18px; padding:10px; color:#000000;'>Agradecemos por você utilizar o App2Park! </p>
                        <p style='font-size:18px; padding:10px; color:#000000;'>Equipe App2Park </p>
                        <p style='font-size:18px; padding:10px; color:#000000;'>app2park.com.br </p>
                        <p style='font-size:18px; padding:10px; color:#000000;'>11 93316-5686 (WhatsAPP)</p></div></div>";
    
                        //var_dump($desc);
    
                       $mail->sendMailDescCron('Pagamento não identificado - '.$publock['name_park'], $ussSend['email'], $desc);
    
                       sleep(5);

                    }

                } 

                //$pulist = $puser->cronAllUserFromPark($publock['id_park']);
               
                /*foreach($pulist as $ussSend){

                    //var_dump($ussSend);

                    $desc = 'Olá '.$ussSend['first_name'].'! <br>
                    Não identificamos o pagamento do boleto do App2Park com vencimento no dia '.$publock['bank_slip_due'].'<br>
                    Caso o pagamento já tenha sido realizado, solicitamos a gentileza de enviar o comprovante para: app2park@app2park.com.br <br>
                    Por favor, mantenha os pagamentos em dia para evitar bloqueio do aplicativo. <br>
                    Dados do Estacionamento: <br>
                    '.$publock['name_park'].'<br>
                    '.$publock['business_name'].'<br>
                    Doc: '.$publock['doc'].'<br>
                    '.$publock['street'].', '.$publock['number'].'<br>
                    '.$publock['city'].' '.$publock['state'].'<br>
                     CEP: '.$publock['postal_code'].'<br>
                    App2Park será bloqueado dia: '.$publock['subscription'].'<br>
                    Muito obrigado! <br>
                    Equipe App2Park <br>
                    app2park.com.br <br>
                    11 93316-5686 (WhatsAPP)';


                    //var_dump($desc);

                    //$mail->sendMailDesc('Vencimento do estacionamento!', $ussSend['email'], $desc);

                   // sleep(5);
                }*/
           }

        }

        
        $array['status'] = 'COMPLETED';
        $array['data'] = 'CRON EXECUTADO COM SUCESSO!';
				
        } else {
			$array['status'] = 'ERROR';
			$array['message'] = 'Método de requisição incompatível';
        }

		$this->returnJson($array);
    }
}