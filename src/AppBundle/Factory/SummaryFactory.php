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
        $parts = 0;
        $costUsers = [];
        $records = $this->recordRepository->findByGroupId($group->getId());

        foreach ($group->getUsers() as $user){
            $costUsers[$user->getId()] = [
                'spend' => 0,
                'participation' => 0
            ];
        }

        foreach ($records as $record){
            /** @var UserRecord $userRecord */
            foreach ($record->getUserRecords() as $userRecord){
                $cost += $userRecord->getValue();
                $parts += $userRecord->getParticipation();
                $costUsers[$userRecord->getUser()->getId()]['spend'] += $userRecord->getValue();
                $costUsers[$userRecord->getUser()->getId()]['participation'] += $userRecord->getParticipation();
            }
        }
        $userSummary = [];
        foreach ($costUsers as $key => $costUser ){
            $realToPay = $this->getRealCostUser($costUser['participation'],$parts,$cost);
            $toPay = ($realToPay > $costUser['spend']) ? round($realToPay - $costUser['spend'], 2) : 0;
            $overpayment = ($costUser['spend'] > $realToPay) ? round( $costUser['spend'] - $realToPay,2) : 0;

            $userSummary[$key] = [
                'toPay' => $toPay,
                'overpayment' => $overpayment
            ];
        }
        return new Summary($cost, $userSummary);
    }

    /**
     * @param int $userPart
     * @param int $parts
     * @param int $cost
     * @return float|int
     */
    private function getRealCostUser($userPart, $parts, $cost){
        if($parts == 0){
            return 0;
        }
        return ($userPart/$parts)*$cost;
    }

}