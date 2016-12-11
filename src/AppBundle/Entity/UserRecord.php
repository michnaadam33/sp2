<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity()
 * @ORM\Table(name="sp_user_record")
 */
class UserRecord
{
    /**
     * @param $content
     * @return UserRecord
     */
    public static function createFromContent($content){
        $obj = new self();
        $obj->setValue($content->value);
        $obj->setCurrency($content->currency);
        $obj->setParticipation($content->participation);
        return $obj;
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
     * @var float
     * @ORM\Column(name="value", type="decimal", scale=2)
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string")
     */
    private $currency;

    /**
     * @var float
     *
     * @ORM\Column(name="participation", type="decimal", scale=2)
     */
    private $participation;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $user;

    /**
     * @var Record
     * @ORM\ManyToOne(targetEntity="Record", inversedBy="userRecords", cascade={"all"})
     */
    private $record;

    /**
     * @return integer
     */
    public function getId(){
        return $this->id;
    }
    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return float
     */
    public function getParticipation()
    {
        return $this->participation;
    }

    /**
     * @param float $participation
     */
    public function setParticipation($participation)
    {
        $this->participation = $participation;
    }


    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return Record
     */
    public function getRecord()
    {
        return $this->record;
    }

    /**
     * @param Record $record
     */
    public function setRecord($record)
    {
        $this->record = $record;
    }



}