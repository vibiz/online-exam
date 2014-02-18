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
use Exam\WebBundle\Service\PackageService;
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
            $service,
            $packageService;

    /**
     * @InjectParams({
     *      "enrollmentRepo" = @Inject("enrollmentRepo"),
     *      "session" = @Inject("session"),
     *      "service" = @Inject("loginService"),
     *      "packageService" = @Inject("packageService")
     * })
     */
    public function __construct(EnrollmentRepository $enrollmentRepo,
                                Session $session,
                                LoginService $service,
                                PackageService $packageService) {
        $this->enrollmentRepo = $enrollmentRepo;
        $this->session = $session;
        $this->service = $service;
        $this->packageService = $packageService;
    }


    /**
     * @Route("/exam")
     * @Method({"GET"})
     */
    public function startExam() {
        if(!$this->service->isLogin()) {
            return $this->redirect('/login');
        }

        if(!$this->packageService->hasSelectPackage()) {
            return $this->render('ExamWebBundle:Exam:enrollment.html.twig', [
                "all" => $this->enrollmentRepo->getEnrollments()
            ]);
        }
        var_dump($this->packageService->getCurrentPackage()->getQuestions()->getOptions());exit;
        return $this->render('ExamWebBundle:Exam:question.html.twig', [
            "package" => $this->packageService->getCurrentPackage()
        ]);
    }

    /**
     * @Route("/exam/{packageId}")
     */
    public function setPackage($packageId) {
        if(!$this->service->isLogin()) {
            return $this->redirect('/login');
        }

        $this->packageService->setPackage($packageId);

        return $this->redirect("/exam");
    }
}