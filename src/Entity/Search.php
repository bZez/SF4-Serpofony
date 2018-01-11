<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SearchRepository")
 */
class Search
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $keyword;

    /**
     * @ORM\Column(type="text", length=2,nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="text", length=64,nullable=true)
     */
    private $datacenter;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $device;

    /**
     * @ORM\Column(type="text", length=64,nullable=true)
     */
    private $local;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private $parameters;

    /**
     * @var Group
     * @ORM\ManyToOne(targetEntity="Group",inversedBy="targets")
     */
    private $group;

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
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * @param mixed $keyword
     */
    public function setKeyword($keyword): void
    {
        $this->keyword = $keyword;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getDatacenter()
    {
        return $this->datacenter;
    }

    /**
     * @param mixed $datacenter
     */
    public function setDatacenter($datacenter): void
    {
        $this->datacenter = $datacenter;
    }

    /**
     * @return mixed
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * @param mixed $device
     */
    public function setDevice($device): void
    {
        $this->device = $device;
    }

    /**
     * @return mixed
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * @param mixed $local
     */
    public function setLocal($local): void
    {
        $this->local = $local;
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param mixed $parameters
     */
    public function setParameters($parameters): void
    {
        $this->parameters = $parameters;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     */
    public function setGroup(Group $group): void
    {
        $this->group = $group;
        $group->addSearch($this);
    }

}
