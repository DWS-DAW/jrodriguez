<?php
// src/AppBundle/Controller/DefaultController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
	public function adminAction(){
		return new Response('<html><body>Pagina del administrador!!</body></html>');
	}
}
