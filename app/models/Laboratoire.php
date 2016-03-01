<?php
class Laboratoire extends Entite_juridique {

	public function __construct($id = null,$nom = null,$type = null) {
		parent::__construct($id,$nom,$type);	
	}

  public function __toString() {
    return "id : ".$this->id."<br />".$this->nom."<br />Type : ".$this->type;
  }

  public function addToDB() {
    $this->id = parent::addToDB();
    $sql = "INSERT INTO ".__CLASS__." VALUES (:id)";
    $params = array(':id'       =>$this->id);
    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==1?"Laboratoire créé !":"Bizarre, on ne sait pas ce qu'il s'est passé...";
  }

  public function getAll($filter = '') {
    $res = $this->db->query("SELECT * from ".get_called_class()." ME, ".get_parent_class()." P WHERE P.id = ME.id"); // resultat de la requete contenu dans $res
    $rows = $res->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, get_called_class());
    return $rows;
  }
}
