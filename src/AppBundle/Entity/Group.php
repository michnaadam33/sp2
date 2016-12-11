<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GroupRepository")
 * @ORM\Table(name="sp_group")
 */
class Group
{

    /**
     * Group constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->records = new ArrayCollection();
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdated(new \DateTime());

        if($this->getCreated() == null)
        {
            $this->created = new \DateTime();
        }
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="group_key", unique=true)
     */
    private $groupKey;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var User[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User", mappedBy="group", cascade="persist")
     */
    private $users;

    /**
     * @var Record[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Record", mappedBy="group", cascade="persist")
     */
    private $records;

    /**
     * @var \DateTime $created
     *
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $created
     *
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return User[]
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param User $user
     */
    public function addUser(User $user)
    {
        $this->users->add($user);
    }

    public function getRecordsAsArray(){
        $ret = [];
        foreach ($this->records as $record){
            $ret[] = $record-> __toArray();
        }
        return $ret;
    }

    public function addRecord(Record $record){
        $this->records->add($record);
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $groupKey
     */
    public function setGroupKey($groupKey){
        $this->groupKey = $groupKey;
    }

    /**
     * @return int
     */
    public function getGroupKey(){
        return $this->groupKey;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(){
        return $this->created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated(){
        return $this->updated;
    }


    /**
     * @param \DateTime $updated
     */
    public function setUpdated($updated){
        $this->updated = $updated;
    }

}