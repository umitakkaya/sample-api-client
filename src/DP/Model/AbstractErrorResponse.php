<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 24/09/15
 * Time: 14:02
 */

namespace DP\Model;


abstract class AbstractErrorResponse
{
	/** @var Error */
	private $error;

	/**
	 * @return Error
	 */
	public function getError()
	{
		return $this->error;
	}

	/**
	 * @param Error $error
	 *
	 * @return $this
	 */
	public function setError(Error $error)
	{
		$this->error = $error;

		return $this;
	}
}