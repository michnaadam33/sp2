<?php

namespace AppBundle\Entity;


class Summary
{
    /**
     * Summary constructor.
     * @param int $cost
     * @param array $userSummary
     */
    public function __construct($cost, array $userSummary)
    {
        $this->cost = $cost;
        $this->userSummary = $userSummary;
    }

    /**
     * @var float
     */
    private $cost;

    /**
     * @var array
     */
    private $userSummary;

    /**
     * @return float
     */
    public function getCost(){
        return $this->cost;
    }

    /**
     * @return array
     */
    public function getUsersSummary(){
        return $this->userSummary;
    }

}