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
	 * @ManyToMany(targetEntity="Entry")
	 * @JoinTable(name="user_groups",
	 *      joinColumns={@JoinColumn(name="team_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@JoinColumn(name="group_id", referencedColumnName="id")} 
 	 * )
	 */
	
	
	protected $entries;
	
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
	
	/**
	 * @return the $login
	 */
	public function getUser() {
		return $this->user;
	}
	
	/**
	 * @param field_type $login
	 */
	public function setUser(Model\Entity\User $user) {
		$this->user = $user;
	}
	
	/**
	 * @return the $login
	 */
	public function getEntries() {
		return $this->entries;
	}
	
	/**
	 * @param field_type $login
	 */
	public function setEntries(array $entries) {
		$this->entries = $entries;
	}
	
	public function addEntry(Model\Entity\Entry $entry)
	{
		$entryId = $entry->id;
		$this->entries[(integer) $entryId] = $entry;
	}

	
	
}