<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 21/09/15
 * Time: 17:52
 */

namespace DP\Model;

use JMS\Serializer\Annotation\Type;

class Doctor extends AbstractErrorResponse
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
	 * @Type("string")
	 */
	private $surname;

	/**
	 * @Type("array<DP\Model\Specialization>")
	 */
	private $specializations;

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

	/**
	 * @return Specialization[]
	 */
	public function getSpecializations()
	{
		return $this->specializations;
	}

	/**
	 * @param Specialization[] $specializations
	 */
	public function setSpecializations($specializations)
	{
		$this->specializations = $specializations;
	}

	/**
	 * @return string
	 */
	public function getSurname()
	{
		return $this->surname;
	}

	/**
	 * @param string $surname
	 */
	public function setSurname($surname)
	{
		$this->surname = $surname;
	}


}