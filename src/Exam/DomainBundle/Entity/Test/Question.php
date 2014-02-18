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

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDescription() {
        return $this->description;
    }
}