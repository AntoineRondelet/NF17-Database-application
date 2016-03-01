<?php

class FinanceurView extends DefaultView {
  
  private $financeurs;
  private $employes_contact;

  public function __construct() {
    parent::setTitle("Création d'un financeur");
  }

  public function setFinanceurs($fina) {
    $this->financeurs = $fina;
  }

  public function setEmployes_contact($emp) {
    $this->employes_contact = $emp;
  }

  private function showNewForm(){?>
<form method="POST" action="<?= WEB_ROOT ?>/financeurs/new" >
  <table>
    <tr>
      <td><label class="required" for="nom">Nom</label></td>
      <td><input required name="nom" id="nom" type="text" /></td>
    </tr>

    <tr>
      <td><label class="required" for="type">Type</label></td>
      <td><input required name="type" id="type" type="text" /></td>
    </tr>
    <tr>
      <td><label class="required" for="debut">Date de début</label></td>
      <td><input class="datepicker" required type="date" id="debut" name="date_debut" /></td>
    </tr>
    <tr>
      <td><label class="required" for="fin">Date de fin</label></td>
      <td><input class="datepicker" required type="date" id="fin" name="date_fin" /></td>
    </tr>
  </table>
    <h3>Employé contact de ce financeur</h3>
  <table>
    <tr>
      <td><label class="required" for="emp_nom">Nom</label></td>
      <td><input required name="emp_nom" id="emp_nom" type="text" /></td>
    </tr>
    <tr>
      <td><label class="required" for="emp_pwd">Password</label></td>
      <td><input required name="emp_pwd" id="emp_pwd" type="password" /></td>
    </tr>
    <tr>
      <td><label class="required" for="emp_mail">Mail</label></td>
      <td><input required name="emp_mail" id="emp_mail" type="email" /></td>
    </tr>
    <tr>
      <td><label class="required" for="emp_tel">Téléphone</label></td>
      <td><input required name="emp_tel" id="emp_tel" type="text" /></td>
    </tr>
    <tr>
      <td><label class="required" for="emp_titre">Titre</label></td>
      <td><input required name="emp_titre" id="emp_titre" type="text" /></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" value="Créer le laboratoire et l'employé" /></td>
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
    $this->addJSscript(WEB_ROOT.'/res/js/entites_juridiques.js');
    parent::showHeader();
    echo "<h2>".$this->title."</h2>";
    $this->showNewForm();
    if ($this->financeurs !== NULL && $this->employes_contact !== NULL) {
      ?>
      <h3>Financeurs existants</h3>
      <table border="1">
        <tr>
          <th>Id</th>
          <th>Nom</th>
          <th>Type</th>
          <th>Date début</th>
          <th>Date fin</th>
          <th>Supprimer le financeur</th>
          <th>Employé contact</th>
        </tr>
        <?php
        $i = 0;
        $counterForEmployes = 0; // compteur pour lire le tableau d'employés contact
        foreach ($this->financeurs as $financeur): ?>
        <tr id="row<?= ++$i ?>">
          <td><?= htmlspecialchars($financeur->getId()) ?></td>
          <td><?= htmlspecialchars($financeur->getNom()) ?></td>
          <td><?= htmlspecialchars($financeur->getType()) ?></td>
          <td><?= htmlspecialchars($financeur->getDate_debut()) ?></td>
          <td><?= htmlspecialchars($financeur->getDate_fin()) ?></td>
          <td class="center middle">
            <a href="javascript:void(0);" onclick="supprimerEntite('<?= WEB_ROOT ?>/entites_juridiques/delete', '<?= $i ?>','<?= urlencode($financeur->getId()) ?>','<?= WEB_ROOT ?>/financeurs')" ><img src="<?= WEB_ROOT ?>/res/img/delete.png" /></a>
          </td>
          <td>
          <?php
          test:
          if($this->employes_contact[$counterForEmployes]->getFinanceur() === $financeur->getId())
                echo $this->employes_contact[$counterForEmployes++];
          else
            echo "Aucun employé contact assigné";
          ?>
          </td>
        </tr>
    <?php endforeach; ?>
      </table>
      <?php
    }
    parent::showFooter();
  }
  
}
