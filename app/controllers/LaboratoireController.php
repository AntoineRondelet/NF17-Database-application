<?php
class LaboratoireController extends Controller {

  public function __construct() {
    $this->view = new LaboratoireView();
  }

  public function execute($action = "index") {
    $req = $this->getRequest();

    if ($req->_isGet()) {
      if ($action == "index") {
        $labo = new Laboratoire();
        $this->view->setLaboratoires($labo->getAll());
      }
      $this->view->renderView();
    }
    else if ($req->_isPost() && $action == "new") {
      // RECUPERER LES PARAM, CREER UN LABO, FAIRE SAVETODB ET AFFICHER LE MESSAGE OU L'ERREUR DANS LA VUE
      try {
        $newLabo = new Laboratoire(null,urldecode($req->getParam('nom')),urldecode($req->getParam('type')));
        $message = $newLabo->addToDB();
        $this->view->setMessage($message);
        $this->view->setLaboratoires($newLabo->getAll());
      }
      catch (PDOException $e) {
        if ($e->getCode() == "22P02")
          $error = "Les valeurs entrées ne sont pas bonnes (aucun champ ne doit être laissé vide)";
        else if ($e->getCode() == "23505")
          $error = "Un laboratoire avec les mêmes caractéristiques existe déjà";
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
  }
}