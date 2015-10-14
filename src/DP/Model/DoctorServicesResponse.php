<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 22/09/15
 * Time: 14:34
 */

namespace DP\Model;

use JMS\Serializer\Annotation\Type;

class DoctorServicesResponse extends AbstractErrorResponse
{
	/**
	 * @Type("array<DP\Model\DoctorService>")
	 */
	private $_items;

	/**
	 * @return DoctorService[]
	 */
	public function getItems()
	{
		return $this->_items;
	}

	/**
	 * @param DoctorService[]
	 */
	public function setItems($items)
	{
		$this->_items = $items;
	}
}