<?php

namespace Model\Entity;

/**
 * Team
 *
 * @Entity
 * @Table(name="teams")
 */
class Team extends Entity
{	
	/**
	 * Name of Team
	 * @ORM\Column(type="string")
	 */
	protected $name;
	
	/**
	 * User that the Team belongs to
	 * @ORM\ManyToOne(targetEntity="User")
	 * @var Model\User
	 */
	protected $user;
	
	/**
	 * First batsman
	 * @ORM\ManyToOne(targetEntity="Player")
	 * @var Model\Player
	 */
	protected $batter1;
	
	/**
	 * Second batsman
	 * @ORM\ManyToOne(targetEntity="Player")
	 * @var Model\Player
	 */
	protected $batter2;
	
	/**
	 * First bowler
	 * @ORM\ManyToOne(targetEntity="Player")
	 * @var Model\Player
	 */
	protected $bowler1;
	
	/**
	 * Second bowler
	 * @ORM\ManyToOne(targetEntity="Player")
	 * @var Model\Player
	 */
	protected $bowler2;
	
	/**
	 * All-rounder
	 * @ORM\ManyToOne(targetEntity="Player")
	 * @var Model\Player
	 */
	protected $allround;
	
	/**
	 * @ManyToMany(targetEntity="Entry")
	 * @JoinTable(name="user_groups",
	 *      joinColumns={@JoinColumn(name="team_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@JoinColumn(name="group_id", referencedColumnName="id")} 
 	 * )
	 */
	//protected $entries;
	
	public function __toString()
	{
		try {
			return $this->getName();
		} catch (Exception $exception) {
			return '?';
		}
	}

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