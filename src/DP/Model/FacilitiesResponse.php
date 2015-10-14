<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 21/09/15
 * Time: 14:08
 */

namespace DP\Model;

use JMS\Serializer\Annotation\Type;

class FacilitiesResponse extends AbstractErrorResponse
{
	/**
	 * @Type("array<DP\Model\Facility>")
	 */
	private $_items;

	/**
	 * @return Facility[]
	 */
	public function getItems()
	{
		return $this->_items;
	}

	/**
	 * @param Facility[]
	 */
	public function setItems($items)
	{
		$this->_items = $items;
	}
}