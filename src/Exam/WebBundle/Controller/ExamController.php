<?php
/**
 * Created by JetBrains PhpStorm.
 * User: quantum
 * Date: 2/14/14
 * Time: 9:31 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Exam\WebBundle\Controller;

use Exam\WebBundle\Service\LoginService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use Exam\DomainBundle\Repository\EnrollmentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class ExamController
 * @package Exam\WebBundle\Controller
 */
class ExamController extends BaseController {

    private $enrollmentRepo,
            $session,
            $service;

    /**
     * @InjectParams({
     *      "enrollmentRepo" = @Inject("enrollmentRepo"),
     *      "session" = @Inject("session"),
     *      "service" = @Inject("loginService")
     * })
     */
    public function __construct(EnrollmentRepository $enrollmentRepo,
                                Session $session,
                                LoginService $service) {
        $this->enrollmentRepo = $enrollmentRepo;
        $this->session = $session;
        $this->service = $service;
    }


    /**
     * @Route("/exam")
     * @Method({"GET"})
     */
    public function startExam() {
        if(!$this->service->isLogin()) {
            return $this->redirect('/login');
        }

        if(!$this->session->get('enrollment')){
            return $this->render('ExamWebBundle:Exam:enrollment.html.twig');
        }

        return $this->render('ExamWebBundle:Exam:question.html.twig');
    }
}