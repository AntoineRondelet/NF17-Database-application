<?php
class Label extends Model {
	private $nom_du_label;

	public function __construct($nom_du_label = null) {
		parent::__construct();
		$this->nom_du_label = $nom_du_label;
	}

	public function getNom_du_label() {
		return $this->nom_du_label;
	}

	public function setNom_du_label($nom_du_label) {
		$this->nom_du_label = $nom_du_label;
	}
	
	public function addToDB() {
		if ($this->nom_du_label !== NULL && !empty($this->nom_du_label)) {

			 $sql = "INSERT INTO ".get_class($this)." VALUES (:nom_du_label)";
			 $params = array(':nom_du_label'	=>$this->nom_du_label);
			// TODO METTRE A TRUE statut dans proposition
	    $query = $this->db->prepare($sql);
	    $res = $query->execute($params);
	    return $res==1?"Label créé !":"Bizarre, on ne sait pas ce qu'il s'est passé...";
    } else {
    	throw new Exception("Il manque des informations pour enregistrer ce nouveau label en base de données");
    }
	}
	
	public function deleteFromDB() {
		// TODO vérifier que les champs requis ne sont pas NULL dans l'objet
    $sql = "DELETE FROM ".get_class($this)." WHERE nom_du_label=:nom_du_label ";
    $params = array(':nom_du_label'			=>$this->nom_du_label);
    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==True && $query->rowCount()==1?"Label supprimé avec succès":"ERREUR: Ce label a sûrement déjà été supprimé";


}


}