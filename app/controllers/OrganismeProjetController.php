<?php
class OrganismeProjetController extends Controller {

  public function __construct() {
    $this->view = new OrganismeProjetView();
  }

  public function execute($action = "index") {
    $req = $this->getRequest();

    if ($req->_isGet()) {
      if ($action == "index") {
        $new = new Organisme_projet();
        $this->view->setOrganismes_projet($new->getAll());
      }
      elseif ($action == "new") {
         $new = new Financeur();
         $this->view->setFinanceurs($new->getAll());
      }
      if ($action == "index" || $action == "new")
        $this->view->renderView();
    }
    else if ($req->_isPost() && $action == "new") {
      try {
        $newOrga = new Organisme_projet(urldecode($req->getParam('nom')),null,urldecode($req->getParam('duree')));
        $id_organisme = $newOrga->addToDB();
        $fcop = new Financeur_cree_organisme_projet(urldecode($req->getParam('financeur')), urldecode($req->getParam('nom')));
        $message = $fcop->addToDB();

        $this->view->setMessage($message);
        $this->view->setOrganismes_projet($newOrga->getAll());
      }
      catch (PDOException $e) {
        if ($e->getCode() == "22P02")
          $error = "Les valeurs entrées ne sont pas bonnes (aucun champ ne doit être laissé vide)";
        else if ($e->getCode() == "23505")
          $error = "Un organisme avec le même nom existe déjà";
        else if ($e->getCode() == "23503")
          $error = "Erreur 23503";
        else
          $error = $e->getMessage();
        $this->view->setError($error);
      }
      catch (Exception $e) {
        $error = $e->getMessage();
        $this->view->setError($error);
      }
      $this->view->renderView();
    }
    else if ($action == "delete" && $req->_isPost()) {
      $old = new Organisme_projet(urldecode($req->getParam('nom')));
      try {
        echo $old->deleteFromDB();
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
