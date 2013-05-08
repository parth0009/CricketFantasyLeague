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
	public function getPath() {
		return $this->name;
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