<?php

namespace Exam\AdminBundle\Controller;

use Exam\DomainBundle\Entity\User\User;
use Exam\DomainBundle\Repository\ParticipantRepository;
use Exam\AopBundle\Transactional;
use JMS\DiExtraBundle\Annotation\InjectParams;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @Route("/create")
     * @Method({"POST"})
     * @Transactional
     */
    public function create(Request $request) {
        $username = $request->get('registration-number');
        $password = md5();

        $user = new User($username, '');
    }

    /**
     * @Route("/checkRegistrationNumber")
     * @Method({"POST"})
     */
    public function checkRegistrationNumber(Request $request) {
        return new Response(
            $this->repo->findOneBy(['registrationId' => $request->get('registrationNumber')])
        );
    }
}