<?php
/**
 * Created by JetBrains PhpStorm.
 * User: quantum
 * Date: 2/14/14
 * Time: 9:31 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Exam\WebBundle\Controller;

use Exam\WebBundle\Service\EnrollmentService;
use Exam\WebBundle\Service\LoginService;
use Exam\WebBundle\Service\PackageService;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use Exam\DomainBundle\Repository\EnrollmentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Exam\AopBundle\Transactional;

/**
 * Class ExamController
 * @package Exam\WebBundle\Controller
 */
class ExamController extends BaseController {

    private $service,
            $enrollmentService;

    /**
     * @InjectParams({
     *      "service" = @Inject("loginService"),
     *      "enrollmentService" = @Inject("enrollmentService")
     * })
     */
    public function __construct(LoginService $service,
                                EnrollmentService $enrollmentService) {
        $this->service = $service;
        $this->enrollmentService = $enrollmentService;
    }


    /**
     * @Route("/exam")
     * @Method({"GET"})
     */
    public function startExam() {
        if(!$this->service->isLogin()) {
            return $this->redirect('/login');
        }

        if(!$this->enrollmentService->hasEnrollment()) {
            return $this->render('ExamWebBundle:Exam:enrollment.html.twig', [
                "all" => $this->enrollmentService->getEnrollments()
            ]);
        }

        return $this->render('ExamWebBundle:Exam:question.html.twig', [
            "package" => $this->enrollmentService->getCurrentPackage()
        ]);
    }

    /**
     * @Route("/exam/{enrollmentId}")
     * @Method({"GET"})
     * @Transactional
     */
    public function setPackage($enrollmentId) {
        if(!$this->service->isLogin()) {
            return $this->redirect('/login');
        }

        $this->enrollmentService->startEnrollment($enrollmentId);

        return $this->redirect("/exam");
    }

    /**
     * @Route("/exam/attempt/{questionId}/{answerId}")
     * @Method({"POST"})
     * @Transactional
     */
    public function addAttempt($questionId, $answerId) {
        
    }
}