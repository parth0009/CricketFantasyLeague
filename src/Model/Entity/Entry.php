<?php

namespace Model\Entity;

/**
 * Entry of a Team
 * 
 * Represents the Players a Team had for a given period of time (a week for example)
 * 
 * @Entity
 * @Table(name="teams")
 */
class Entry extends Team
{	
	/**
	 * Team entry phase
	 * 
	 * i.e. Phase 1, phase 2, etc. (week 1, week 2, etc.)
	 * @ORM\Column(type="integer")
	 */
	protected $phase;
	
	public function __toString()
	{
		try {
			return $this->getPhase();
		} catch (Exception $exception) {
			return '-';
		}
	}

	/**
	 * @return the $name
	 */
	public function getPhase() {
		return $this->phase;
	}

	/**
	 * @param integer $phase
	 */
	public function setPhase($phase) {
		$phase = (integer) $phase;
		if ($phase) {
			$this->phase = $phase;
		}
	}
}