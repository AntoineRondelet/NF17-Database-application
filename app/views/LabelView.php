<?php

class LabelView extends DefaultView {
  private $labels;

  public function setLabels($labels) {
    parent::setTitle("Les labels");
    $this->labels = $labels;
  }

  public function renderView() {
    parent::showHeader();
    echo "<h2>Liste des labels</h2><table border=1>";
    foreach ($this->labels as $label) {
      echo "<tr><td>".$label->getNom_du_label()."</td></tr>";
    }
    echo "</table>";
    parent::showFooter();
  }
}