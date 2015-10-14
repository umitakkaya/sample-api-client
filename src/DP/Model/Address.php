<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 22/09/15
 * Time: 12:54
 */

namespace DP\Model;

use JMS\Serializer\Annotation\Type;

class Address extends AbstractErrorResponse
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
	private $postCode;

	/**
	 * @Type("string")
	 */
	private $street;

	/**
	 * @Type("DP\Model\BookingExtraFields")
	 */
	private $bookingExtraFields;

	/**
	 * @return BookingExtraFields
	 */
	public function getBookingExtraFields()
	{
		return $this->bookingExtraFields;
	}

	/**
	 * @param BookingExtraFields $bookingExtraFields
	 */
	public function setBookingExtraFields($bookingExtraFields)
	{
		$this->bookingExtraFields = $bookingExtraFields;
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
	 * @return string
	 */
	public function getPostCode()
	{
		return $this->postCode;
	}

	/**
	 * @param string $postCode
	 */
	public function setPostCode($postCode)
	{
		$this->postCode = $postCode;
	}

	/**
	 * @return string
	 */
	public function getStreet()
	{
		return $this->street;
	}

	/**
	 * @param string $street
	 */
	public function setStreet($street)
	{
		$this->street = $street;
	}


}