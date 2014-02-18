<?php

namespace Exam\AdminBundle\Controller;

use Exam\AopBundle\Transactional;
use Exam\DomainBundle\Entity\Test\Option;
use Exam\DomainBundle\Entity\Test\Package;
use Exam\DomainBundle\Entity\Test\Question;
use Exam\DomainBundle\Repository\PackageRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\DiExtraBundle\Annotation\InjectParams;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class PackageController extends BaseController {
    private $packageRepo;

    /**
     * @InjectParams
     */
    public function __construct(PackageRepository $packageRepo) {
        $this->packageRepo = $packageRepo;
    }
    /**
     * @Route("/packages")
     * @Method({"GET"})
     */
    public function showAll() {
        return $this->render('packages/all.html.twig', [
            'packages' => $this->packageRepo->all()
        ]);
    }

    /**
     * @Route("/packages/create")
     * @Method({"GET"})
     */
    public function showCreate() {
        return $this->render('packages/create.html.twig');
    }

    /**
     * @Route("/packages/create")
     * @Method({"POST"})
     * @Transactional
     */
    public function create(Request $request) {
        $this->packageRepo->persist(
            new Package($request->get('name'))
        );

        return $this->redirect('/admin/packages');
    }

    /**
     * @Route("/packages/{id}/questions")
     * @Method({"GET"})
     */
    public function showAllQuestions($id) {
        return $this->render('packages/questions/all.html.twig', [
            'package' => $this->packageRepo->find($id)
        ]);
    }

    /**
     * @Route("/packages/{id}/questions/add")
     * @Method({"GET"})
     */
    public function showAddQuestions($id) {
        return $this->render('packages/questions/add.html.twig', [
            'package' => $this->packageRepo->find($id)
        ]);
    }

    /**
     * @Route("/packages/edit")
     * @Method({"POST"})
     */
    public function edit(Request $request) {
        $package = $this->packageRepo->find($request->get('id'));

        if($request->get('question-description')) {
            $question = new Question($request->get('question-description'));

            foreach($request->get('options') as $option) {
                $question->addOption(new Option($option));
            }

            $package->addQuestion($question);
        }
        $this->packageRepo->persist($package);

        return $this->redirect('/admin/packages');
    }
}