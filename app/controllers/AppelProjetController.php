<?php

class AppelProjetController extends Controller {

  public function execute($action = "index") {
    $request =$this->getRequest();
    
    if ($request->_isPost()) {
      if ($action == "new") {
        $this->view = new AppelProjetView();

        $newCOMITE = urldecode($request->getParam("new_comite"))!=="";
        $o = new Organisme_projet();
        $org = $o->getAll('where (date_creation + duree) >= now()');
        $c = new Comite();
        $this->view->setOrganismes($org);
        $message = "";
        try {
          if ($newCOMITE) {
            $c->setNom(urldecode($request->getParam("new_comite")));
            $message = $c->addToDB();
            $this->view->setMessage($message);
          }
          $newAppel = new Appel_a_projet(urldecode($request->getParam("nom")),
                                         urldecode($request->getParam("organisme")),
                                         NULL,
                                         urldecode($request->getParam("duree")),
                                         urldecode($request->getParam("theme")),
                                         urldecode($request->getParam("description")),
                                         $newCOMITE?urldecode($request->getParam("new_comite")):urldecode($request->getParam("comite")));
          
          $message = $newAppel->addToDB();
          $this->view->setMessage($this->view->getMessage()."<br />".$message);
          $this->view->setAppels_a_projet($newAppel->getAll());
        } catch (PDOException $e) {
          if ($e->getCode() == "22P02")
            $error = "Les valeurs entrées ne sont pas bonnes (la durée doit être un nombre, aucun champ ne doit être laissé vide)";
          else if ($e->getCode() == "23505")
            $error = !empty($message)?"Un appel à projet du même nom, avec le même organisme et publié à la même date existe déjà":"Un comité avec le même nom existe déjà";
          else if ($e->getCode() == "23503")
            $error = "Il faut tout remplir (avez-vous bien renseigné un comité ?)".$e->getMessage();
          else
            $error = $e->getMessage();
          $this->view->setError($error); // TODO remettre le formulaire avec les champs pré-remplis
        }
        catch (Exception $e) {
          $error = $e->getMessage();
          $this->view->setError($error); 
        }
        $this->view->setComites($c->getAll());
        $this->view->renderView();
      }
      else if ($action == "delete") {
        $oldAppel = new Appel_a_projet(urldecode($request->getParam("nom")),
                                     urldecode($request->getParam("organisme")),
                                     urldecode($request->getParam("publication")));
        try {
          echo $oldAppel->deleteFromDB();
        } catch (PDOException $e) {
          echo $e->getMessage();
        }       
      }
    }  // END IF POST REQUEST
    else { // GET REQUEST
      $this->view = new AppelProjetView();
      if ($action == "new") {
        $o = new Organisme_projet();
        $org = $o->getAll('where (date_creation + duree) >= now()');

        $c = new Comite();
        $com = $c->getAll();

        $this->view->setOrganismes($org);
        $this->view->setComites($com);
        $this->view->renderView();
        return;
      }
      else if ($action == "index") {
        $aap = new Appel_a_projet();
        $data = $aap->getAll();
        
        $this->view->setTitle("Liste des appels à projet");
        $this->view->setAppels_a_projet($data);
      }
      $this->view->renderView();
    }
  }
}