<?php

class LabelController extends Controller {

  public function __construct() {
    $this->view = new LabelView();
  }

  public function execute($action = "all") {
    if ($action == "all") {
      
      $label = new Label();
      $rows = $label->getAll();
      
      $this->view->setLabels($rows);
      $this->view->renderView();
    }
    else  {
      // ...
    }
  }
}