<?php

namespace Exam\AdminBundle\Controller;

use Exam\AopBundle\Transactional;
use Exam\DomainBundle\Entity\Test\Enrollment;
use Exam\DomainBundle\Entity\Test\Option;
use Exam\DomainBundle\Entity\Test\Package;
use Exam\DomainBundle\Entity\Test\Question;
use Exam\DomainBundle\Repository\EnrollmentRepository;
use Exam\DomainBundle\Repository\PackageRepository;
use Exam\DomainBundle\Repository\ParticipantRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\DiExtraBundle\Annotation\InjectParams;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class PackageController extends BaseController {
    private $packageRepo;
    private $enrollmentRepo;
    private $participantRepo;

    /**
     * @InjectParams
     */
    public function __construct(PackageRepository $packageRepo, EnrollmentRepository $enrollmentRepo, ParticipantRepository $participantRepo) {
        $this->packageRepo = $packageRepo;
        $this->enrollmentRepo = $enrollmentRepo;
        $this->participantRepo = $participantRepo;
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

        return $this->redirect('/admin/packages', 302, [
            'success' => 'Package created successfully'
        ]);
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
     * @Transactional
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

    /**
     * @Route("/packages/{id}/enroll")
     * @Method({"GET"})
     */
    public function showEnroll($id) {
        $package = $this->packageRepo->find($id);
        $participants = $this->participantRepo->all();
        $enrollments = $this->enrollmentRepo->findEnrollmentsForPackage($package);

        return $this->render('/packages/enrollments/all.html.twig', [
            'package' => $package,
            'enrollments' => $enrollments,
            'availableParticipants' => array_filter($participants,
                function($participant) use($enrollments) {
                    return !sizeof(array_filter($enrollments,
                        function(Enrollment $enrollment) use ($participant) {
                            return ($enrollment->getParticipant() === $participant) and !$enrollment->isFinished();
                        })
                    );
            })
        ]);
    }
}