<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Department
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=25)
     */
    private $Name;

    /**
     * @var int
     * @ORM\Column(type="string", length=10)
     */
    private $Capacity;

    /**
     * @ORM\OneToMany(targetEntity="src\Entity\Student", mappedBy="department")
     */
    private $students;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param string $Name
     *
     * @return $this
     */
    public function setName($Name)
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return int
     */
    public function getCapacity()
    {
        return $this->Capacity;
    }

    /**
     * @param int $Capacity
     *
     * @return $this
     */
    public function setCapacity($Capacity)
    {
        $this->Capacity = $Capacity;

        return $this;
    }

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    public function getStudents()
    {
        return $this->students;
    }
}