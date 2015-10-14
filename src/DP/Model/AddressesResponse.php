<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 22/09/15
 * Time: 12:58
 */

namespace DP\Model;

use JMS\Serializer\Annotation\Type;

class AddressesResponse extends AbstractErrorResponse
{
	/**
	 * @Type("array<DP\Model\Address>")
	 */
	private $_items;

	/**
	 * @return Address[]
	 */
	public function getItems()
	{
		return $this->_items;
	}

	/**
	 * @param Address []
	 */
	public function setItems($items)
	{
		$this->_items = $items;
	}
}