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
	 * @ManyToOne(targetEntity="Model\Entity\Team")
	 * @JoinColumn(name="team_id", referencedColumnName="id")
	 * @var Model\Entity\Team
	 */
	protected $team;

    /**
     * Week of Entry
     * @Column(type="integer")
     * @var integer
     */
    protected $week;
	
	/**
	 * First batsman
	 * @ManyToOne(targetEntity="Model\Entity\User")
     * @JoinColumn(name="batter1_id", referencedColumnName="id")
	 * @var Model\Entity\Player
	 */
	protected $batter1;
	
	/**
	 * Second batsman
	 * @ManyToOne(targetEntity="Model\Entity\User")
     * @JoinColumn(name="batter2_id", referencedColumnName="id")
	 * @var Model\Entity\Player
	 */
	protected $batter2;
	
	/**
	 * First bowler
	 * @ManyToOne(targetEntity="Model\Entity\User")
     * @JoinColumn(name="bowler1_id", referencedColumnName="id")
	 * @var Model\Entity\Player
	 */
	protected $bowler1;
	
	/**
	 * Second bowler
	 * @ManyToOne(targetEntity="Model\Entity\User")
     * @JoinColumn(name="bowler2_id", referencedColumnName="id")
	 * @var Model\Entity\Player
	 */
	protected $bowler2;
	
	/**
	 * All-rounder
	 * @ManyToOne(targetEntity="Model\Entity\User")
     * @JoinColumn(name="allstar_id", referencedColumnName="id")
	 * @var Model\Entity\Player
	 */
	protected $allstar;
	
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

    /**
     * @return Model\Entity\Player $batter1 1st batsman of the Team for this Entry
     */
    public function getBatter1() {
        return $this->batter1;
    }

    /**
     * @param Model\Entity\Player $batter1 1st batmsn of the Team for this Entry
     */
    public function setBatter1(Model\Entity\Player $player) {
        $this->batter1 = $player;
    }

    /**
     * @return Model\Entity\Player $batter1 1st batsman of the Team for this Entry
     */
    public function getBatter2() {
        return $this->batter2;
    }

    /**
     * @param Model\Entity\Player $batter1 1st batmsn of the Team for this Entry
     */
    public function setBatter2(Model\Entity\Player $player) {
        $this->batter2 = $player;
    }

    /**
     * @return Model\Entity\Player $batter1 1st batsman of the Team for this Entry
     */
    public function getBowler1() {
        return $this->bowler1;
    }

    /**
     * @param Model\Entity\Player $batter1 1st batmsn of the Team for this Entry
     */
    public function setBowler1(Model\Entity\Player $player) {
        $this->bowler1 = $player;
    }

    /**
     * @return Model\Entity\Player $batter1 1st batsman of the Team for this Entry
     */
    public function getBowler2() {
        return $this->bowler2;
    }

    /**
     * @param Model\Entity\Player $batter1 1st batmsn of the Team for this Entry
     */
    public function setBowler2(Model\Entity\Player $player) {
        $this->bowler2 = $player;
    }

    /**
     * @return Model\Entity\Player $batter1 1st batsman of the Team for this Entry
     */
    public function getAllstar() {
        return $this->allstar;
    }

    /**
     * @param Model\Entity\Player $batter1 1st batmsn of the Team for this Entry
     */
    public function setAllstar(Model\Entity\Player $player) {
        $this->allstar = $player;
    }
}