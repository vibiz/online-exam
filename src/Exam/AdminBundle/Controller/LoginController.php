<?php

namespace Exam\AdminBundle\Controller;

use Exam\DomainBundle\Repository\AdminRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\DiExtraBundle\Annotation\InjectParams;

/**
 * @Route("/admin")
 */
class LoginController extends BaseController {
    private $repo;

    /**
     * @InjectParams
     */
    public function __construct(AdminRepository $adminRepo) {
        $this->repo = $adminRepo;
    }

    /**
     * @Route("/login")
     * @Method({"GET"})
     */
    public function login() {
        return $this->render('front/login.html.twig');
    }
}