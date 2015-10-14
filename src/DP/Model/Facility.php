<?php

namespace DP\Model;

use JMS\Serializer\Annotation\Type;

/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 13/09/15
 * Time: 19:25
 */
class Facility extends AbstractErrorResponse
{
	/**
	 * @Type("integer")
	 */
	public $id;

	/**
	 * @Type("string")
	 */
	public $name;

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


}