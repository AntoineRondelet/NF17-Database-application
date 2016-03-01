<?php

class AppelProjetView extends DefaultView {

  private $appels_a_projets;
  private $organismes = array();
  private $comites = array();

  public function __construct($title = "Création d'un appel à projet") {
    parent::setTitle($title);
  }

  public function setOrganismes($org) {
    $this->organismes = $org;
  }

  public function setComites($comites) {
    $this->comites = $comites;
  }

  public function setAppels_a_projet($rows) {
    $this->appels_a_projets = $rows;
  }

  private function showNewForm() {
    ?>
<form method="POST" action="">
  <table>
    <tr>
      <td><label class="required" for="nom">Nom du projet</label></td>
      <td><input required type="text" id="nom" name="nom" /></td>
    </tr>

    <tr>
      <td><label class="required" for="organisme">Organisme</label></td>
      <td>
        <select required id="organisme" name="organisme">
          <?php foreach ($this->organismes as $organisme): ?>
          <option value="<?= $organisme->getNom() ?>"><?= $organisme->getNom() ?></option>
          <?php endforeach;?>
        </select>
      </td>
    </tr>

    <tr>
      <td><label class="required" for="duree">Durée de validité</label></td>
      <td><input value="3" class="spinner" type="text" id="duree" name="duree" /> jour(s)</td>
    </tr>

    <tr>
      <td><label class="required" for="theme">Thème</label></td>
      <td><input required type="text" id="theme" name="theme" /></td>
    </tr>

    <tr>
      <td><label class="required" for="description">Description</label></td>
      <td><textarea required id="description" name="description" rows="4" cols="50"></textarea></td>
    </tr>

    <tr>
      <td><label class="required" for="comite">Comité</label></td>
      <td>
        <?php if ($this->comites !== NULL && !empty($this->comites)) { ?>
        <select required name="comite">
          <?php foreach ($this->comites as $comite): ?>
          <option value="<?= $comite->getNom() ?>"><?= $comite->getNom() ?></option>
          <?php endforeach;?>
        </select> OU
        <?php } ?>
        créez un comité : <input type="text" id="comite" name="new_comite" />
      </td>
    </tr>

    <tr>
      <td></td>
      <td><input type="submit" value="Soumettre le projet" /></td>
    </tr>
  </table>
</form>
<script>
$( ".spinner" ).prop('readonly',true);
$( ".spinner" ).spinner({
  min: 1
  });
</script>
    <?php
  }

  public function renderView() {
    $this->addCSS(WEB_ROOT.'/res/css/jquery-ui.min.css');
    $this->addJSscript(WEB_ROOT.'/res/js/jquery-2.1.4.min.js');
    $this->addJSscript(WEB_ROOT.'/res/js/jquery-ui.min.js');
    $this->addJSscript(WEB_ROOT.'/res/js/appels_propositions_projets.js');
    parent::showHeader();

    echo "<h2>".$this->title."</h2>";
    if ($this->appels_a_projets === NULL)
      $this->showNewForm();
    else if (empty($this->appels_a_projets))
      echo "<h3 class='error'>Aucun appel à projet créé pour l'instant.</h3>";
    else {
      ?>
      <table border="1">
        <tr>
          <th>Nom</th>
          <th>Organisme</th>
          <th>Publication</th>
          <th>Durée de validité</th>
          <th>Thème</th>
          <th>Description</th>
          <th>Comité</th>
          <th>Faire une proposition de projet</th>
          <th>Supprimer</th>
        </tr>
        <?php
        $i = 0;
        foreach ($this->appels_a_projets as $ap): ?>
        <tr id="row<?= ++$i ?>">
          <td><?= $ap->getNom() ?></td>
          <td><?= $ap->getOrganisme() ?></td>
          <td><?= $ap->getPublication() ?></td>
          <td><?= $ap->getDuree() ?> jour<?= $ap->getDuree() > 1?"s":"" ?></td>
          <td><?= $ap->getTheme() ?></td>
          <td><?= $ap->getDescription() ?></td>
          <td><?= $ap->getComite() ?></td>
          <td class="center middle"><a class="membre-labo" href="javascript:void(0)" onclick="faireProposition('<?= WEB_ROOT ?>/projets/propositions/new', <?= $i ?>, '<?= urlencode($ap->getNom()) ?>', '<?= urlencode($ap->getOrganisme()) ?>', '<?= urlencode($ap->getPublication()) ?>');" ><img src="<?= WEB_ROOT ?>/res/img/add.png" /></a></td>
          <td class="center middle"><a class="employe-contact" href="javascript:void(0)" onclick="supprimerAppel('<?= WEB_ROOT ?>/projets/appels/delete', <?= $i ?>, '<?= urlencode($ap->getNom()) ?>', '<?= urlencode($ap->getOrganisme()) ?>', '<?= urlencode($ap->getPublication()) ?>', '<?= WEB_ROOT ?>/projets/appels');" ><img src="<?= WEB_ROOT ?>/res/img/delete.png" /></a></td>
        </tr>
    <?php endforeach; ?>
      </table>
      <?php
    }
    parent::showFooter();
  }
}
