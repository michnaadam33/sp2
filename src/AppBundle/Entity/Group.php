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

}