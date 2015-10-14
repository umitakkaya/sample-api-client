<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 23/09/15
 * Time: 12:25
 */

namespace DP\Model;

use JMS\Serializer\Annotation\Type;

class NewDoctorService
{
	/**
	 * @Type("integer")
	 */
	private $id;

	/**
	 * @Type("float")
	 * @Ep
	 */
	private $priceMin;

	/**
	 * @Type("float")
	 */
	private $priceMax;

	/**
	 * @Type("integer")
	 */
	private $serviceId;

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
	 * @return float
	 */
	public function getPriceMax()
	{
		return $this->priceMax;
	}

	/**
	 * @param float $priceMax
	 */
	public function setPriceMax($priceMax)
	{
		$this->priceMax = $priceMax;
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
	 */
	public function setPriceMin($priceMin)
	{
		$this->priceMin = $priceMin;
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
	 */
	public function setServiceId($serviceId)
	{
		$this->serviceId = $serviceId;
	}
}
