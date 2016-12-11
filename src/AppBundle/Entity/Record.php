<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecordRepository")
 * @ORM\Table(name="sp_record")
 */
class Record
{
    /**
     * Record constructor.
     */
    public function __construct()
    {
        $this->userRecords = new ArrayCollection();
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    public function __toArray(){
        $users = [];
        foreach ($this->userRecords as $userRecord){
            $users[] = [
              'id' => $userRecord->getUser()->getId(),
                'value' => $userRecord->getValue(),
                'currency' => $userRecord->getCurrency(),
                'participation' => $userRecord->getParticipation()
            ];
        }
        $ret = [
            'id' => $this->id,
            'name' => $this->name,
            'coordinates' => [
                'lat' => $this->lat,
                'lon' => $this->lon
            ],
            'recordedDate' => [
                'timestamp' => $this->created->getTimestamp()
            ],
            'users' => $users
        ];
        return $ret;
    }

    /**
     * @param $content
     * @param Group $group
     * @return Record
     */
    public static function createRecordFromContent($content, Group $group){
        $record = new self();
        $record->setGroup($group);
        $record->setName($content->name);
        $record->setContentImage($content->contentImage);
        $record->setContentType($content->contentType);
        $record->setLat($content->coordinates->lat);
        $record->setLon($content->coordinates->lon);

        return $record;
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
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var float
     * @see https://developers.google.com/maps/documentation/javascript/mysql-to-maps
     *
     * @ORM\Column(name="lon", type="decimal", precision=10, scale=6)
     */
    private $lon;

    /**
     * @var float
     * @see https://developers.google.com/maps/documentation/javascript/mysql-to-maps
     *
     * @ORM\Column(name="lat", type="decimal", precision=10, scale=6)
     */
    private $lat;

    /**
     * @var string
     *
     * @ORM\Column(name="content_image", type="string")
     */
    private $contentImage;

    /**
     * @var string
     *
     * @ORM\Column(name="content_type", type="string")
     */
    private $contentType;

    /**
     * @var Group
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="records")
     */
    private $group;

    /**
     * @var UserRecord []
     *
     * @ORM\OneToMany(targetEntity="UserRecord", mappedBy="record", cascade={"all"})
     */
    private $userRecords;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
     * @return float
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * @param float $lon
     */
    public function setLon($lon)
    {
        $this->lon = $lon;
    }

    /**
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return string
     */
    public function getContentImage()
    {
        return $this->contentImage;
    }

    /**
     * @param string $contentImage
     */
    public function setContentImage($contentImage)
    {
        $this->contentImage = $contentImage;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param string $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
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

    /**
     * @return UserRecord[]|ArrayCollection
     */
    public function getUserRecords(){
        return $this->userRecords;
    }

    /**
     * @param UserRecord $userRecord
     */
    public function addUserRecords(UserRecord $userRecord){
        $this->userRecords->add($userRecord);
    }


}