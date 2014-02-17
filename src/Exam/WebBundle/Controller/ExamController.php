<?php
/**
 * Created by JetBrains PhpStorm.
 * User: quantum
 * Date: 2/14/14
 * Time: 9:31 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Exam\WebBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use Exam\DomainBundle\Repository\EnrollmentRepository;

/**
 * Class ExamController
 * @package Exam\WebBundle\Controller
 */
class ExamController extends BaseController {

    private $enrollmentRepo;

    /**
     * @InjectParams({
     *      "enrollmentRepo" = @Inject("enrollmentRepo")
     * })
     */
    public function __construct(EnrollmentRepository $enrollmentRepo) {
        $this->enrollmentRepo = $enrollmentRepo;
    }


    /**
     * @Route("/")
     */
    public function startExam() {
        return $this->render('ExamWebBundle:Exam:question.html.twig');
    }



}