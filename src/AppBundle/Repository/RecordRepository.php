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

    /**
     * @param int $groupId
     * @param string $order
     * @return array
     */
    public function findByGroupIdAsArray($groupId, $order = 'ASC'){
        $qb = $this->createQueryBuilder('r');
        $qb->where('r.group = :group');
        $qb->orderBy('r.created', $order);
        $qb->setParameter('group', $groupId);
        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param int $groupId
     * @param string $order
     * @return array
     */
    public function findByGroupId($groupId, $order = 'ASC'){
        $qb = $this->createQueryBuilder('r');
        $qb->where('r.group = :group');
        $qb->orderBy('r.created', $order);
        $qb->setParameter('group', $groupId);
        return $qb->getQuery()->getResult();
    }

}