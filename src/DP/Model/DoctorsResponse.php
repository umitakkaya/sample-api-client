<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 21/09/15
 * Time: 17:52
 */

namespace DP\Model;

use JMS\Serializer\Annotation\Type;

class DoctorsResponse extends AbstractErrorResponse
{
	/**
	 * @Type("array<DP\Model\Doctor>")
	 */
	private $_items;

	/**
	 * @return Doctor[]
	 */
	public function getItems()
	{
		return $this->_items;
	}

	/**
	 * @param Doctor[]
	 */
	public function setItems($items)
	{
		$this->_items = $items;
	}
}