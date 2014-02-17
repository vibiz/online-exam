<?php

namespace Exam\AdminBundle\Controller;

use Exam\DomainBundle\Repository\ParticipantRepository;
use JMS\DiExtraBundle\Annotation\InjectParams;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/admin/participants")
 */
class ParticipantsController extends BaseController {
    private $repo;

    /**
     * @InjectParams
     */
    public function __construct(ParticipantRepository $participantRepo) {
        $this->repo = $participantRepo;
    }

    /**
     * @Route("/")
     * @Method({"GET"})
     */
    public function showAll() {
        return $this->render('participants/all.html.twig', [
            'participants' => $this->repo->all()
        ]);
    }

    /**
     * @Route("/create")
     * @Method({"GET"})
     */
    public function showCreate() {
        return $this->render('participants/create.html.twig');
    }
}