<?php

namespace Exam\DomainBundle\Repository;

use Doctrine\ORM\EntityManager;
use Exam\DomainBundle\Repository\BaseRepository;
use Exam\WebBundle\Service\LoginService;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Service("enrollmentRepo")
 */
class EnrollmentRepository extends BaseRepository {
    private $service;
    /**
     * @InjectParams({
     *      "em" = @Inject("doctrine.orm.entity_manager"),
     *      "service" = @Inject("loginService")
     * })
     */
    public function __construct(EntityManager $em,
                                LoginService $service) {
        parent::__construct($em);
        $this->service = $service;
    }

    public function getEnrollments() {
        $participant = $this->service->getCurrentParticipant();
        return $this->findBy(array('participant' => $participant));
    }

}