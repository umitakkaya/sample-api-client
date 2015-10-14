<?php

namespace DP\Model;

use JMS\Serializer\Annotation\Type;

class BookingsResponse extends AbstractErrorResponse
{
	/**
	 * @Type("array<DP\Model\Booking>")
	 */
	private $_items;

	/**
	 * @return Booking[]
	 */
	public function getItems()
	{
		return $this->_items;
	}

	/**
	 * @param Booking[]
	 */
	public function setItems($items)
	{
		$this->_items = $items;
	}
}