<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Group;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserRepository extends EntityRepository
{
    /**
     * @param integer $groupId
     * @param integer $userId
     * @return User
     */
    public function findOneByIdAndGroup($userId, $groupId){
        $user = $this->findOneBy([
            'id'=>$userId,
            'group'=>$groupId
        ]);
        if(empty($user)){
            throw new NotFoundHttpException("Not Found user on id: ".$userId." and group id ". $groupId."!");
        }
        return $user;
    }

}