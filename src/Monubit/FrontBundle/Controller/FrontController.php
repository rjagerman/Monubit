<?php

namespace Monubit\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FrontController extends Controller {

	/**
	 * @Route("/", name="home")
	 * @Template()
	 */
	public function indexAction() {
		return array();
	}
}
