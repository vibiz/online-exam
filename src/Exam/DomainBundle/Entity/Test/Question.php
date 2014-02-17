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
     * @ORM\OneToMany(targetEntity="Exam\DomainBundle\Entity\Test\Option", mappedBy="id")
     */
    private $options;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    public function __construct($description) {
        $this->options = new ArrayCollection();

        $this->description = $description;
    }

    public function addOption(Option $option) {
        $this->options->add($option);
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDescription() {
        return $this->description;
    }
}