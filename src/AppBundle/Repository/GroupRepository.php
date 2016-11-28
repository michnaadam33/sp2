<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Group;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GroupRepository extends EntityRepository
{
    /**
     * @param $groupKey
     * @return Group
     */
    public function findByGroupKey($groupKey){
        $group = $this->findOneBy(['groupKey' => $groupKey]);
        if(empty($group)){
            throw new NotFoundHttpException("Group on id: ".$groupKey." not found!");
        }
        return $group;
    }

}