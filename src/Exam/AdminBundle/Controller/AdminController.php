<?php

namespace Exam\AdminBundle\Controller;

use Exam\DomainBundle\Repository\AdminRepository;
use JMS\DiExtraBundle\Annotation\InjectParams;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/admin")
 */
class AdminController extends BaseController {
    private $adminRepo;

    /**
     * @InjectParams
     */
    public function __construct(AdminRepository $adminRepo) {
        $this->adminRepo = $adminRepo;
    }

    /**
     * @Route("/changePassword")
     */
    public function showChangePassword() {
        return $this->render('admin/changePassword.html.twig');
    }
}