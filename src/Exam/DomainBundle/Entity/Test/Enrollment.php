<?php

namespace Exam\DomainBundle\Entity\Test;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Exam\DomainBundle\Entity\Entity;
use Exam\DomainBundle\Entity\Test\Question;
use Exam\DomainBundle\Entity\User\Participant;

/**
 * @ORM\Entity
 */
class Enrollment extends Entity {
    /**
     * @ORM\ManyToOne(targetEntity="Exam\DomainBundle\Entity\User\Participant")
     */
    private $participant;

    /**
     * @ORM\ManyToOne(targetEntity="Package")
     */
    private $package;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startedOn;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $finishedOn;

    /**
     * @ORM\OneToMany(targetEntity="Attempt", mappedBy="enrollment", cascade={"persist"})
     */
    private $attempts;

    public function __construct(Participant $participant, Package $package) {
        parent::__construct();
        $this->participant = $participant;
        $this->package = $package;
        $this->attempts = new ArrayCollection();
    }

    public function addAttempts(Attempt $attempt) {
        $this->attempts->add($attempt);

        return $this;
    }

    public function start() {
        $this->startedOn = new \DateTime('NOW');

        return $this;
    }

    public function finish() {
        $this->finishedOn = new \DateTime('NOW');

        return $this;
    }

    public function restart() {
        $this->startedOn = new \DateTime('NOW');
        $this->finishedOn = null;
        $this->attempts = new ArrayCollection();

        return $this;
    }

    public function getAttemptsFor($questionId) {
        return $this->attempts->filter(function(Attempt $attempt) use($questionId) {
            return $attempt->getQuestion()->getId() === $questionId;
        });
    }

    public function getStartedOn() {
        return $this->startedOn;
    }

    public function getFinishedOn() {
        return $this->finishedOn;
    }

    public function isStarted() {
        return isset($this->startedOn);
    }

    public function isFinished() {
        return isset($this->finishedOn);
    }

    public function getPackage() {
        return $this->package;
    }

    public function getParticipant() {
        return $this->participant;
    }
}