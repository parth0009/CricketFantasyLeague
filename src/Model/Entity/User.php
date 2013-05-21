<?php

namespace Model\Entity;

//use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 * 
 * @Entity
 * @Table(name="users")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="type", type="string")
 * @DiscriminatorMap({"user" = "Model\Entity\User", "player" = "Model\Entity\Player", "admin" = "Model\Entity\Admin" })
 */
class User extends Entity implements UserInterface
{	
	/**
	 * Name of User
	 * @Column(type="string")
	 */
	protected $name;
	
	/**
	 * @ManyToOne(targetEntity="Model\Entity\Avatar")
	 * @var Model\Entity\Avatar
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
	
	/*
	 * Putting these properties in the parent class so that 
	 * can use single table inheritance (for simplicity)
	 */
	
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
	protected $role = 'user';
	
	/**
	 * 
	 * @OneToOne(targetEntity="Model\Entity\Team", mappedBy="user")
	 */
	protected $team;
	
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
	/*public function getPassword() {
		return null;
	}*/
	
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
	 * @return $team|null
	 */
	public function getTeam() {
		return $this->team;
	}
	
	/**
	 * @param Model\Entity\Team $team
	 */
	public function setTeam(Model\Entity\Team $team) {
		$this->team = $team;
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
	
	/**
	 * Returns the roles granted to the user.
	 *
	 * <code>
	 * public function getRoles()
	 * {
	 *     return array('ROLE_USER');
	 * }
	 * </code>
	 *
	 * Alternatively, the roles might be stored on a ``roles`` property,
	 * and populated in any number of different ways when the user object
	 * is created.
	 *
	 * @return Role[] The user roles
	 */
	public function getRoles()
	{
		return array((string) $this->role);
	}
	
	/**
	 * Returns the password used to authenticate the user.
	 *
	 * This should be the encoded password. On authentication, a plain-text
	 * password will be salted, encoded, and then compared to this value.
	 *
	 * @return string The password
	*/
	public function getPassword()
	{
		return $this->password;
	}
	
	/**
	 * Returns the salt that was originally used to encode the password.
	 *
	 * This can return null if the password was not encoded using a salt.
	 *
	 * @return string The salt
	*/
	public function getSalt()
	{
		return null;
	}
	
	/**
	 * Returns the username used to authenticate the user.
	 *
	 * @return string The username
	*/
	public function getUsername()
	{
		return $this->getLogin();
	}
	
	/**
	 * Removes sensitive data from the user.
	 *
	 * This is important if, at any given point, sensitive information like
	 * the plain-text password is stored on this object.
	 *
	 * @return void
	*/
	public function eraseCredentials() {}

	

}