<?php
class FinanceurController extends Controller {

  public function __construct() {
    $this->view = new FinanceurView();
  }

  public function execute($action = "index") {
    $req = $this->getRequest();

    if ($req->_isGet()) {
      if ($action == "index") {
        $fina = new Financeur();
        $this->view->setFinanceurs($fina->getAll("ORDER BY id"));
        $employe_contact = new Employe_contact();
        $this->view->setEmployes_contact($employe_contact->getAll("ORDER BY financeur"));
      }
      if ($action == "index" || $action == "new")
        $this->view->renderView();
    }
    else if ($req->_isPost() && $action == "new") {
      // RECUPERER LES PARAM, CREER UN LABO, FAIRE SAVETODB ET AFFICHER LE MESSAGE OU L'ERREUR DANS LA VUE
      try {
        $newFinanceur = new Financeur(null,urldecode($req->getParam('nom')),urldecode($req->getParam('type')),urldecode($req->getParam('date_debut')),urldecode($req->getParam('date_fin')));
        $message = $newFinanceur->addToDB();
        $this->view->setMessage($message);

        $newEmployeContact = new Employe_contact(null,$newFinanceur->getId(),urldecode($req->getParam('emp_nom')),urldecode($req->getParam('emp_pwd')),urldecode($req->getParam('emp_mail')),urldecode($req->getParam('emp_tel')),urldecode($req->getParam('emp_titre')));
        $messages2 = $newEmployeContact->addToDB();
        $this->view->setMessage($this->view->getMessage()."<br />".$messages2);

        $this->view->setFinanceurs($newFinanceur->getAll("ORDER BY id"));
        $this->view->setEmployes_contact($newEmployeContact->getAll("ORDER BY financeur"));
      }
      catch (PDOException $e) {
        if ($e->getCode() == "22P02")
          $error = "Les valeurs entrées ne sont pas bonnes (aucun champ ne doit être laissé vide)";
        else if ($e->getCode() == "23505")
          $error = "Un financeur ou un employé avec les mêmes caractéristiques existe déjà";
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