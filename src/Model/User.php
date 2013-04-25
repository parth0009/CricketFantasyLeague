<?php

namespace Model;

class User
{
	/**
	 * @var integer
	 */
	private $id;
	
	/**
	 * 
	 * @var string
	 */
	private $name;
	
	/**
	 * 
	 * @var Model\Avatar
	 */
	private $avatar;
	
	/*
	 * @var string
	 */
	private $login;
	
	public function __toString()
	{
		try {
			return $this->getName();
		} catch (Exception $exception) {
			return '?';
		}
	}
	
	public function __get($name)
	{
		
	}
	
	public function __set($name, $value)
	{
		
	}
	
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param integer $id
	 */
	public function setId($id) {
		$this->id = $id;
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
	public function setAvatar($avatar) {
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