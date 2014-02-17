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
class Package extends Entity {
    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Question")
     */
    private $questions;

    public function __construct($name) {
        $this->name = $name;
        $this->questions = new ArrayCollection();
    }

    public function addQuestion(Question $question) {
        $this->questions->add($question);
    }

    public function removeQuestion(Question $question) {
        $this->questions->removeElement($question);
    }
}