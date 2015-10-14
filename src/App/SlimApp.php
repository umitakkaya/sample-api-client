<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 14/09/15
 * Time: 11:49
 */

namespace App;


use DP\Model\AbstractErrorResponse;
use Slim\Slim;

/**
 * @property SessionMiddleware $session
 */
class SlimApp extends Slim
{
	/**
	 * @param AbstractErrorResponse $response
	 */
	public function check(AbstractErrorResponse $response = null)
	{
		if($response->getError() !== null)
		{
			$this->error(new \Exception($response->getError()->getMessage(), $response->getError()->getCode()));
		}
	}
}