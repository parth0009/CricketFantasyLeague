<?php

namespace Model\Entity;

/**
 * Entry of a Team
 * 
 * Represents the Players a Team had for a given period of time (a week for example)
 * 
 * @Entity
 * @Table(name="entries")
 */
class Entry extends Entity
{	
	
	/**
	 * Team that the Entry belongs to
	 * @OneToOne(targetEntity="Model\Entity\Team")
	 * @JoinColumn(name="team_id", referencedColumnName="id")
	 * @var Model\Entity\Team
	 */
	protected $team;
	
	/**
	 * First batsman
	 * @ManyToOne(targetEntity="Player")
	 * @var Model\Entity\Player
	 */
	//protected $batter1;
	
	/**
	 * Second batsman
	 * @ManyToOne(targetEntity="Player")
	 * @var Model\Entity\Player
	 */
	//protected $batter2;
	
	/**
	 * First bowler
	 * @ManyToOne(targetEntity="Player")
	 * @var Model\Entity\Player
	 */
	//protected $bowler1;
	
	/**
	 * Second bowler
	 * @ManyToOne(targetEntity="Player")
	 * @var Model\Entity\Player
	 */
	//protected $bowler2;
	
	/**
	 * All-rounder
	 * @ManyToOne(targetEntity="Player")
	 * @var Model\Entity\Player
	 */
	//protected $allround;
	
	/**
	 * Team entry week
	 * 
	 * i.e. week 1, week 2, etc.
	 * @ORM\Column(type="integer")
	 */
	protected $week;
	
	public function __toString()
	{
		try {
			return $this->getWeek();
		} catch (Exception $exception) {
			return '-';
		}
	}

	/**
	 * @return the $week
	 */
	public function getWeek() {
		return $this->week;
	}

	/**
	 * @param integer $week
	 */
	public function setWeek($week) {
		$week = (integer) $week;
		if ($week) {
			$this->week = $week;
		}
	}
}