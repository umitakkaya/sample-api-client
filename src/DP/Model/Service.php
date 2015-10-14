<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 22/09/15
 * Time: 13:00
 */

namespace DP\Model;

use JMS\Serializer\Annotation\Type;

class Service extends AbstractErrorResponse
{
	/**
	 * @Type("integer")
	 */
	private $id;

	/**
	 * @Type("string")
	 */
	private $name;

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}
}