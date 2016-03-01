<?php

class ProjetView extends DefaultView {
  // Quand on veut afficher la liste des projets
  private $projets;

  // OU
  // Quand on veut créer un projet à partir d'une proposition
  private $default_proposition_de_projet; // Proposition pré-selectionnée dans la liste déroulante

  public function __construct($title = "Liste des projets") {
    parent::setTitle($title);
  }

  public function setProjets($projets) {
    $this->projets = $projets;
  }

  public function setDefaultProposition_de_projet($prop) {
    $this->default_proposition_de_projet = $prop;
  }

  private function showNewForm(){?>
<form method="POST" action="<?= WEB_ROOT ?>/projets/new" >
  <input type="hidden" name="numero" value="<?= $this->default_proposition_de_projet->getNumero() ?>" />
  <input type="hidden" name="nom" value="<?= $this->default_proposition_de_projet->getAppel() ?>" />
  <input type="hidden" name="organisme" value="<?= $this->default_proposition_de_projet->getOrganisme() ?>" />
  <input type="hidden" name="publication" value="<?= $this->default_proposition_de_projet->getPublication_appel() ?>" />
<table>
    <tr>
      <td>Proposition associée</td>
      <td><input type="text" readonly value="<?= $this->default_proposition_de_projet->getAppel() ?>" />
      </td>
    </tr>

    <tr>
      <td><label class="required" for="debut">Date de début</label></td>
      <td><input class="datepicker" required type="date" id="debut" name="debut" /></td>
    </tr>

    <tr>
      <td><label class="required" for="fin">Date de fin</label></td>
      <td><input class="datepicker" required type="date" id="fin" name="fin" /></td>
    </tr>

    <tr>
      <td></td>
      <td><input type="submit" value="Accepter le projet" /></td>
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
  }
  
  public function renderView() {
    $this->addCSS(WEB_ROOT.'/res/css/jquery-ui.min.css');
    $this->addJSscript(WEB_ROOT.'/res/js/jquery-2.1.4.min.js');
    $this->addJSscript(WEB_ROOT.'/res/js/jquery-ui.min.js');
    $this->addJSscript(WEB_ROOT.'/res/js/appels_propositions_projets.js');
    parent::showHeader();
    echo "<h2>".$this->title."</h2>";
    if ($this->default_proposition_de_projet != NULL) {
      $this->showNewForm();
    }
    else if ($this->projets != NULL) {
      ?>
      <table border="1">
        <tr>
          <th>Numéro</th>
          <th>Proposition de projet de référence</th>
          <th>Organisme</th>
          <th>Date de publication de l'appel</th>
          <th>Date début</th>
          <th>Date de fin</th>
          <th>Supprimer</th>
        </tr>
        <?php
        $i = 0;
        foreach ($this->projets as $ap): ?>
        <tr id="row<?= ++$i ?>">
          <td><?= $ap->getNumero() ?></td>
          <td><?= $ap->getAppel() ?></td>
          <td><?= $ap->getOrganisme() ?></td>
          <td><?= $ap->getPublication_appel() ?></td>
          <td><?= $ap->getDate_debut() ?></td>
          <td><?= $ap->getDate_fin() ?></td>
          <td class="center middle">
            <a class="membre-labo" href="javascript:void(0);" onclick="supprimerPropositionOuProjet('<?= WEB_ROOT ?>/projets/delete', '<?= $i ?>','<?= urlencode($ap->getNumero()) ?>', '<?= urlencode($ap->getAppel()) ?>', '<?= urlencode($ap->getOrganisme()) ?>', '<?= urlencode($ap->getPublication_appel()) ?>','<?= WEB_ROOT ?>/projets')" ><img src="<?= WEB_ROOT ?>/res/img/delete.png" /></a>
          </td>
        </tr>
    <?php endforeach; ?>
      </table>
      <?php
    }
    else {
      echo "<h3 class='error'>Aucun projet à afficher.</h3>";
    }
    parent::showFooter();
  }
}