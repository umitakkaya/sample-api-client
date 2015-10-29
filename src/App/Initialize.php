<?php

namespace App;

use Doctrine\Common\Annotations\AnnotationRegistry;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Slim\Middleware\SessionCookie;
use Slim\Views\Blade;

/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 14/09/15
 * Time: 10:41
 */
class Initialize
{
	/** @var SlimApp */
	private $app;

	/** @var Serializer */
	private $serializer;

	/** @var bool */
	private $debug = true;

	/** @var string */
	private $cacheDir;

	/** @var string */
	private $metadataDir;

	/**
	 * App Initalize constructor.
	 */
	public function __construct()
	{
		$this->cacheDir    = dirname(dirname(__DIR__)) . '/cache';
		$this->metadataDir = dirname(__DIR__) . '/Resources/Metadata';

		$this->initApp();
		$this->initSession();
		$this->initViewEngine();
		$this->initSerializer();
		$this->initAnnotations();

	}

	/**
	 * @return SlimApp
	 */
	public function getApp()
	{
		return $this->app;
	}

	/**
	 * @return Serializer
	 */
	public function getSerializer()
	{
		return $this->serializer;
	}

	/**
	 * @return string
	 */
	public function getMetadataDir()
	{
		return $this->metadataDir;
	}

	/**
	 * @return string
	 */
	public function getCacheDir()
	{
		return $this->cacheDir;
	}

	/**
	 * Initialize Blade Template Engine
	 */
	private function initViewEngine()
	{
		$view = $this->app->view();

		$view->parserOptions = [
			'debug' => true,
			'cache' => $this->cacheDir
		];
	}

	/**
	 * Initalize Slim Application
	 */
	private function initApp()
	{
		$this->app = new SlimApp([
			'view'                => new Blade(),
			'templates.path'      => '../templates',
			'cookies.encrypt'     => true,
			'cookies.secret_key'  => 'my_very_secret_and_powerful_key',
			'cookies.cipher'      => MCRYPT_RIJNDAEL_256,
			'cookies.cipher_mode' => MCRYPT_MODE_CBC
		]);
	}


	/**
	 * Initalize PHP session
	 */
	private function initSession()
	{
		$this->app->add(new SessionCookie);
		$this->app->add(new SessionMiddleware);
	}

	private function initSerializer()
	{
		$this->serializer =
			SerializerBuilder::create()
				->setCacheDir($this->cacheDir)
				->setDebug($this->debug)
				->build();
	}

	private function initAnnotations()
	{
		AnnotationRegistry::registerAutoloadNamespace(
			'JMS\Serializer\Annotation', dirname(dirname(__DIR__)) .'/vendor/jms/serializer/src'
		);
	}
}