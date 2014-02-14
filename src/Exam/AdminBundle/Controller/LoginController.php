<?php

namespace Exam\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class LoginController extends BaseController {
    /**
     * @Route("/login")
     * @Method({"GET"})
     */
    public function login() {
        return $this->render();
    }
}