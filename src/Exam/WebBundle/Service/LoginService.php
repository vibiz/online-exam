<?php
/**
 * Created by JetBrains PhpStorm.
 * User: quantum
 * Date: 2/18/14
 * Time: 10:27 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Exam\WebBundle\Service;

use JMS\DiExtraBundle\Annotation\InjectParams;
use Symfony\Component\HttpFoundation\Session\Session;
use JMS\DiExtraBundle\Annotation\Service;

/**
 * Class LoginService
 * @package Exam\WebBundle\Service
 * @Service("loginService")
 */
class LoginService {
    private $session;

    /**
     * @InjectParams
     */
    public function __construct(Session $session) {
        $this->session = $session;
    }

    public function checkParticipant($username, $password) {
        if($username == 'test') {
            if($password == 'test') {
                $this->session->set('user', $username);
            }
        }
    }

    public function isLogin() {
        return $this->session->has('user');
    }

    public function logout() {
        if($this->isLogin()) {
            $this->session->clear();
        }
    }

}