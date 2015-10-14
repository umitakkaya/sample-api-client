<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 01/10/15
 * Time: 14:46
 */

namespace DP\Model;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;


class BookVisitResponse extends AbstractErrorResponse
{

	/**
	 * @Type("integer")
	 */
	private $id;

	/**
	 * @Type("string")
	 */
	private $status;

	/**
	 * @Type("DateTime<'Y-m-d\TH:i:sP'>")
	 * @SerializedName("start_at")
	 */
	private $startAt;

	/**
	 * @Type("DateTime<'Y-m-d\TH:i:sP'>")
	 * @SerializedName("end_at")
	 */
	private $endAt;

	/**
	 * @Type("integer")
	 */
	private $duration;

	/**
	 * @Type("string")
	 */
	private $bookedBy;

	/**
	 * @Type("string")
	 */
	private $comment;

	/**
	 * @Type("string")
	 * @SerializedName("canceled_by")
	 */
	private $canceledBy;

	/**
	 * @Type("DateTime<'Y-m-d\TH:i:sP'>")
	 * @SerializedName("booked_at")
	 */
	private $bookedAt;

	/**
	 * @Type("DateTime<'Y-m-d\TH:i:sP'>")
	 * @SerializedName("canceled_at")
	 */
	private $canceledAt;

	/**
	 * @Type("DP\Model\Patient")
	 */
	private $patient;

	/**
	 * @Type("DP\Model\DoctorService")
	 * @SerializedName("canceled_at")
	 */
	private $doctorService;


	/**
	 * @return \DateTime
	 */
	public function getBookedAt()
	{
		return $this->bookedAt;
	}

	/**
	 * @param \DateTime $bookedAt
	 *
	 * @return BookVisitResponse
	 */
	public function setBookedAt($bookedAt)
	{
		$this->bookedAt = $bookedAt;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * @param string $status
	 *
	 * @return BookVisitResponse
	 */
	public function setStatus($status)
	{
		$this->status = $status;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getBookedBy()
	{
		return $this->bookedBy;
	}

	/**
	 * @param string $bookedBy
	 *
	 * @return BookVisitResponse
	 */
	public function setBookedBy($bookedBy)
	{
		$this->bookedBy = $bookedBy;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getCanceledAt()
	{
		return $this->canceledAt;
	}

	/**
	 * @param \DateTime $canceledAt
	 *
	 * @return BookVisitResponse
	 */
	public function setCanceledAt($canceledAt)
	{
		$this->canceledAt = $canceledAt;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCanceledBy()
	{
		return $this->canceledBy;
	}

	/**
	 * @param string $canceledBy
	 *
	 * @return BookVisitResponse
	 */
	public function setCanceledBy($canceledBy)
	{
		$this->canceledBy = $canceledBy;

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
	 * @return BookVisitResponse
	 */
	public function setDuration($duration)
	{
		$this->duration = $duration;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getEndAt()
	{
		return $this->endAt;
	}

	/**
	 * @param \DateTime $endAt
	 *
	 * @return BookVisitResponse
	 */
	public function setEndAt($endAt)
	{
		$this->endAt = $endAt;

		return $this;
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
	 *
	 * @return BookVisitResponse
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @return Patient
	 */
	public function getPatient()
	{
		return $this->patient;
	}

	/**
	 * @param Patient $patient
	 *
	 * @return BookVisitResponse
	 */
	public function setPatient($patient)
	{
		$this->patient = $patient;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getStartAt()
	{
		return $this->startAt;
	}

	/**
	 * @param \DateTime $startAt
	 *
	 * @return BookVisitResponse
	 */
	public function setStartAt($startAt)
	{
		$this->startAt = $startAt;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getComment()
	{
		return $this->comment;
	}

	/**
	 * @param string $comment
	 *
	 * @return BookVisitResponse
	 */
	public function setComment($comment)
	{
		$this->comment = $comment;

		return $this;
	}

	/**
	 * @return DoctorService
	 */
	public function getDoctorService()
	{
		return $this->doctorService;
	}

	/**
	 * @param DoctorService $doctorService
	 *
	 * @return BookVisitResponse
	 */
	public function setDoctorService($doctorService)
	{
		$this->doctorService = $doctorService;

		return $this;
	}




}