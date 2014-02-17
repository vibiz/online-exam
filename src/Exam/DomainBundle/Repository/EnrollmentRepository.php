<?php

namespace Exam\DomainBundle\Repository;

use Doctrine\ORM\EntityManager;
use Exam\DomainBundle\Repository\BaseRepository;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Service("enrollmentRepo")
 */
class EnrollmentRepository extends BaseRepository {
    private $session;
    /**
     * @InjectParams({
     *      "em" = @Inject("doctrine.orm.entity_manager"),
     *      "session" = @Inject("session")
     * })
     */
    public function __construct(EntityManager $em, Session $session) {
        parent::__construct($em);
        $this->session = $session;
    }

    public function getEnrollments() {

    }

}