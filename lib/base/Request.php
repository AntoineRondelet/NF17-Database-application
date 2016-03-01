<?php

class Request
{
	private $default = NULL;
	/**
	 * Tests if the current request is a POST request
	 * @return boolean
	 */
	public function _isPost()
	{
		return ($_SERVER['REQUEST_METHOD'] == 'POST' ? true : false);
	}
	
	/**
	 * Tests if the current request is a GET request
	 * @return boolean
	 */
	public function _isGet()
	{
		return ($_SERVER['REQUEST_METHOD'] == 'GET' ? true : false);
	}
	
	/**
	 * fetches the given parameter data.
	 * @param string $key the key to look for.
	 * @param mixed $default the default value to return, if the given parameter is not set.
	 */
	public function getParam($key, $default = null)
	{
		//if ($this->_isPost()) {
			if(isset($_POST) && isset($_POST[$key])) {
				return $_POST[$key];
			}
		//}
		//else if ($this->_isGet()) {
			if(isset($_GET) && isset($_GET[$key])) {
				return $_GET[$key];
			}
		//}
			
		return $default;
	}
	
	/**
	 * Returns a list of parameters given in the current request
	 * @return array the params given
	 */
	public function getAllParams()
	{
		if ($this->_isPost()) {
			return $_POST;
		}
		else if ($this->_isGet()) {
			return $_GET;
		}
	}
}
