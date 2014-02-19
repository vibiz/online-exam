<?php

namespace Exam\AdminBundle\Controller;

use Exam\AopBundle\Transactional;
use Exam\DomainBundle\Repository\OptionRepository;
use Exam\DomainBundle\Repository\QuestionRepository;
use JMS\DiExtraBundle\Annotation\InjectParams;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class QuestionController extends BaseController {
    private $questionRepo;
    private $optionRepo;

    /**
     * @InjectParams
     */
    public function __construct(QuestionRepository $questionRepo, OptionRepository $optionRepo) {
        $this->questionRepo = $questionRepo;
        $this->optionRepo = $optionRepo;
    }

    /**
     * @Route("/questions/add")
     * @Method({"GET"})
     */
    public function index() {
        return $this->render('front/index.html.twig');
    }

    /**
     * @Route("/questions/answer")
     * @Method({"POST"})
     * @Transactional
     */
    public function editAnswer(Request $request) {
        $questionId = $request->get('id');
        $answerId = $request->get('correctOption-'.$request->get('id'));
        $question = $this->questionRepo->find($questionId);

        $this->questionRepo->persist(
            $question->setAnswer($answerId)
        );

        return new Response('Success', 200);
    }
}