<?php

require_once(ROOT_PATH.'/config/db.php');

class StatsController extends Controller {

  private $dn;

  public function __construct() {
    $this->view = new StatsView();
    $this->db = connectDB(); // TODO déporter la partie DB de ce controller dans un modèle
  }

  public function execute($action = "depenses") {
    if ($action == "depenses") {      
      $res = $this->db->query("SELECT Extract(month from d.date_depense) AS month, SUM(d.montant) AS amount FROM depense d GROUP BY d.numero,month ORDER BY month asc");
      $rows = $res->fetchAll();
      
      $this->view->setLignes($rows);
      $this->view->renderViewDepenses();
    }
    else if ($action == "participants") {
      $res = $this->db->query("SELECT COUNT(pa.appel) AS score,m.nom, SUM(d.montant) as amount FROM participant_du_labo pa, membre_labo m, depense d WHERE pa.id=m.id AND d.demandeurlab=m.id AND EXTRACT(MONTH FROM d.date_depense)=EXTRACT(MONTH FROM now()) GROUP BY m.nom ORDER BY score desc");
      $rows = $res->fetchAll();
      
      $this->view->setLignes($rows);
      $this->view->renderViewParticipants();
    }
    else if($action == "projets"){
      $res = $this->db->query("SELECT p.appel, SUM(l.montant) AS budget, SUM(d.montant) AS depenses FROM projet p, lignes_budgetaire l, depense d WHERE l.numero=p.numero AND d.numero=p.numero GROUP BY p.appel");
      $rows = $res->fetchAll();
      
      $this->view->setLignes($rows);
      $this->view->renderViewProjets();
    }
    else {
      $this->view->renderView();
    }
  }
}
