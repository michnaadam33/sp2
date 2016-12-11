<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Group;
use AppBundle\Entity\Record;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RecordRepository extends EntityRepository
{
    /**
     * @param integer $recordId
     * @param integer $groupId
     * @return Record
     */
    public function findOneByIdAndGroup($recordId, $groupId){
        $record = $this->findOneBy([
            'id'=>$recordId,
            'group'=>$groupId
        ]);
        if(empty($record)){
            throw new NotFoundHttpException("Not Found record on id: ".$recordId." and group id ". $groupId."!");
        }
        return $record;
    }

}