<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 09/10/15
 * Time: 17:15
 */

namespace DP\Model;

use JMS\Serializer\Annotation\Type;

class PutSlotsRequest extends AbstractErrorResponse
{
	/**
	 * @Type("array<DP\Model\Slot>")
	 */
	private $slots;

	/**
	 * @return Slot[]
	 */
	public function getSlots()
	{
		return $this->slots;
	}

	/**
	 * @param Slot[] $slots
	 *
	 * @return PutSlotsRequest
	 */
	public function setSlots($slots)
	{
		$this->slots = $slots;

		return $this;
	}


}