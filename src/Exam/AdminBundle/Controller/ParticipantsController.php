<?php

namespace Exam\AdminBundle\Controller;

use Exam\AopBundle\FlashMessage;
use Exam\AopBundle\Transactional;
use Exam\DomainBundle\Entity\User\Participant;
use Exam\DomainBundle\Entity\User\User;
use Exam\DomainBundle\Repository\ParticipantRepository;
use Exam\DomainBundle\Repository\UserRepository;
use JMS\DiExtraBundle\Annotation\InjectParams;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/participants")
 */
class ParticipantsController extends BaseController {
    private $participantRepo;
    private $userRepo;

    /**
     * @InjectParams
     */
    public function __construct(ParticipantRepository $participantRepo, UserRepository $userRepo) {
        $this->participantRepo = $participantRepo;
        $this->userRepo = $userRepo;
    }

    /**
     * @Route("/")
     * @Method({"GET"})
     */
    public function showAll() {
        return $this->render('participants/all.html.twig', [
            'participants' => $this->participantRepo->all()
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
     * @Route("/edit/{id}")
     * @Method({"GET"})
     */
    public function showEdit($id) {
        return $this->render('participants/edit.html.twig', [
            'participant' => $this->participantRepo->find($id)
        ]);
    }

    /**
     * @Route("/edit")
     * @Method({"POST"})
     */
    public function edit(Request $request) {
        $participant = $this->participantRepo->find($request->get('id'));


    }

    /**
     * @Route("/create")
     * @Method({"POST"})
     * @Transactional
     */
    public function create(Request $request) {
        if(!$this->isRegistrationNumberUnique($request->get('registration-number'))) {
            return $this->render('participants/create.html.twig', [
                'errorMessage' => 'Registration #'.$request->get('registration-number').' is already registered'
            ]);
        }

        $username = $request->get('registration-number');
        $password = md5($request->get('registration-number').str_replace('/', '', $request->get('dob')));

        $user = new User($username, $password);

        $this->userRepo->persist($user);

        $participant = new Participant(
            $user,
            $request->get('registration-number'),
            $request->get('name'),
            new \DateTime(date('Y-m-d', strtotime($request->get('dob'))))
        );

        $this->participantRepo->persist($participant);

        return $this->showAll();
    }

    /**
     * @Route("/checkRegistrationNumber")
     * @Method({"POST"})
     */
    public function checkRegistrationNumber(Request $request) {
        return new Response(
            $this->isRegistrationNumberUnique($request->get('registration-number')) ? '' : 'false'
        );
    }

    private function isRegistrationNumberUnique($registrationNumber) {
        $participant = $this->participantRepo->findOneBy(['registrationId' => $registrationNumber]);

        return empty($participant);
    }
}