<?php

namespace Exam\AdminBundle\Controller;

use Exam\AopBundle\Transactional;
use Exam\DomainBundle\Entity\Test\Package;
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
    public function showQuestions($id) {
        return $this->render('packages/questions.html.twig', [
            'package' => $this->packageRepo->find($id)
        ]);
    }
}