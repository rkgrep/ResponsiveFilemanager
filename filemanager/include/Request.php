<?php namespace trippo\Filemanager;

class Request {

	/**
	 * Query parameters ($_GET)
	 *
	 * @var  array
	 */
	protected $query;

	/**
	 * Request parameters ($_POST or body)
	 *
	 * @var  array
	 */
	protected $request;

	/**
	 * Server parameters ($_SERVER)
	 *
	 * @var  array
	 */
	protected $server;

	/**
	 * Cookies
	 *
	 * @var  array
	 */
	protected $cookies;

	/**
	 * Files
	 *
	 * @var  array
	 */
	protected $files;

	/**
	 * Request method
	 *
	 * @var  string
	 */
	protected $method = null;

	/**
	 * Initialize request
	 */
	public function __construct()
	{

		$this->query = array_map('urldecode', $_GET);
		$this->request = $_POST;
		$this->server = $_SERVER;
		$this->cookies = $_COOKIE;
		$this->files = $_FILES;

	}

	/**
	 * Get parameter from request
	 *
	 * @param  string  $key
	 * @param  mixed   $default
	 *
	 * @return  mixed
	 */
	public function get($key, $default = null)
	{
		if (array_key_exists($key, $this->query))
		{
			return $this->query[$key];
		}
		elseif (array_key_exists($key, $this->request))
		{
			return $this->request[$key];
		}

		return $default;
	}

	/**
	 * Determine if parameter exists
	 *
	 * @param  string  $key
	 *
	 * @return  bool
	 */
	public function has($key)
	{
		return (array_key_exists($key, $this->query) || array_key_exists($key, $this->request));
	}

	/**
	 * Gets the request method.
	 *
	 * @return string The request method
	 */
	public function getMethod()
	{
		if (null === $this->method)
		{
			$this->method = $this->getRealMethod();
		}

		return $this->method;
	}

	/**
	 * Gets the "real" request method.
	 *
	 * @return string The request method
	 */
	public function getRealMethod()
	{
		$method = (array_key_exists('REQUEST_METHOD', $this->server)) ? $this->server['REQUEST_METHOD'] : 'GET';
		return strtoupper($method);
	}

}