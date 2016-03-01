<?php

class DepensesView extends DefaultView {
  private $depenses;
  private $projets;
  private $membres_labo;
  private $externes;

  public function __construct() {
    parent::setTitle("Dépenses");
  }

  public function setDepenses($depenses) {
    $this->depenses = $depenses;
  }

  public function setProjets($projets) {
    $this->projets = $projets;
  }

  public function setMembres_labo($membres_labo) {
    $this->membres_labo = $membres_labo;
  }

  public function setExternes($ext) {
    $this->externes = $ext;
  }

  public function renderViewHistory() {
    parent::showHeader();

    if ($this->depenses != NULL) {
    ?>
  <table border="1">
    <tr>
      <th>Projet</th>
      <th>Date</th>
      <th>Montant</th>
      <th>Type</th>
      <th>Statut</th>
      <th>Demandeur Extérieur</th>
      <th>Demandeur Labo</th>
      <th>Validateur Extérieur</th>
      <th>Validateur Labo</th>
      <th>Supprimer</th>
    </tr>
    <?php
      $i = 0;
      foreach ($this->depenses as $dep): ?>
      <tr id="row<?= $i ?>">
        <td><?= $dep->getAppel() ?></td>
        <td><?= $dep->getDate_depense() ?></td>
        <td><?= $dep->getMontant() ?> €</td>
        <td><?= $dep->getType() ?></td>
        <td><?= $dep->getStatus() ?></td>
        <td><?php 
          if($dep->getDemandeurext() !=NULL) 
            echo htmlspecialchars($dep->getDemandeurext()->getNom());  ?>
        </td>
        <td><?php 
          if($dep->getDemandeurlab() !=NULL) 
           echo htmlspecialchars($dep->getDemandeurlab()->getNom());  ?>
        </td>
        <td><?php 
          if($dep->getValidateurext() !=NULL) 
           echo htmlspecialchars($dep->getValidateurext()->getNom());  ?>
        </td>
        <td><?php 
          if($dep->getValidateurlab() !=NULL) 
           echo htmlspecialchars($dep->getValidateurlab()->getNom());  ?>
        </td>
        <td>
          <form method="POST" action="">
            <?php echo "<input type=\"hidden\" id=\"del\" value=\"".htmlspecialchars($dep->getDepense_id())."\" name=\"del\"/>"; ?>
            <?php echo "<input type=\"hidden\" id=\"numero\" value=\"".htmlspecialchars($dep->getNumero())."\" name=\"numero\"/>"; ?>
            <?php echo "<input type=\"hidden\" id=\"appel\" value=\"".htmlspecialchars($dep->getAppel())."\" name=\"appel\"/>"; ?>
            <?php echo "<input type=\"hidden\" id=\"organisme\" value=\"".htmlspecialchars($dep->getOrganisme())."\" name=\"organisme\"/>"; ?>
            <?php echo "<input type=\"hidden\" id=\"publication\" value=\"".htmlspecialchars($dep->getPublication_appel())."\" name=\"publication\"/>"; ?>
            <input type="submit" value="Supprimer la dépense" />
          </form>
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

public function showNewForm() {
  $this->addCSS(WEB_ROOT.'/res/css/jquery-ui.min.css');
  $this->addJSscript(WEB_ROOT.'/res/js/jquery-2.1.4.min.js');
  $this->addJSscript(WEB_ROOT.'/res/js/jquery-ui.min.js');
  $this->addJSscript(WEB_ROOT.'/res/js/entites_juridiques.js');
  parent::showHeader();
  ?>
  <form method="POST" action="">
  <table>
    <tr>
      <td><label class="required" for="projet">Projet</label></td>
      <td>
        <select required id="projet" name="projet">
          <option value="">  </option>
          <?php foreach ($this->projets as $projet): ?>
          <option value="<?= $projet->getNumero() ?>"><?= $projet->getAppel() ?></option>
          <?php endforeach;?>
        </select>
      </td>
    </tr>
    
    <tr>
      <td><label class="required" for="date">Date de la dépense</label></td>
      <td><input class="datepicker" required type="date" id="date" name="date" /></td>
    </tr>

    <tr>
      <td><label class="required" for="amount">Montant</label></td>
      <td><input required type="text" id="amount" name="amount" /> €</td>
    </tr>

    <tr>
      <td><label class="required" for="type">Type</label></td>
      <td>
        <select required id="type" name="type">
          <option value="materiel">Matériel</option>
          <option value="fonctionnement">Fonctionnement</option>
        </select>
      </td>
    </tr>
    <tr><td colspan="2"><strong>Il faut UN SEUL demandeur (laboratoire ou externe)</strong></td></tr>
    <tr>
      <td><label for="demandeur_lab">Demandeur laboratoire</label></td>
      <td>
        <select id="demandeur_lab" name="demandeur_lab">
          <option value="">  </option>
          <?php foreach ($this->membres_labo as $membre_labo): ?>
          <option value="<?= $membre_labo->getId() ?>"><?= $membre_labo->getNom() ?></option>
          <?php endforeach;?>
        </select>
      </td>
    </tr>

    <tr>
      <td><label for="demandeur_ext">Demandeur extérieur</label></td>
      <td>
        <select id="demandeur_ext" name="demandeur_ext">
          <option value="">  </option>
          <?php foreach ($this->externes as $externe): ?>
          <option value="<?= $externe->getId() ?>"><?= $externe->getNom() ?></option>
          <?php endforeach;?>
        </select>
      </td>
    </tr>
    <tr><td colspan="2"><strong>Il faut UN SEUL validateur (laboratoire ou externe)<br />différent du demandeur</strong></td></tr>
    <tr>
      <td><label for="val_labo">Validateur laboratoire</label></td>
      <td>
        <select id="val_labo" name="val_labo">
          <option value="">  </option>
          <?php foreach ($this->membres_labo as $membre_labo): ?>
          <option value="<?= $membre_labo->getId() ?>"><?= $membre_labo->getNom() ?></option>
          <?php endforeach;?>
        </select>
      </td>
    </tr>

    <tr>
      <td><label for="val_ext">Validateur externe</label></td>
      <td>
        <select id="val_ext" name="val_ext">
          <option value="">  </option>
          <?php foreach ($this->externes as $externe): ?>
          <option value="<?= $externe->getId() ?>"><?= $externe->getNom() ?></option>
          <?php endforeach;?>
        </select>
      </td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" value="Soumettre la dépense" /></td>
    </tr>
  </table>
</form>
<script>
$( ".datepicker" ).datepicker({
  inline: true,
  dateFormat: "yy-mm-dd"
});
$('.datepicker').prop('readonly', true);
</script>
    <?php
    parent::showFooter();
  }
}
