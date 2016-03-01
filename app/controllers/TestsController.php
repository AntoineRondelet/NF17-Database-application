<?php

class TestsController extends Controller {

  public function execute($action = 'index') {

    $depense = new Depense();
    $depenses = $depense->getAll();
    foreach ($depenses as $d) {
      echo $d;
    }
  }
}
