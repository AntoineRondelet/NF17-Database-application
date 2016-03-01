<?php
class Entite_juridiqueController extends Controller {

  public function __construct() {
    
  }

  public function execute($action = "index") {
    $req = $this->getRequest();

    if ($action == "delete" && $req->_isPost()) {    
      $oldEntite = new Entite_juridique(urldecode($req->getParam('id')));
      try {
        echo $oldEntite->deleteFromDB();
      }
      catch (PDOException $e) {
        echo $e->getMessage();
      }
      catch (Exception $f) {
        echo $f->getMessage();
      }
    }
  }
}