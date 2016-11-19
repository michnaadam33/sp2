<?php

namespace AppBundle\Utils;


use AppBundle\Repository\GroupRepository;

class KeyGenerator
{
    /**
     * @var GroupRepository
     */
    private $groupRepository;

    /**
     * KeyGenerator constructor.
     * @param GroupRepository $groupRepository
     */
    public function __construct(
        GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function generateUniqueKey()
    {
        $result = '';

        for ($i = 0; $i < 8; $i++) {
            $result .= mt_rand(0, 9);
        }

        return (int)$result;
    }
}