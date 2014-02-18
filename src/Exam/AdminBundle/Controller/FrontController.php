<?php

namespace Exam\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/admin")
 */
class FrontController extends BaseController {

    public function __construct() {

    }

    /**
     * @Route("/")
     * @Method({"GET"})
     */
    public function index() {
        return $this->render('front/index.html.twig');
    }
}