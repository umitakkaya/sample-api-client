<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 22/09/15
 * Time: 14:32
 */

namespace DP\Model;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

class DoctorService extends AbstractErrorResponse
{
	/**
	 * @Type("integer")
	 * @Groups({"get", "post", "delete"})
	 */
	private $id;

	/**
	 * @Type("string")
	 * @Groups({"get"})
	 */
	private $name;

	/**
	 * @Type("float")
	 * @SerializedName("price_min")
	 * @Groups({"get", "patch", "post"})
	 */
	private $priceMin;

	/**
	 * @Type("float")
	 * @SerializedName("price_max")
	 * @Groups({"get", "patch", "post"})
	 */
	private $priceMax;

	/**
	 * @Type("integer")
	 * @SerializedName("service_id")
	 * @Groups({"get", "post"})
	 */
	private $serviceId;

	/**
	 * @Type("integer")
	 * @Groups({"put_slots"})
	 */
	private $duration;



	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 *
	 * @return $this
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @VirtualProperty
	 * @SerializedName("doctor_service_id")
	 * @Groups({"put_slots"})
	 *
	 * @return int
	 */
	public function getDoctorServiceId()
	{
		return $this->getId();
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
	 *
	 * @return $this
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return float
	 */
	public function getPriceMax()
	{
		return $this->priceMax;
	}

	/**
	 * @param float $priceMax
	 *
	 * @return $this
	 */
	public function setPriceMax($priceMax)
	{
		$this->priceMax = $priceMax;

		return $this;
	}

	/**
	 * @return float
	 */
	public function getPriceMin()
	{
		return $this->priceMin;
	}

	/**
	 * @param float $priceMin
	 *
	 * @return $this
	 */
	public function setPriceMin($priceMin)
	{
		$this->priceMin = $priceMin;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getServiceId()
	{
		return $this->serviceId;
	}

	/**
	 * @param int $serviceId
	 *
	 * @return $this
	 */
	public function setServiceId($serviceId)
	{
		$this->serviceId = $serviceId;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getDuration()
	{
		return $this->duration;
	}

	/**
	 * @param int $duration
	 *
	 * @return DoctorService
	 */
	public function setDuration($duration)
	{
		$this->duration = $duration;

		return $this;
	}



}