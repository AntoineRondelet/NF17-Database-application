<?php

class OrganismeProjetView extends DefaultView {

  private $organismes_projet;
  private $financeurs;

  public function __construct() {
    parent::setTitle("Création d'un organisme projet");
  }

  public function setOrganismes_projet($o) {
    $this->organismes_projet = $o;
  }

  public function setFinanceurs($f) {
    $this->financeurs = $f;
  }

  private function showNewForm(){?>
<form method="POST" action="<?= WEB_ROOT ?>/financeurs/organismes/new" >
  <table>
    <tr>
      <td><label class="required" for="nom">Nom</label></td>
      <td><input required name="nom" id="nom" type="text" /></td>
    </tr>
    <tr>
      <td><label for="duree">Durée de validité</label></td>
      <td><input value="3" class="spinner" type="text" id="duree" name="duree" /> jour(s)</td>
    </tr>
    <?php
     if ($_SESSION['login'] instanceof Employe_contact){
         echo "<tr><td><input type=\"hidden\" value=".htmlspecialchars($_SESSION['login']->getFinanceur())." id=\"financeur\" name=\"financeur\" /></td></tr>";
      }
      else if ($_SESSION['login'] === 'root'){?>
         <tr>
           <td><label class="required" for="financeur">Financeur</label></td>
           <td>
             <select required id="financeur" name="financeur">
               <?php foreach ($this->financeurs as $financeur): ?>
                  <option value="<?= $financeur->getId() ?>"><?= $financeur->getNom() ?></option>
               <?php endforeach;?>
             </select>
           </td>
        </tr> <?php
     }?>
    	<tr>
      <td></td>
      <td><input type="submit" value="Créer l'organisme projet" /></td>
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
    $this->addJSscript(WEB_ROOT.'/res/js/entites_juridiques.js');
    parent::showHeader();
    echo "<h2>".$this->title."</h2>";
    $this->showNewForm();
    if ($this->organismes_projet !== NULL) {
      ?>
      <h3>Organismes projet existants</h3>
      <table border="1">
        <tr>
          <th>Nom</th>
          <th>Date création</th>
          <th>Durée de validité</th>
          <th>Supprimer l'organisme'</th>
        </tr>
        <?php
        $i = 0;
        foreach ($this->organismes_projet as $organisme_projet): ?>
        <tr id="row<?= ++$i ?>">
          <td><?= $organisme_projet->getNom() ?></td>
          <td><?= $organisme_projet->getDate_creation() ?></td>
          <td><?= $organisme_projet->getDuree() ?> jour(s)</td>
          <td class="center middle">
            <a href="javascript:void(0);" onclick="supprimerOrganismeProjet('<?= WEB_ROOT ?>/financeurs/organismes/delete', '<?= $i ?>','<?= urlencode($organisme_projet->getNom()) ?>','<?= WEB_ROOT ?>/financeurs/organismes')" ><img src="<?= WEB_ROOT ?>/res/img/delete.png" /></a>
          </td>
        </tr>
    <?php endforeach; ?>
      </table>
      <?php
    }
    parent::showFooter();
  }

}
