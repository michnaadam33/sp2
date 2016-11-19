<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="group")
 */
class Group
{

    public function __construct()
    {
        $this->key = $this->generateKey();
        $this->users = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $key;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var User[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User", mappedBy="group")
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
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return integer
     */
    private function generateKey(){
        $result = '';

        for($i = 0; $i < 8; $i++) {
            $result .= mt_rand(0, 9);
        }

        return (int)$result;
    }

}