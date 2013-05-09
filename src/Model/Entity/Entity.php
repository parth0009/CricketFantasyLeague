<?php

namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @MappedSuperclass
 */
class Entity
{	
	
	/**
	 * @Id
	 * @Column(type="integer");
	 * @GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	public function __get($name)
	{
		$method = 'get' . $name;
		if (method_exists($this, $method)) {
			return $this->$method;
		}
		return null;
	}
	
	public function __set($name, $value)
	{
		$method = 'set' . $name;
		if (method_exists($this, $method)) {
			return $this->$method($value);
		}
		throw new Exception("Trying to set value $value of $name property, which does not exist");
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


	
	
}