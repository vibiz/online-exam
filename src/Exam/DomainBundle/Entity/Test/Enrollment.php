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
     * @ORM\OneToOne(targetEntity="Exam\DomainBundle\Entity\User\Participant")
     */
    private $participant;

    /**
     * @ORM\OneToOne(targetEntity="Package")
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
     * @ORM\OneToMany(targetEntity="Attempt", mappedBy="id")
     */
    private $attempts;

    public function __construct(Participant $participant, Package $package) {
        $this->participant = $participant;
        $this->package = $package;
        $this->attempts = new ArrayCollection();
    }

    public function addAttempts(Attempt $attempt) {
        $this->attempts->add($attempt);
    }

    public function start() {
        $this->startedOn = new \DateTime('NOW');
    }

    public function finish() {
        $this->finishedOn = new \DateTime('NOW');
    }

    public function getAttemptsFor(Question $question) {
        return $this->attempts->filter(function(Attempt $attempt) use($question) {
            return $attempt->getQuestion() === $question;
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
}