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
	 * @Column(type="string")
	 */
	protected $name;
	
	/**
	 * User that the Team belongs to
     * @OneToOne(targetEntity="Model\Entity\User")
	 * @JoinColumn(name="user_id", referencedColumnName="id")
	 * @var Model\Entity\User
	 */
	protected $user;
	
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