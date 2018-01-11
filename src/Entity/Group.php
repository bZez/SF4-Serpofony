<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupRepository")
 * @ORM\Table(name="`group`")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer",nullable=true)
     * @Assert\Length(max=11)
     */
    private $module_id;

    /**
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Target",mappedBy="group",cascade={"persist", "remove"})
     */
    private $targets;

    /**
     * @ORM\OneToMany(targetEntity="Search",mappedBy="group",cascade={"persist", "remove"})
     */
    private $searches;

    public function __construct()
    {
        $this->targets = new ArrayCollection();
        $this->searches = new ArrayCollection();
    }

    public function addTarget(Target $target)
    {
        if (!$this->targets->contains($target))
            $this->targets->add($target);
    }

    public function addSearch(Search $search)
    {
        if (!$this->searches->contains($search))
            $this->searches->add($search);
    }

    public function getTargets()
    {
        return $this->targets->toArray();
    }

    public function getSearches()
    {
        return $this->searches->toArray();
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getModuleId()
    {
        return $this->module_id;
    }

    /**
     * @param mixed $module_id
     */
    public function setModuleId($module_id): void
    {
        $this->module_id = $module_id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }


}
