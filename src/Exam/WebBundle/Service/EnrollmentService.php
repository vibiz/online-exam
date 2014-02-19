<?php
/**
 * Created by JetBrains PhpStorm.
 * User: quantum
 * Date: 2/18/14
 * Time: 12:00 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Exam\WebBundle\Service;

use Exam\DomainBundle\Entity\Test\Enrollment;
use Exam\DomainBundle\Repository\EnrollmentRepository;
use Exam\DomainBundle\Repository\PackageRepository;
use JMS\DiExtraBundle\Annotation\InjectParams;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Session\Session;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation\Inject;

/**
 * Class EnrollmentService
 * @package Exam\WebBundle\Service
 * @Service("enrollmentService")
 */
class EnrollmentService {

    private $enrollmentId,
            $session,
            $enrollmentRepo,
            $loginService,
            $crudService;

    /**
     * @InjectParams({
     *      "session" = @Inject("session"),
     *      "enrollmentRepo" = @Inject("enrollmentRepo"),
     *      "loginService" = @Inject("loginService"),
     *      "crudService" = @Inject("crudService")
     * })
     */
    public function __construct(Session $session,
                                EnrollmentRepository $enrollmentRepo,
                                LoginService $loginService,
                                CRUDService $crudService) {
        $this->session = $session;
        $this->enrollmentRepo = $enrollmentRepo;
        $this->loginService = $loginService;
        $this->crudService = $crudService;
        $this->enrollmentId = $this->session->get('enrollment');
    }

    public function hasEnrollment() {
        return $this->session->has('enrollment');
    }

    private function setEnrollment($enrollmentId) {
        if(!$this->authorizeEnrollmentSession()) {
            $enrollment = $this->enrollmentRepo->findOneBy(array(
                "id" => $enrollmentId,
                "participant" => $this->loginService->getCurrentParticipant(),
            ));

            if(!$enrollment) { throw new \Exception("not found!"); }

            $this->session->set('enrollment', $enrollment->getId());

            $this->enrollmentId = $enrollment->getId();
        }

        return $this;
    }

    public function authorizeEnrollmentSession() {
        return $this->session->has('enrollment');
    }

    public function removeEnrollment() {
        if($this->hasEnrollment()) {
            $this->session->remove('enrollment');
        }
    }

    public function getCurrentPackage() {
        $enrollment = $this->enrollmentRepo->find($this->enrollmentId);
        return $enrollment->getPackage();
    }

    public function getEnrollment() {
        return $this->enrollmentRepo->find($this->enrollmentId);
    }

    public function getEnrollments() {
        return $this->enrollmentRepo->getEnrollments();
    }

    public function startEnrollment($enrollmentId) {
        if($this->authorizeEnrollmentSession()) return false;

        $this->setEnrollment($enrollmentId);

        if($this->getEnrollment()->isStarted()) {
            $this->removeEnrollment();
            throw new \Exception("This package has been started!");
        }

        if(!$this->getEnrollment()->isStarted()) {

            $this->crudService->update(
                $this->getEnrollment()->start()
            );
        }
    }

    public function finishEnrollment() {
        if($this->getEnrollment()->isStarted()) {
            $this->crudService->update(
                $this->getEnrollment()->finish()
            );

            $this->removeEnrollment();
        }
    }

    public function restartEnrollment() {
        if($this->getEnrollment()->isStarted()) {
            $this->crudService->update(
                $this->getEnrollment()->restart()
            );
        }
    }
}