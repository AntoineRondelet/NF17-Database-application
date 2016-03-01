<?php

class ErrorController extends Controller
{
	private $_exception = null;
	
	/**
	 * Sets the exception to show information about
	 */
	public function setException(Exception $exception)
	{
		$this->_exception = $exception;
	}
	
	public function execute($action = 'index') {
		if ($action == 'error')
			$this->showError();
	}

	/**
	 * The error action, which is called whenever there is an error on the site
	 */
	public function showError()
	{
		// sets the 404 header
		header("HTTP/1.0 200 OK");
		
		// logs the error to the log
		error_log($this->_exception->getTraceAsString());

		// sets the error to be rendered in the view
		echo $this->_exception->getMessage();
	}
}
