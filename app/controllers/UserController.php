<?php

class UserController extends Controller {

  public function __construct() {
    $this->view = new DefaultView();
  }

  public function execute($action = "all") {
    $this->view->renderView();
  }
}