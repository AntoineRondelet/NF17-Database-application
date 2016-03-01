<?php

require_once(ROOT_PATH.'/config/db.php');

abstract class Controller {
  protected $view;
  protected $_request;

  abstract public function execute($action = 'index');

  /**
   * Fetches the current request
   * @return Request
   */
  public function getRequest()
  {
    // initializes the request object
    if ($this->_request == null) {
      $this->_request = new Request();
    }
    
    return $this->_request;
  }
}