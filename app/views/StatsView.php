<?php

class StatsView extends DefaultView {
  private $lignes;
  private $months = array("Janvier","Février","Mars","Avril","Mai","Juin",
                         "Juillet","Août","Septembre","Octobre","Novembre","Décembre");

  public function __construct() {
    parent::setTitle("Statistiques");
  }

  public function setLignes($lignes) {
    $this->lignes = $lignes;
  }

  private function getMonth($number){
    return $this->months[$number-1];
  }

  public function renderViewDepenses() {
    parent::showHeader();
    echo "<h2> Statistiques des dépenses </h2>";
    if ($this->lignes != NULL) {
    ?>
<table border="1">
  <tr>
    <th>Mois</th>
    <th>Dépenses</th>
  </tr>
   <?php
      $i = 0;
      foreach ($this->lignes as $ligne): ?>
      <tr id="row<?= $i ?>">
        <td><?= $this->getMonth($ligne['month']) ?></td>
        <td><?= $ligne['amount'] ?> €</td>
      </tr>
  <?php endforeach; ?>
</table>
  <?php
    }
    else {
      ?>
      Aucunes dépenses
      <?php
    }
    parent::showFooter();
  }

  public function renderViewParticipants() {
    parent::showHeader();
    echo "<h2> Statistiques des membres </h2>";
    if ($this->lignes != NULL) {
    ?>
<table border="1">
  <tr>
    <th>Membre</th>
    <th>Nombre de projets en cours</th>
    <th>Dépenses du mois</th>
  </tr>
  <?php
      $i = 0;
      foreach ($this->lignes as $ligne): ?>
      <tr id="row<?= $i ?>">
        <td><?= $ligne['nom'] ?></td>
        <td><?= $ligne['score'] ?></td>
        <td><?= $ligne['amount'] ?>€</td>
      </tr>
  <?php endforeach; ?>
  </table>
  <?php
    }
    else {
      ?>
      Aucunes dépenses
      <?php
    }
    parent::showFooter();
  } 

  public function renderViewProjets(){
    parent::showHeader();
    echo "<h2> Statistiques de projets </h2>";
    if ($this->lignes != NULL) {
    ?>
<table border="1">
  <tr>
    <th>Projets</th>
    <th>Budget total</th>
    <th>Dépenses totales</th>
    <th>Budget restant</th>
  </tr>
  <?php
      $i = 0;
      foreach ($this->lignes as $ligne): ?>
      <tr id="row<?= $i ?>">
        <td><?= $ligne['appel'] ?></td>
        <td><?= $ligne['budget'] ?>€</td>
        <td><?= $ligne['depenses'] ?>€</td>
        <td><?= $ligne['budget']-$ligne['depenses'] ?>€</td>
      </tr>
  <?php endforeach; ?>
  </table>
  <?php
    }
    else {
      ?>
      Aucunes dépenses
      <?php
    }
    parent::showFooter();
  }
}