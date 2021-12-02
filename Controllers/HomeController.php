<?php
namespace Controllers;

use \Core\Controller;
use \Models\Usuarios;

class HomeController extends Controller {

	public function index() {
		$this->returnJson(array('API APP2PARK - DOCUMENTAÇÃO V1'));
	}

}