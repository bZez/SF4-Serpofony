<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RankRepository")
 */
class Rank
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Group
     * @ORM\ManyToOne(targetEntity="Group",inversedBy="ranks")
     */
    private $group;

    /**
     * @var Target|null
     * @ORM\ManyToOne(targetEntity="Target",inversedBy="ranks")
     */
    private $target;

    /**
     * @var Search
     * @ORM\ManyToOne(targetEntity="Search",inversedBy="ranks")
     */
    private $search;

    /**
     * @ORM\Column(type="integer",length=6)
     */
    private $rank;

    /**
     * @ORM\Column(type="integer",length=6,nullable=true)
     */
    private $previous_rank;

    /**
     * @ORM\Column(type="integer",length=6,nullable=true)
     */
    private $diff;

    /**
     * @ORM\Column(type="string")
     */
    private $url;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Group
     */
    public function getGroup(): Group
    {
        return $this->group;
    }

    /**
     * @param Group $group
     */
    public function setGroup(Group $group): void
    {
        $this->group = $group;
    }

    /**
     * @return Target|null
     */
    public function getTarget(): ?Target
    {
        return $this->target;
    }


    /**
     * @param Target $target
     */
    public function setTarget(Target $target): void
    {
        $this->target = $target;
    }

    /**
     * @return Search
     */
    public function getSearch(): Search
    {
        return $this->search;
    }

    /**
     * @param Search $search
     */
    public function setSearch(Search $search): void
    {
        $this->search = $search;
    }

    /**
     * @return mixed
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param mixed $rank
     */
    public function setRank($rank): void
    {
        $this->rank = $rank;
    }

    /**
     * @return mixed
     */
    public function getPreviousRank()
    {
        return $this->previous_rank;
    }

    /**
     * @param mixed $previous_rank
     */
    public function setPreviousRank($previous_rank): void
    {
        $this->previous_rank = $previous_rank;
    }

    /**
     * @return mixed
     */
    public function getDiff()
    {
        return $this->diff;
    }

    /**
     * @param mixed $diff
     */
    public function setDiff($diff): void
    {
        $this->diff = $diff;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }


}
