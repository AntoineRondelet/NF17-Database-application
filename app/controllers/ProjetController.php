<?php
class ProjetController extends Controller {

  public function __construct() {
    $this->view = new ProjetView();
  }

  public function execute($action = "index") {
    $req = $this->getRequest();

    if ($action == "index" && $req->_isGet()) {    
      $projet = new Projet();
      $rows = $projet->getAll();
      $this->view->setProjets($rows);
      $this->view->renderView();
    }
    else if ($action == "new") {
      if ($req->_isGet()) { // On veut créer un projet, on affiche le form
        $this->view->setTitle("Création d'un projet");

        $default_prop = new Proposition_de_projet(urldecode($req->getParam('numero')), urldecode($req->getParam('nom')), urldecode($req->getParam('organisme')), urldecode($req->getParam('publication')));
        if ($default_prop->getNumero() == NULL || $default_prop->getAppel() == NULL || $default_prop->getOrganisme() == NULL || $default_prop->getPublication_appel() == NULL) {
          $this->view->setError("Il manque des données pour créer un nouveau projet. Tentez de revenir au listing des propositions.");
        }
        else {
          $this->view->setDefaultProposition_de_projet($default_prop);
        }
        $this->view->renderView();
      }
      else if ($req->_isPost()) { // Formulaire pour un nouveau projet reçu
        try {
          $newProjet = new Projet(urldecode($req->getParam('numero')),urldecode($req->getParam('nom')),urldecode($req->getParam('organisme')),urldecode($req->getParam('publication')),urldecode($req->getParam('debut')),urldecode($req->getParam('fin')));
          $message = $newProjet->addToDB();
          $this->view->setMessage($message);
        }
        catch (PDOException $e) {
          if ($e->getCode() == "22P02")
            $error = "Les valeurs entrées ne sont pas bonnes (les dates doivent être au format YYYY-MM-DD, aucun champ ne doit être laissé vide)";
          else if ($e->getCode() == "23505")
            $error = "Un projet des mêmes numéro et nom, avec le même organisme et publié à la même date existe déjà";
          else if ($e->getCode() == "23503")
            $error = "Vous avez tenté de créer un projet lié à une proposition inexistante.";
          else if ($e->getCode() == "P0001")
              $error = "Les dates ne sont pas valides (début avant l'émission de la proposition ou début après la fin)";
          else
            $error = $e->getMessage();
          $this->view->setError($error);
        }
        catch (Exception $e) {
          $error = $e->getMessage();
          $this->view->setError($error); 
        }
        $projet = new Projet();
        $this->view->setProjets($projet->getAll());
        $this->view->renderView();
      }
    }
    else if ($action = "delete" && $req->_isPost()) {
      $oldProjet = new Projet(urldecode($req->getParam('numero')),urldecode($req->getParam('nom')),urldecode($req->getParam('organisme')),urldecode($req->getParam('publication')));
      try {
        echo $oldProjet->deleteFromDB();
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