<?php
global $routes;
$routes = array();

$routes['/users/login'] = '/users/login';
$routes['/users/new'] = '/users/new_record';
$routes['/users/pass'] = '/users/reset_pass';
$routes['/users/pass_new'] = '/users/new_pass';
//$routes['/users/feed'] = '/users/feed';
$routes['/users/{id}'] = '/users/view/:id';
//$routes['/users/{id}/photos'] = '/users/photos/:id';
//$routes['/users/{id}/follow'] = '/users/follow/:id';

$routes['/parks/new'] = '/parks/new_record';
$routes['/parks/newservicepark'] = '/parks/new_ServicePark';
$routes['/parks/photo'] = '/parks/uploadImage';
$routes['/parks/schedule'] = '/parks/new_schedule';
$routes['/parks/price'] = '/parks/new_park_price';
$routes['/parks/getallservicespark'] = '/parks/get_AllServicePark';
$routes['/parks/sincparksbyiduser'] = '/parks/sinc_parksByIdUser';
$routes['/parks/sincparkuserbyidparkiduser'] = '/parks/sinc_parksUserByIdParkIdUser';
$routes['/parks/sincuserparkuserbyidpark'] = '/parks/sinc_userParkUserByIdPark';
$routes['/parks/price/item'] = '/parks/new_park_price_item';
$routes['/parks/{id}'] = '/parks/view/:id';
$routes['/parks/allparksbyuser/{id}'] = '/parks/listallParksByIdUser/:id';
$routes['/parks/updateservicepark/{id}'] = '/parks/update_service_park/:id';
$routes['/parks/getserviceparkbyidpark/{id}'] = '/parks/get_AllServiceParkByIdPark/:id';
$routes['/parks/getserviceparkbyid/{id}'] = '/parks/get_AllServiceParkById/:id';

$routes['/puser/invite'] = '/puser/invite_park';
$routes['/puser/updateinvite'] = '/puser/updateInvite';
$routes['/puser/accept/{keyval}'] = '/puser/accept_invite/:keyval';
$routes['/puser/{id}'] = '/puser/view/:id';
$routes['/puser/sincpuser/{id}'] = '/puser/sinc_Puser/:id';
$routes['/puser/sincpuserout/{id}'] = '/puser/sincOut_PuserOut/:id';
$routes['/puser/allinvitesuser/{id_user}/{id_park}'] = '/puser/AllInvites/:id_user/:id_park';
$routes['/puser/getallpuser/{id_park}'] = '/puser/getAllPuser/:id_park';
$routes['/puser/allinvites/{id}'] = '/puser/AllInvites/:id';
$routes['/puser/allinvitesactive/{id}'] = '/puser/AllInvitesActive/:id';
$routes['/puser/allinvitespending/{id}'] = '/puser/AllInvitesPending/:id';
$routes['/puser/allinvitesinactive/{id}'] = '/puser/AllInvitesInactive/:id';

$routes['/vehicles/new'] = '/vehicles/new_vehicle';
$routes['/vehicles/type'] = '/vehicles/new_type';
$routes['/vehicles/maker'] = '/vehicles/new_maker';
$routes['/vehicles/color'] = '/vehicles/new_color';
$routes['/vehicles/model'] = '/vehicles/new_model';
$routes['/vehicles/vehicletype'] = '/vehicles/get_vehicleType';
$routes['/vehicles/vehicletypepark'] = '/vehicles/new_vehicletypepark';
$routes['/vehicles/{id}'] = '/vehicles/view/:id';
$routes['/vehicles/sincvehicletypeparkbypark/{id}'] = '/vehicles/sinc_vehicleTypeParkByPark/:id';
$routes['/vehicles/updatevehicletypepark/{id}'] = '/vehicles/update_vehicle_type_park/:id';
$routes['/vehicles/allvehicletypebypark/{id}'] = '/vehicles/get_vehicleTypePark/:id';
$routes['/vehicles/getvehicletypepark/{id}'] = '/vehicles/get_vehicleTypeParkByPark/:id';

$routes['/customers/new'] = '/customers/new_customer';
$routes['/customers/newvehiclecustomer'] = '/customers/new_vehicle_customer';
$routes['/customers/{id}'] = '/customers/view/:id';
$routes['/customers/findvehiclecustomersbyplate/{id}'] = '/customers/search_vehicle_customer_by_plate/:id';
$routes['/customers/doc/{id}'] = '/customers/find_doc/:id';

$routes['/tickets/getallticketobject'] = '/tickets/get_TicketAllObject';
$routes['/tickets/getalltickethistoricstatus'] = '/tickets/get_TicketHistoricStatus';
$routes['/tickets/new'] = '/tickets/new_record';
$routes['/tickets/newtickethistoric'] = '/tickets/new_ticket_historic';
$routes['/tickets/update/{id}'] = '/tickets/update_tickets/:id';
$routes['/tickets/newticketobject'] = '/tickets/new_ticketObject';
$routes['/tickets/newtickethistoricphoto'] = '/tickets/create_ticket_historic_photo';
$routes['/tickets/newticketserviceadditional'] = '/tickets/new_ticket_service_additional';
$routes['/tickets/ticketonbyticketoff'] = '/tickets/ticketon_ticketoff';
$routes['/tickets/informationticket'] = '/tickets/information_tickets';
$routes['/tickets/getallticketsopen'] = '/tickets/get_AllTicketsOpen';
$routes['/tickets/sendticket'] = '/tickets/send_tickets';
$routes['/tickets/{id}'] = '/tickets/view/:id';
$routes['/tickets/getticketobjectbyid/{id}'] = '/tickets/get_TicketObjectById/:id';
$routes['/tickets/getallinformationticket/{id}'] = '/tickets/get_AllInformationTickets/:id';

$routes['/payments/paymentsallmethod'] = '/payments/get_AllPaymentsMethod';
$routes['/payments/allpaymentsmethodbypark/{id}'] = '/payments/get_PaymentsTypePark/:id';
$routes['/payments/updatepaymentmethodpark/{id}'] = '/payments/update_payment_method_park/:id';
$routes['/payments/sincpaymentmethodparkbyidpark/{id}'] = '/payments/sinc_paymentsMethodPark/:id';
$routes['/payments/paymentsmethodparkinnerjoinpaymentmethod/{id}'] = '/payments/get_PaymentMethodParkInnerJoinPaymentMethod/:id';

$routes['/offices/getoffices'] = '/offices/get_Offices';

$routes['/status/getstatus'] = '/status/get_Status';

$routes['/cashs/allcashmovementtype'] = '/cashs/get_AllCashsMovementType';
$routes['/cashs/newcash'] = '/cashs/new_Cashs';
$routes['/cashs/newcashmovement'] = '/cashs/new_CashMovement';
$routes['/cashs/sinccashs'] = '/cashs/sinc_allcashs';
$routes['/cashs/{id}'] = '/cashs/get_cashs/:id';
$routes['/cashs/allcashsbyidpark/{id}'] = '/cashs/get_cashsByIdPark/:id';
$routes['/cashs/cashmovementtype/{id}'] = '/cashs/get_cashMovement/:id';

$routes['/prices/getallpricesitembase'] = '/prices/getallpricesitembase';
$routes['/prices/newpricedetached'] = '/prices/new_PriceDetached';
$routes['/prices/newpricedetacheditem'] = '/prices/new_PriceDetachedItem';
$routes['/prices/deletepricedetacheditem'] = '/prices/del_PriceDetachedItem';
$routes['/prices/sincpricedetached/{id}'] = '/prices/sinc_priceDetached/:id';
$routes['/prices/sincgetpricedetacheditem/{id}'] = '/prices/sincGetPriceDetachedItem/:id';
$routes['/prices/updatepricedetached/{id}'] = '/prices/update_priceDetached/:id';
$routes['/prices/updatepricedetacheditem/{id}'] = '/prices/update_priceDetachedItem/:id';
$routes['/prices/getpricedetached/{id}'] = '/prices/get_PriceDetached/:id';
$routes['/prices/getpricedetacheditem/{id}'] = '/prices/get_PriceDetachedItem/:id';

$routes['/objects/getallobjects'] = '/objects/get_Objects';

$routes['/services/getservicesadditional'] = '/services/get_Services';
$routes['/services/sincparkserviceadditional/{id}'] = '/services/sinc_parkServiceAdditional/:id';

$routes['/agreements/newagreement'] = '/agreements/new_Agreement';
$routes['/agreements/editagreement/{id}'] = '/agreements/update_agreement/:id';
$routes['/agreements/getagreementbyid/{id}'] = '/agreements/get_AgreementById/:id';
$routes['/agreements/sincagreementbyiduser/{id}'] = '/agreements/sinc_AgreementByIdUser/:id';

$routes['/version/getversion'] = '/version/get_Version';

$routes['/form/newform'] = '/form/new_form';

$routes['/notafiscal/newnotafiscal'] = '/notafiscal/new_Nota_Fiscal';
$routes['/notafiscal/newnotafiscallog'] = '/notafiscal/new_Nota_Fiscal_Log';
$routes['/notafiscal/getnotafiscalcpf/{id}'] = '/notafiscal/get_Nota_Fiscal_CPF/:id';
$routes['/notafiscal/getnotafiscalcnpj/{id}'] = '/notafiscal/get_Nota_Fiscal_CNPJ/:id';

$routes['/boleto/newboleto'] = '/boleto/new_boleto';
$routes['/boleto/sendboleto'] = '/boleto/send_boletoMail';
$routes['/boleto/getboleto'] = '/boleto/getbase64_boleto';
$routes['/boleto/getboletobydate'] = '/boleto/getboleto_bydate';

$routes['/subscription/newsubcription'] = '/subscription/new_subscription';
$routes['/subscription/newsubcriptionitem'] = '/subscription/new_subscriptionItem';
$routes['/subscription/updatesubcription/{id}'] = '/subscription/update_subscription/:id';
$routes['/subscription/updatesubcriptionitem/{id}'] = '/subscription/update_subscriptionItem/:id';

$routes['/cart/newcart'] = '/cart/new_cart';
$routes['/cart/newcartitem'] = '/cart/new_cartItem';
$routes['/cart/updatecart/{id}'] = '/cart/update_cart/:id';
$routes['/cart/updatecartitem/{id}'] = '/cart/update_cartItem/:id';

$routes['/notafiscalassinatura/newnotafiscalassinatura'] = '/notafiscalassinatura/new_Nota_Fiscal_Assinatura';

$routes['/cron/atualizarpagamento'] = '/cron/atualizar_pag';
$routes['/cron/criarboletopagamento'] = '/cron/criarboleto_pag';

$routes['/receipt/criarrecibo'] = '/receipt/new_receipt';
$routes['/receipt/buscarreciboporidticket'] = '/receipt/get_receipt';

$routes['/masterpass/criarpass'] = '/masterpass/new_masterpass';

$routes['/log/criarlog'] = '/log/new_log';