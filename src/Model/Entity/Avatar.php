<?php

namespace Model\Entity;

/**
 * Avatar
 *
 * @Entity
 * @Table(name="avatars")
 */
class Avatar extends Entity
{
	/**
	 * Name of Avatar
	 * @Column(type="string")
	 */
	protected $name;
	
	/**
	 * @Column(type="string")
	 */
	private $path;
	
	public function __toString()
	{
		try {
			return '<img src="' . $this->getPath() ." />";
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
	public function getPath() {
		return $this->path;
	}

	/**
	 * @param string $path
	 */
	public function setPath($path) {
		if (file_exists($path)) {
			$this->path = $path;
		}
	}
	
}