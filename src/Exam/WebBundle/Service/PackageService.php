<?php
/**
 * Created by JetBrains PhpStorm.
 * User: quantum
 * Date: 2/18/14
 * Time: 12:00 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Exam\WebBundle\Service;

use Exam\DomainBundle\Repository\PackageRepository;
use JMS\DiExtraBundle\Annotation\InjectParams;
use Symfony\Component\HttpFoundation\Session\Session;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation\Inject;

/**
 * Class PackageService
 * @package Exam\WebBundle\Service
 * @Service("packageService")
 */
class PackageService {

    private $session,
            $repo;

    /**
     * @InjectParams({
     *      "session" = @Inject("session"),
     *      "repo" = @Inject("packageRepo")
     * })
     */
    public function __construct(Session $session,
                                PackageRepository $repo) {
        $this->session = $session;
        $this->repo = $repo;
    }

    public function hasSelectPackage() {
        return $this->session->has('package');
    }

    public function setPackage($packageId) {
        if(!$this->session->has('package')) {
            $this->session->set('package', $packageId);
        }
    }

    public function removePackage() {
        if($this->hasSelectPackage()) {
            $this->session->remove('package');
        }
    }

    public function getCurrentPackage() {
        return $this->repo->find($this->session->get('package'));
    }

}