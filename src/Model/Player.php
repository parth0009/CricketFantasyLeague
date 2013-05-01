<?php

namespace Model;

/**
 * Player
 *
 * @ORM\Entity
 * @ORM\Table(name="players")
 */
final class Player extends User
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
	private static $types = array(
		self::TYPE_BOWLER,
		self::TYPE_BATTER,
		self::TYPE_ALLSTAR,
	);
	
	/**
	 * Team selection (1st team, 2nd team, 3rd team, etc.)
	 * @ORM\Column(type="integer")
	 * @var integer
	 */
	private $selection;
	
	/**
	 * Type of Player (bowler, batter or allstar)
	 * @ORM\Column(type="string")
	 */
	private $type;

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
	public function getAvatar() {
		return $this->avatar;
	}

	/**
	 * @param Avatar $avatar
	 */
	public function setAvatar(Avatar $avatar) {
		$this->avatar = $avatar;
	}

	/**
	 * @return the $login
	 */
	public function getLogin() {
		return $this->login;
	}

	/**
	 * @param field_type $login
	 */
	public function setLogin($login) {
		$this->login = $login;
	}

	
	
}