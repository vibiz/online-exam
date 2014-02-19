<?php

namespace Exam\AdminBundle\Controller;

use Exam\DomainBundle\Repository\OptionRepository;
use Exam\DomainBundle\Repository\QuestionRepository;
use JMS\DiExtraBundle\Annotation\InjectParams;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Response;
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
     * @Route("/questions/answer/edit")
     * @Method({"POST"})
     */
    public function edit(Request $request) {
        $question = $this->questionRepo->find($request->get('id'));

        $question->setCorrectOption(
            $this->optionRepo->find($request->get('correctOption'))
        );

        $this->questionRepo->persist($question);

        var_dump($question->getCorrectOption());exit;

        return new Response();
    }
}