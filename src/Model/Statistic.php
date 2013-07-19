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
    	$q = $em->createQuery("select u from MyDomain\Model\User u where u.age >=
		20 and u.age <= 30");
    	$users = $q->getResult();
    	
    	
    	"SELECT ((SELECT COUNT(batter1_id) FROM entries WHERE batter1_id = 4) + (SELECT COUNT(batter2_id) FROM entries WHERE batter2_id = 4)) AS entry_count";
    	
    }

}