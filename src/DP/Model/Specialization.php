<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 21/09/15
 * Time: 17:59
 */

namespace DP\Model;

use JMS\Serializer\Annotation\Type;

class Specialization extends AbstractErrorResponse
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