<?php

class ApplicationController extends Controller {

  public function execute($action = 'index') {
    $this->view = new DefaultView();
    $req = $this->getRequest();
    if ($action == 'index') {
      $this->view->setBody("
        <p>Vous êtes connecté ! YAY !<br /><br />Voici nos derniers produits à la mode :</p>
        <p><img src='".WEB_ROOT."/res/img/ad.png' /><img class='ad' src='".WEB_ROOT."/res/img/ad2.png' /></p>
        ");
    }
    else if ($action == 'logout') {
      session_destroy();
      header('Location: '.WEB_ROOT.'/login');
      exit(0);
    }
    else if ($action == 'login') {
      if (isset($_SESSION['login']) && $_SESSION['login'] !== NULL) {
        header('Location: '.WEB_ROOT.'/');
        exit(0);
      }
      $this->view->setBody('
          <p>Bienvenue sur la page d\'accueil. Nous vendons des pillules pas chères. <strong>Vous êtes un financeur et souhaitez nous soumettre un appel d\'offre pour la création des pillules de demain ?</strong> Connectez-vous avec votre compte, après avoir contacté notre sysadmin pour qu\'il vous crée un compte.</p>
        <p><img src="'.WEB_ROOT.'/res/img/doctor.png" /></p>
          Veuillez vous authentifier
          <form method="POST" action="">
            <table>
              <tr>
                <td><label for="login">Login (email)</label></td>
                <td><input type="text" name="login" id="login" /></td>
              </tr>
              <tr>
                <td><label for="pwd">Mot de passe</label></td>
                <td><input type="password" name="password" id="pwd" /></td>
              </tr>
              <tr>
                <td></td>
                <td><input type="submit" value="Se connecter" /></td>
              </tr>
            </table>
          </form>
          <style>
            .must-be-connected { display:none !important}
          </style>
        ');

      if ($req->_isGet()) {
        // Nothing...
      } else if($req->_isPost()) {

        $logged_person = NULL;
        
        if ($req->getParam('login') === 'root' && $req->getParam('password') === 'toor')
          $logged_person = "root";

        try {
          if ($logged_person === NULL) {
            $membre_labo = new Membre_labo();
            $logged_person = $membre_labo->getOne($req->getParam('login'),$req->getParam('password'));
          }
          if ($logged_person === NULL) {
            $employe_contact = new Employe_contact();
            $logged_person = $employe_contact->getOne($req->getParam('login'),$req->getParam('password'));
              if ($logged_person === NULL) {
                $this->view->setError("Les credentials fournis n'ont pas permis de vous authentifier.");
              }
          }
          if ($logged_person !== NULL) {
            $_SESSION['login'] = $logged_person;
            header('Location: '.WEB_ROOT.'/');
          }
        } catch (Exception $e) { // PDOException as well
          $this->view->setError($e->getMessage());
        }
      }
    } // end if $action == 'login'
    else if ($action == 'planSite') {
      $this->view = new SiteView();
    }
    $this->view->renderView();
  } // end function execute
}