<?php

namespace Exam\AdminBundle\Twig\Extension;

use Exam\DomainBundle\Entity\Test\Enrollment;
use Exam\DomainBundle\Repository\EnrollmentRepository;
use Exam\DomainBundle\Repository\PackageRepository;
use Exam\DomainBundle\Repository\ParticipantRepository;
use JMS\DiExtraBundle\Annotation\InjectParams;

class GlobalExtension extends \Twig_Extension {
    private $participantRepo;
    private $packageRepo;
    private $enrollmentRepo;

    public function __construct(ParticipantRepository $participantRepo, PackageRepository $packageRepo, EnrollmentRepository $enrollmentRepo) {
        $this->participantRepo = $participantRepo;
        $this->packageRepo = $packageRepo;
        $this->enrollmentRepo = $enrollmentRepo;
    }

    public function getGlobals() {
        $enrollments = $this->enrollmentRepo->all();

        return array_merge(parent::getGlobals(), [
            'participantsCount' => $this->participantRepo->count(),
            'packagesCount' => $this->packageRepo->count(),
            'enrollmentsCount' => [
                'finished' => count(array_filter($enrollments, function(Enrollment $enrollment) {
                    return $enrollment->isFinished();
                })),
                'onProgress' => count(array_filter($enrollments, function(Enrollment $enrollment) {
                    return ($enrollment->isStarted() and !$enrollment->isFinished());
                })),
                'notStarted' => count(array_filter($enrollments, function(Enrollment $enrollment) {
                    return !$enrollment->isStarted();
                }))
            ]
        ]);
    }

    public function getName() {
        return 'global_extension';
    }
}