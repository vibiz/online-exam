<?php

namespace Exam\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/admin")
 */
class QuestionController extends BaseController {
    /**
     * @Route("/questions/add")
     * @Method({"GET"})
     */
    public function index() {
        return $this->render('front/index.html.twig');
    }
}