<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 14/09/15
 * Time: 11:01
 */

namespace App;


use Slim\Middleware;

class SessionMiddleware extends Middleware
{
	/**
	 * Call
	 *
	 * Perform actions specific to this middleware and optionally
	 * call the next downstream middleware.
	 */
	public function call()
	{
		/** @var SlimApp $app */
		$app = $this->app;
		$app->session = $this;

		$this->next->call();
	}

	/**
	 * Session constructor.
	 */
	public function __construct()
	{
	}

	/**
	 * Retrieve item from session
	 *
	 * @param string      $key
	 * @param mixed|null $default
	 *
	 * @return mixed|null|$default
	 */
	public function get($key, $default = null)
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
	}

	/**
	 * Add item to session
	 *
	 * @param $key
	 * @param $value
	 */
	public function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	/**
	 * Remove item from session
	 * @param $key
	 */
	public function remove($key)
	{
		unset($_SESSION[$key]);
	}

	public function clear()
	{
		session_unset();
	}

}