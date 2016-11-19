<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="sp_user")
 */
class User
{

    /**
     * User constructor.
     * @param string $login
     */
    public function __construct($login)
    {
        $this->login = $login;
    }

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $login;

    /**
     * @var Group
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Group", inversedBy="users", cascade="persist")
     */
    private $group;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string$login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param Group $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

}