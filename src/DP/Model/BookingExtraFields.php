<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 22/09/15
 * Time: 12:55
 */

namespace DP\Model;
use JMS\Serializer\Annotation\Type;


class BookingExtraFields
{
	/**
	 * @Type("boolean")
	 */
	private $birthDate;

	/**
	 * @Type("boolean")
	 */
	private $gender;

	/**
	 * @Type("boolean")
	 */
	private $nin;

	/**
	 * @return boolean
	 */
	public function isBirthDate()
	{
		return $this->birthDate;
	}

	/**
	 * @param boolean $birthDate
	 */
	public function setBirthDate($birthDate)
	{
		$this->birthDate = $birthDate;
	}

	/**
	 * @return boolean
	 */
	public function isGender()
	{
		return $this->gender;
	}

	/**
	 * @param boolean $gender
	 */
	public function setGender($gender)
	{
		$this->gender = $gender;
	}

	/**
	 * @return boolean
	 */
	public function isNin()
	{
		return $this->nin;
	}

	/**
	 * @param boolean $nin
	 */
	public function setNin($nin)
	{
		$this->nin = $nin;
	}


}