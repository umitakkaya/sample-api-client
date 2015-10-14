<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 25/09/15
 * Time: 13:26
 */

namespace DP\Model;

use JMS\Serializer\Annotation\Type;

class SlotsResponse extends AbstractErrorResponse
{
	/**
	 * @Type("array<DP\Model\Slot>")
	 */
	private $_items;

	/**
	 * @return Slot[]
	 */
	public function getItems()
	{
		return $this->_items;
	}

	/**
	 * @param Slot[]
	 */
	public function setItems($items)
	{
		$this->_items = $items;
	}
}