<?php

class Membre_laboView extends DefaultView {
  
  private $membres_labo;
  private $laboratoires;

  public function __construct() {
    parent::setTitle("Création d'un membre de laboratoire");
  }

  public function setMembres_labo($m) {
    $this->membres_labo = $m;
  }

  public function setLaboratoires($l) {
    $this->laboratoires = $l;
  }

  private function showNewForm(){?>
<form method="POST" action="<?= WEB_ROOT ?>/laboratoires/membres/new" >
  <table>
    <tr>
      <td><label class="required" for="nom">Nom</label></td>
      <td><input required name="nom" id="nom" type="text" /></td>
    </tr>
    <tr>
      <td><label class="required" for="password">Mot de passe</label></td>
      <td><input required name="password" id="password" type="password" /></td>
    </tr>
    <tr>
      <td><label class="required" for="mail">Mail</label></td>
      <td><input required name="mail" id="mail" type="email" /></td>
    </tr>
    <tr>
      <td><label for="tel">Téléphone</label></td>
      <td><input name="telephone" id="tel" type="tel" /></td>
    </tr>
    <tr>
      <td><label class="required" for="lab">Laboratoire</label></td>
      <td>
        <select required name="laboratoire" id="lab">
        <?php foreach ($this->laboratoires as $labo) {
          echo "<option value=".$labo->getId().">".$labo->getNom()."</option>";
        } ?>
        </select> 
      </td>
    </tr>
  </table>
  <h3>Choix du type de membre</h3>
  <table>
    <tr>
      <td colspan="2"><input type="radio" name="type" value="i" checked>Ingénieur</td>
      <td colspan="2"><input type="radio" name="type" value="c" >Enseignant chercheur</td>
      <td colspan="2"><input type="radio" name="type" value="d" >Doctorant</td>
    <tr>
      <td><label for="specialite">Spécialité</label></td>
      <td><input name="specialite" id="specialite" type="text" /></td>
      <td><label for="quotite">Quotité de temps (h)</label></td>
      <td><input class="spinner" name="quotite" id="quotite" type="text" /></td>
      <td><label for="debut">Date de début de thèse</label></td>
      <td><input class="datepicker" type="date" id="debut" name="date_debut" /></td>
    </tr>
    <tr>
      <td colspan="2"></td>
      <td><label for="etab">Etablissement</label></td>
      <td><input name="etablissement" id="etab" type="text" /></td>
      <td><label for="fin">Date de fin de thèse</label></td>
      <td><input class="datepicker" type="date" id="fin" name="date_fin" /></td>
    </tr>
    <tr>
      <td colspan="4"></td>
      <td><label for="sujet">Sujet de thèse</label></td>
      <td><input name="sujet" id="sujet" type="text" /></td>
    </tr>
    <tr>
      <td colspan="6"><input type="submit" value="Créer le membre du laboratoire" /></td>
    </tr>
  </table>
</form>
<script>
$( ".datepicker" ).datepicker({
  inline: true,
  dateFormat: "yy-mm-dd"
});
$('.datepicker').prop('readonly', true);
$( ".spinner" ).prop('readonly',true);
$( ".spinner" ).spinner({
  min: 0.1,
  step: 0.1
});
</script>
  <?php 
  }

  public function renderView() {
    $this->addCSS(WEB_ROOT.'/res/css/jquery-ui.min.css');
    $this->addJSscript(WEB_ROOT.'/res/js/jquery-2.1.4.min.js');
    $this->addJSscript(WEB_ROOT.'/res/js/jquery-ui.min.js');
    $this->addJSscript(WEB_ROOT.'/res/js/entites_juridiques.js');
    parent::showHeader();
    echo "<h2>".$this->title."</h2>";
    if ($this->laboratoires !== NULL)
      $this->showNewForm();
    if ($this->membres_labo !== NULL && $this->laboratoires !== NULL) {
      ?>
      <h3>Membres existants</h3>
      <table border="1">
        <tr>
          <th>Membre</th>
          <th>Supprimer le membre</th>
          <th>Laboratoire</th>
        </tr>
        <?php
        $i = 0;
        foreach ($this->membres_labo as $membre_labo): ?>
        <tr id="row<?= ++$i ?>">
          <td><?= $membre_labo ?></td>
          <td class="center middle">
            <a href="javascript:void(0);" onclick="supprimerMembreLabo('<?= WEB_ROOT ?>/laboratoires/membres/delete', '<?= $i ?>','<?= urlencode($membre_labo->getId()) ?>','<?= WEB_ROOT ?>/laboratoires/membres')" ><img src="<?= WEB_ROOT ?>/res/img/delete.png" /></a>
          </td>
          <td>
          <?php foreach($this->laboratoires as $lab) {
            if ($lab->getId() === $membre_labo->getLabo())
              echo $lab;
          } ?>
          </td>
        </tr>
    <?php endforeach; ?>
      </table>
      <?php
    }
    parent::showFooter();
  }
}
