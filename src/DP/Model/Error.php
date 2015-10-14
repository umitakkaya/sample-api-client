<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 24/09/15
 * Time: 10:58
 */

namespace DP\Model;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Accessor;

/**
 * @ExclusionPolicy("all")
 */
class Error
{

	/**
	 * @Type("array");
	 * @Expose
	 */
	private $errors;

	/**
	 * @Type("string")
	 * @Expose
	 */
	private $message;

	/**
	 * @Type("string")
	 * @Accessor(getter="getMessage",setter="setMessage")
	 */
	private $error;

	/**
	 * @Type("string")
	 * @Accessor(getter="getMessage",setter="setMessage")
	 * @Expose
	 */
	private $error_description;

	/** @var int */
	private $code;

	/**
	 * @return array
	 */
	public function getErrors()
	{

		return $this->errors;
	}

	/**
	 * @param array $errors
	 *
	 * @return $this
	 */
	public function setErrors($errors)
	{
		$this->errors = $errors;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getMessage()
	{
		return $this->message;
	}

	/**
	 * @param string $message
	 *
	 * @return $this
	 */
	public function setMessage($message)
	{
		$this->message = $message;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getCode()
	{
		return $this->code;
	}

	/**
	 * @param int $code
	 *
	 * @return $this
	 */
	public function setCode($code)
	{
		$this->code = $code;

		return $this;
	}




}