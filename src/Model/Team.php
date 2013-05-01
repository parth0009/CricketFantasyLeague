<?php

namespace Model;

/**
 * Team
 *
 * @ORM\Entity
 * @ORM\Table(name="teams")
 */
class Team extends Entity
{	
	/**
	 * Name of User
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
	 * Login (username)
	 * @ORM\Column(type="string")
	 */
	protected $login;
	
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