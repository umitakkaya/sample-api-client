<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 25/09/15
 * Time: 13:26
 */

namespace DP\Model;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;


class Slot
{
	/**
	 * @Type("DateTime<'Y-m-d\TH:i:sP'>")
	 */
	private $start;

	/**
	 * @Type("DateTime<'Y-m-d\TH:i:sP'>")
	 */
	private $end;

	/**
	 * @Type("array<DP\Model\DoctorService>")
	 * @SerializedName("doctor_services")
	 */
	private $doctorServices;

	/**
	 * @return \DateTime
	 */
	public function getStart()
	{
		return $this->start;
	}

	/**
	 * @param \DateTime $start
	 */
	public function setStart($start)
	{
		$this->start = $start;
	}

	/**
	 * @return \DateTime
	 */
	public function getEnd()
	{
		return $this->end;
	}

	/**
	 * @param \DateTime  $end
	 */
	public function setEnd($end)
	{
		$this->end = $end;
	}

	/**
	 * @return DoctorService[]
	 */
	public function getDoctorServices()
	{
		return $this->doctorServices;
	}

	/**
	 * @param DoctorService[] $doctorServices
	 *
	 * @return Slot
	 */
	public function setDoctorServices($doctorServices)
	{
		$this->doctorServices = $doctorServices;

		return $this;
	}

}