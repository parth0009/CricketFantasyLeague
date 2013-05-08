<?php

namespace Model\Entity;

/**
 * User
 *
 * @Entity
 * @Table(name="users")
 */
class User extends Entity
{	
	/**
	 * Name of User
	 * @Column(type="string")
	 */
	protected $name;
	
	/**
	 * @ManyToOne(targetEntity="Avatar")
	 * @var Model\Avatar
	 */
	protected $avatar;
	
	/**
	 * Login (username)
	 * @Column(type="string")
	 */
	protected $login;
	
	/**
	 * Password
	 * @Column(type="string")
	 */
	protected $password;
	
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
	 * @return the $name
	 */
	public function getPassword() {
		return null;
	}
	
	/**
	 * @param string $name
	 */
	public function setPassword($password) {
		$this->password = $password;
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