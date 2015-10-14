<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 22/09/15
 * Time: 13:01
 */

namespace DP\Model;

use JMS\Serializer\Annotation\Type;

class ServicesResponse extends AbstractErrorResponse
{
	/**
	 * @Type("array<DP\Model\Service>")
	 */
	private $_items;

	/**
	 * @return Service[]
	 */
	public function getItems()
	{
		return $this->_items;
	}

	/**
	 * @param Service []
	 */
	public function setItems($items)
	{
		$this->_items = $items;
	}
}
