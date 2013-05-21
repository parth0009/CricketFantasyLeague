<?php

namespace Model\Entity;

/**
 * Player
 *
 * @Entity
 */
class Player extends User
{	
	/**
	 * 
	 * @var string
	 */
	const TYPE_BOWLER = 'bowler';
	
	/**
	 * 
	 * @var string
	 */
	const TYPE_BATTER = 'batter';
	
	/**
	 * 
	 * @var string
	 */
	const TYPE_ALLSTAR = 'allstar';
	
	/**
	 * Types that the Player could be
	 * @var string[]
	 */
	private static $skills = array(
		self::TYPE_BOWLER,
		self::TYPE_BATTER,
		self::TYPE_ALLSTAR,
	);
	
	/**
	 * Team selection (1st team, 2nd team, 3rd team, etc.)
	 * @Column(type="integer")
	 * @var integer
	 */
	private $selection;
	
	/**
	 * Skill of Player (bowler, batter or allstar)
	 * @Column(type="string")
	 */
	private $skill;
	
	/**
	 * ACL role
	 * @var string
	 */
	protected $role = 'player';

	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return the $avatar
	 */
	public function getSkill() {
		return $this->skill;
	}

	/**
	 * @param Avatar $avatar
	 */
	public function setSkill($skill) {
		if (in_array((string) $skill, static::$skills)) {
			$this->skill = $skill;
		}
	}

	/**
	 * @return the $login
	 */
	public function getSelection() {
		return (integer) $this->selection;
	}

	/**
	 * @param field_type $login
	 */
	public function setSelection($selection) {
		$this->selection = (integer) $selection;
	}

	
	
}