<?php

namespace AppBundle\Factory;

use AppBundle\Entity\Group;
use AppBundle\Entity\Summary;
use AppBundle\Entity\UserRecord;
use AppBundle\Repository\RecordRepository;

class SummaryFactory
{
    /**
     * @var RecordRepository
     */
    private $recordRepository;

    public function __construct(
        RecordRepository $recordRepository
    ){
        $this->recordRepository = $recordRepository;
    }

    /**
     * @param Group $group
     * @return Summary
     */
    public function createSummary(Group $group){
        $cost = 0;
        $costUser = [];
        $userSummary = [];
        $records = $this->recordRepository->findByGroupId($group->getId());

        foreach ($group->getUsers() as $user){
            $costUser[$user->getId()] = [
                'spend' => 0,
                'participation' => 0
            ];
        }

        foreach ($records as $record){
            /** @var UserRecord $userRecord */
            foreach ($record->getUserRecords() as $userRecord){
                $cost += $userRecord->getValue();
                $costUser[$userRecord->getUser()->getId()]['spend'] += $userRecord->getValue();
                $costUser[$userRecord->getUser()->getId()]['participation'] += $userRecord->getParticipation();
            }
        }

        //todo
        $userSummary = $costUser;
        return new Summary($cost, $userSummary);
    }

}