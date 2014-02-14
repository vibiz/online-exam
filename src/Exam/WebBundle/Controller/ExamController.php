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

/**
 * Class ExamController
 * @package Exam\WebBundle\Controller
 */
class ExamController extends BaseController {

    /**
     * @Route("/")
     */
    public function startExam() {
        return $this->render('ExamWebBundle:Exam:question.html.twig');
    }

}