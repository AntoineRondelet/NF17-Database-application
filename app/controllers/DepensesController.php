<?php

require_once(ROOT_PATH.'/config/db.php');

class DepensesController extends Controller {

  public function execute($action = "index") {
    $request =$this->getRequest();
    
    $this->view = new DepensesView();
 
    if ($request->_isPost()) {
      if ($action == "new") {


        if( !( ($request->getParam("demandeur_ext") == "") xor ($request->getParam("demandeur_lab") == "")) ){
            $error="Il faut un et un seul demandeur !";
            $this->view->setError($error); // TODO remettre le formulaire avec les champs pré-remplis
            $p = new Projet();
            $projets = $p->getAll();
            $lab = new Membre_labo();
            $mlabo = $lab->getAll();
            $ext = new Externe();
            $mext = $ext->getAll();
            $this->view->setProjets($projets);
            $this->view->setMembres_labo($mlabo);
            $this->view->setExternes($mext);
            $this->view->showNewForm(); 
            exit(0); 
        }
        if( ($demandeur_ext=$request->getParam("demandeur_ext")) == "")
        {
          $demandeur_ext = null;
        }
        if( ($demandeur_lab=$request->getParam("demandeur_lab")) == "")
        {
          $demandeur_lab = null;
        }
 
        $proj=new Projet();
        $proj=current( $proj->getAll('WHERE numero='.$request->getParam("projet")) );

        $newDepense = new Depense(NULL,
                                       $request->getParam("projet"),
                                       $proj->getAppel(),
                                       $proj->getOrganisme(),
                                       $proj->getPublication_appel(),
                                       $request->getParam("date"),
                                       $request->getParam("amount"),
                                       $request->getParam("type"),
                                       0,
                                       $demandeur_ext,
                                       $demandeur_lab,
                                       $request->getParam("val_ext"),
                                       $request->getParam("val_labo"));
        try {
          $message = $newDepense->addToDB();
          $this->view->setMessage($message);
        } catch (PDOException $e) {
            $error = $e->getMessage();
            $this->view->setError($error); // TODO remettre le formulaire avec les champs pré-remplis
            $p = new Projet();
            $projets = $p->getAll();
            $lab = new Membre_labo();
            $mlabo = $lab->getAll();
            $ext = new Externe();
            $mext = $ext->getAll();
            $this->view->setProjets($projets);
            $this->view->setMembres_labo($mlabo);
            $this->view->setExternes($mext);
            $this->view->showNewForm(); 
            exit(0); 
        }
      }
      $dep = new Depense();
      if($request->getParam("del") != null)
      {
        $message = $dep->deleteOne($request->getParam("del"),$request->getParam("numero"),$request->getParam("appel"),$request->getParam("organisme"),$request->getParam("publication"));
        $this->view->setMessage($message);
      }
      
      $data = $dep->getAll('ORDER BY appel');  
      $this->view->setDepenses($data);
      $this->view->renderViewHistory();
    }  // END IF POST REQUEST
    else { // GET REQUEST
      if ($action == "index") {
        $dep = new Depense();
        $data = $dep->getAll('ORDER BY appel');  
        $this->view->setDepenses($data);
        $this->view->renderViewHistory();
      }
      else if($action == "new"){
          $p = new Projet();
          $projets = $p->getAll();
          $lab = new Membre_labo();
          $mlabo = $lab->getAll();
          $ext = new Externe();
          $mext = $ext->getAll();

          $this->view->setProjets($projets);
          $this->view->setMembres_labo($mlabo);
          $this->view->setExternes($mext);
          $this->view->showNewForm();
      }
    }
     
  }
}