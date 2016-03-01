<?php

class PropositionProjetController extends Controller {

  public function execute($action = "index") {
  $req = $this->getRequest();

    if ($action == "index" && $req->_isGet()) {
      $prop = new Proposition_de_projet();
      $data = $prop->getAll();

      $this->view = new PropositionProjetView();
      $this->view->setPropositions_de_projet($data);
      $this->view->renderView();
    }
    else if ($action == 'new' && $req->_isPost()) {
      $newProposition = new Proposition_de_projet(null,urldecode($req->getParam('nom')),urldecode($req->getParam('organisme')),urldecode($req->getParam('publication')));
      if($_SESSION['login'] instanceof Membre_labo){
         $newRedaction = new Redaction($_SESSION['login']->getId(),urldecode($req->getParam('nom')),urldecode($req->getParam('organisme')),urldecode($req->getParam('publication')),$newProposition->getNew()['num']);
      }
      try {
        echo $newProposition->addToDB();
        if($_SESSION['login'] instanceof Membre_labo){
           echo $newRedaction->addToDB();
         }
      }
      catch (PDOException $e) {
        $error=$e->getCode();
        if($error = "P0001")
          echo "La date limite de soumission est dépassée";
        else
          echo $e->getMessage();
      }
    }
    else if ($action == 'delete' && $req->_isPost()) {
      $oldProposition = new Proposition_de_projet(urldecode($req->getParam('numero')),urldecode($req->getParam('nom')),urldecode($req->getParam('organisme')),urldecode($req->getParam('publication')));
      try {
        echo $oldProposition->deleteFromDB();
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
