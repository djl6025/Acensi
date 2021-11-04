<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

class Student
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
    private $FirstName;

    /**
     * @var string
     * @ORM\Column(type="string", length=25)
     */
    private $LastName;

    /**
     * @var string
     * @ORM\Column(type="string", length=10)
     */
    private $NumEtud;

    /**
     * @ORM\ManyToOne(targetEntity="Entity\Department", inversedBy="students")
     */
    private $department;


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
    public function getFirstName()
    {
        return $this->FirstName;
    }

    /**
     * @param string $FirstName
     *
     * @return $this
     */
    public function setFirstName($FirstName)
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->LastName;
    }

    /**
     * @param string $LastName
     *
     * @return $this
     */
    public function setLastName($LastName)
    {
        $this->LastName = $LastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumEtud()
    {
        return $this->NumEtud;
    }

    /**
     * @param string $NumEtud
     *
     * @return $this
     */
    public function setNumEtud($NumEtud)
    {
        $this->NumEtud = $NumEtud;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param mixed $department
     */
    public function setDepartment($department) : self
    {
        $this->department = $department;

        return $this;
    }
}