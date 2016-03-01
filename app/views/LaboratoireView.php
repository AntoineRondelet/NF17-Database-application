<?php

class LaboratoireView extends DefaultView {
  
  private $labos;

  public function __construct() {
    parent::setTitle("Création de laboratoire");
  }

  public function setLaboratoires($labs) {
    $this->labos = $labs;
  }

  private function showNewForm(){?>
<form method="POST" action="<?= WEB_ROOT ?>/laboratoires/new" >
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
      <td></td>
      <td><input type="submit" value="Créer le laboratoire" /></td>
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
    $this->addJSscript(WEB_ROOT.'/res/js/jquery-2.1.4.min.js');
    $this->addJSscript(WEB_ROOT.'/res/js/entites_juridiques.js');
    parent::showHeader();
    echo "<h2>".$this->title."</h2>";
    $this->showNewForm();
    if ($this->labos !== NULL) {
      ?>
      <h3>Laboratoires existants</h3>
      <table border="1">
        <tr>
          <th>Id</th>
          <th>Nom</th>
          <th>Type</th>
          <th>Supprimer</th>
        </tr>
        <?php
        $i = 0;
        foreach ($this->labos as $labo): ?>
        <tr id="row<?= ++$i ?>">
          <td><?= $labo->getId() ?></td>
          <td><?= $labo->getNom() ?></td>
          <td><?= $labo->getType() ?></td>
          <td class="center middle">
            <a href="javascript:void(0);" onclick="supprimerEntite('<?= WEB_ROOT ?>/entites_juridiques/delete', '<?= $i ?>','<?= urlencode($labo->getId()) ?>','<?= WEB_ROOT ?>/laboratoires')" ><img src="<?= WEB_ROOT ?>/res/img/delete.png" /></a>
          </td>
        </tr>
    <?php endforeach; ?>
      </table>
      <?php
    }
    parent::showFooter();
  }
  
}
