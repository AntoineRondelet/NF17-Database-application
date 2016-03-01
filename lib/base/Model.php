<?php

require_once(ROOT_PATH.'/config/db.php');

abstract class Model {
  protected $db;

  public function __construct() {
    $this->db = connectDB();
  }

  public function __destruct() {
    $this->db = NULL;
  }

  public function getAll($filter = '') {
    $res = $this->db->query("SELECT * from ".get_called_class()." ".$filter); // resultat de la requete contenu dans $res
    $rows = $res->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, get_called_class());
    return $rows;
  }
}