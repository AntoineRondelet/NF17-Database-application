<?php

class PropositionProjetView extends DefaultView {

  private $propositions_de_projets;

  public function __construct($title = "Liste des propositions de projet") {
    parent::setTitle($title);
  }

  public function setPropositions_de_projet($rows) {
    $this->propositions_de_projets = $rows;
  }

  public function renderView() {
    $this->addJSscript(WEB_ROOT.'/res/js/jquery-2.1.4.min.js');
    $this->addJSscript(WEB_ROOT.'/res/js/appels_propositions_projets.js');
    parent::showHeader();
    echo "<h2>".$this->title."</h2>";
    if ($this->propositions_de_projets == NULL)
      echo "<h3 class='error'>Aucune proposition actuellement</h3>";
    else {
      ?>
      <table border="1">
        <tr>
          <th>Numéro</th>
          <th>Appel de projet de référence</th>
          <th>Organisme</th>
          <th>Date de publication de l'appel</th>
          <th>Date de réponse</th>
          <th>Date d'émission</th>
          <th>Status</th>
          <th>Transformer en projet</th>
          <th>Supprimer cette proposition</th>
        </tr>
        <?php
        $i = 0;
        foreach ($this->propositions_de_projets as $ap): ?>
        <tr id="row<?= ++$i ?>">
          <td><?= $ap->getNumero() ?></td>
          <td><?= $ap->getAppel() ?></td>
          <td><?= $ap->getOrganisme() ?></td>
          <td><?= $ap->getPublication_appel() ?></td>
          <td><?= $ap->getDate_reponse() ?></td>
          <td><?= $ap->getDate_emission() ?></td>
          <td><?= $ap->getStatut() === True ? "Validé" : "En attente" ?></td>
          <td class="center middle">
            <?php if ($ap->getStatut() === False) { ?>
              <a href="<?= WEB_ROOT ?>/projets/new?numero=<?= urlencode($ap->getNumero()) ?>&nom=<?= urlencode($ap->getAppel()) ?>&organisme=<?= urlencode($ap->getOrganisme()) ?>&publication=<?= urlencode($ap->getPublication_appel()) ?>" ><img class="employe-contact" src="<?= WEB_ROOT ?>/res/img/add.png" /></a>
            <?php }
            else {
              echo "Projet existant pour cette proposition";
            } ?>
          </td>
          <td class="center middle">
            <a class="membre-labo" href="javascript:void(0);" onclick="supprimerPropositionOuProjet('<?= WEB_ROOT ?>/projets/propositions/delete', '<?= $i ?>','<?= urlencode($ap->getNumero()) ?>', '<?= urlencode($ap->getAppel()) ?>', '<?= urlencode($ap->getOrganisme()) ?>', '<?= urlencode($ap->getPublication_appel()) ?>', '<?= WEB_ROOT ?>/projets/propositions');" ><img src="<?= WEB_ROOT ?>/res/img/delete.png" /></a>
          </td>
        </tr>
        <?php endforeach; ?>
      </table>
      <?php
    }
    parent::showFooter();
  }
}