<?php
class Membre_laboController extends Controller {

  public function __construct() {
    $this->view = new Membre_laboView();
  }

  public function execute($action = "index") {
    $req = $this->getRequest();

    $labo = new Laboratoire();
    $labos = $labo->getAll();
    $this->view->setLaboratoires($labos);

    if ($req->_isGet()) {
      if ($action == "index") {
        $mb = new Membre_labo();
        $this->view->setMembres_labo($mb->getAll());
      }
      $this->view->renderView();
    }
    else if ($req->_isPost() && $action == "new") {
      try {
        $newMembre = new Membre_labo(null,urldecode($req->getParam('nom')),urldecode($req->getParam('password')),urldecode($req->getParam('mail')),urldecode($req->getParam('telephone')),urldecode($req->getParam('date_debut')),urldecode($req->getParam('date_fin')),urldecode($req->getParam('quotite')),urldecode($req->getParam('etablissement')),urldecode($req->getParam('specialite')),true,urldecode($req->getParam('type')),urldecode($req->getParam('sujet')),urldecode($req->getParam('laboratoire')));
        $message = $newMembre->addToDB();
        $this->view->setMessage($message);
        $this->view->setMembres_labo($newMembre->getAll());
      }
      catch (PDOException $e) {
        if ($e->getCode() == "22P02")
          $error = "Les valeurs entrées ne sont pas bonnes (aucun champ ne doit être laissé vide) ";
        else if ($e->getCode() == "23505")
          $error = "Un membre avec la même adresse email existe déjà";
        else if ($e->getCode() == "23503")
          $error = "Erreur 23503";
        else if ($e->getCode() == "23514") {
          $error = "Veuillez remplir uniquement les champs appropriés, selon le type du membre.";
        }
        else
          $error = $e->getMessage();
        $this->view->setError($error);
      }
      catch (Exception $e) {
        $error = $e->getMessage();
        $this->view->setError($error); 
      }
      // show tableau
      $this->view->renderView();
    } else if ($req->_isPost() && $action == "delete") {
      $oldMembre = new Membre_labo(urldecode($req->getParam('id')));
      try {
        echo $oldMembre->deleteFromDB();
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