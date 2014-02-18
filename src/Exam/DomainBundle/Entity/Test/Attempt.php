<?php

namespace Exam\DomainBundle\Entity\Test;

use Doctrine\ORM\Mapping as ORM;
use Exam\DomainBundle\Entity\Entity;
use Exam\DomainBundle\Entity\Test\Question;

/**
 * @ORM\Entity
 */
class Attempt extends Entity {
    /**
     * @ORM\ManyToOne(targetEntity="Enrollment", inversedBy="attempts")
     */
    private $enrollment;

    /**
     * @ORM\OneToOne(targetEntity="Question")
     */
    private $question;

    /**
     * @ORM\OneToOne(targetEntity="Option")
     */
    private $answer;

    /**
     * @ORM\Column(type="datetime")
     */
    private $answeredOn;

    public function __construct(Question $question, Option $option) {
        parent::__construct();
        $this->question = $question;
        $this->answer = $option;
        $this->answeredOn = new \DateTime('NOW');
    }

    public function getQuestion() {
        return $this->question;
    }

    public function getAnswer() {
        return $this->answer;
    }

    public function getAnsweredOn() {
        return $this->answeredOn;
    }
}