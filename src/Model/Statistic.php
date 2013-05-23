<?php

namespace Model;

class Statistic
{
    /**
     * @var
     */
    protected $week;

    public static function getStatisticsWithPlayer(Entity\User $player, $entityManager)
    {
        return array(new self());
    }

}