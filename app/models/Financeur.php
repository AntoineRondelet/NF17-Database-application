<?php
class Financeur extends Entite_juridique {

	private $date_debut;
	private $date_fin;

	
	function __construct($id = null, $nom = null, $type = null, $date_debut = null, $date_fin = null) {
		parent::__construct($id,$nom,$type);
		$this->date_debut   		= $date_debut;
		$this->date_fin				= $date_fin;
		if (strtotime($date_debut) > strtotime($date_fin))
			throw new Exception("Le date de début doit être avant la date de fin.");
	}


	public function getDate_debut() {
		return $this->date_debut;
	}
	public function getDate_fin() {
		return $this->date_fin;
	}
	
	public function setDate_debut($date_debut) {
		$this->date_debut				= $date_debut;
	}
	public function setDate_fin($date_fin) {
		$this->date_fin					= $date_fin;
	}

	public function addToDB() {
		if ($this->date_debut !== NULL && !empty($this->date_debut) && $this->date_fin !== NULL && !empty($this->date_fin)) {
			 $this->id = parent::addToDB();
			 $sql = "INSERT INTO ".__CLASS__." VALUES (:id, :date_debut, :date_fin)";
			 $params = array(':id' 		      =>$this->id,
			 								 ':date_debut'	=>$this->date_debut,
			 				 				 ':date_fin'	 	=>$this->date_fin);
	    $query = $this->db->prepare($sql);
	    $res = $query->execute($params);
	    return $res==1?"Financeur créé !":"Bizarre, on ne sait pas ce qu'il s'est passé...";
    } else {
    	throw new Exception("Il manque des informations pour enregistrer ce nouveau financeur en base de données");
    }
	}

	public function getAll($filter = '') {
    $res = $this->db->query("SELECT * from ".get_called_class()." ME, ".get_parent_class()." P WHERE P.id = ME.id"); // resultat de la requete contenu dans $res
    $rows = $res->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, get_called_class());
    return $rows;
  }

	public function deleteFromDB() {
		// TODO vérifier que les champs requis ne sont pas NULL dans l'objet
    $sql = "DELETE FROM ".get_class($this)." WHERE id = :id";
    $params = array(		 ':id'				=>$this->id);
    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==True && $query->rowCount()==1?"Financeur supprimé avec succès":"ERREUR: Ce financeur a sûrement déjà été supprimé";
	}
	
}
