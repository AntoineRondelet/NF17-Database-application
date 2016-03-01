<?php
class Donne_label extends Model {
	private $nom_du_label;
	private $entite;
	
	
	function __construct($nom_du_label = null,$entite = null) {
		parent::__construct();
		$this->nom_du_label			= $nom_du_label;
		$this->entite				= $entite; 		
	}



	public function getNom_du_label() {
		return $this->nom_du_label;
	}
	public function getEntite() {
		return $this->entite;
	}

		
	

	public function setNom_du_label($nom_du_label) {  
		$this->nom_du_label		= $nom_du_label;
	}
	public function setEntite($entite) {  
		$this->entite			= $entite;
	}
		
	public function addToDB() {
		if ($this->nom_du_label !== NULL && !empty($this->nom_du_label) && $this->entite !== NULL) {

			 $sql = "INSERT INTO ".get_class($this)." VALUES (:nom_du_label, :entite)";
			 $params = array(':nom_du_label'				=>$this->nom_du_label,
			 				 ':entite'			 			=>$this->entite);
			// TODO METTRE A TRUE statut dans proposition
	    $query = $this->db->prepare($sql);
	    $res = $query->execute($params);
	    return $res==1?"Donne_label créé !":"Bizarre, on ne sait pas ce qu'il s'est passé...";
    } else {
    	throw new Exception("Il manque des informations pour enregistrer ce nouveau donne_label en base de données");
    }
	}
	
	public function deleteFromDB() {
		// TODO vérifier que les champs requis ne sont pas NULL dans l'objet
    $sql = "DELETE FROM ".get_class($this)." WHERE nom_du_label=:nom_du_label AND entite=:entite";
    $params = array(':nom_du_label'			=>$this->nom_du_label,
    				':entite'	 			=>$this->entite);
    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==True && $query->rowCount()==1?"Donne_label supprimé avec succès":"ERREUR: Ce Donne_label a sûrement déjà été supprimé";


}
}
