<?php

namespace Exam\DomainBundle\Entity\Test;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Exam\DomainBundle\Entity\Entity;
use Exam\DomainBundle\Entity\Test\Option;

/**
 * @ORM\Entity
 */
class Question extends Entity {
    /**
     * @ORM\ManyToMany(targetEntity="Option", cascade={"persist"}, inversedBy="questions")
     */
    private $options;

    /**
     * @ORM\ManyToOne(targetEntity="Option")
     */
    private $correctOption;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    public function __construct($description) {
        parent::__construct();
        $this->options = new ArrayCollection();

        $this->description = $description;
    }

    public function getOptions() {
        return $this->options;
    }

    public function addOption(Option $option) {
        $this->options->add($option);
    }

    public function removeOption(Option $option) {
        $this->options->remove($option);
    }

    public function setCorrectOption(Option $option) {
        if (!$this->options->indexOf($option)) {
            throw new \Exception("Option is not included in the selected question");
        }

        $this->correctOption = $option;
    }

    public function getCorrectOption() {
        return $this->correctOption;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDescription() {
        return $this->description;
    }
}