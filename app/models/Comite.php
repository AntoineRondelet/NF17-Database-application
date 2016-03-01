<?php
class Comite extends Model {
	protected $nom;

	function __construct($nom = null) {
		parent::__construct();
		$this->nom = $nom;
	}

	public function getNom() {
		return $this->nom;
	}

	public function setNom($nom) {
		$this->nom = $nom;
	}
	
	public function addToDB() {
		if ($this->nom !== NULL && !empty($this->nom)) {

			 $sql = "INSERT INTO ".get_class($this)." VALUES (:nom)";
			 $params = array('nom'				=>$this->nom);
			// TODO METTRE A TRUE statut dans proposition
	    $query = $this->db->prepare($sql);
	    $res = $query->execute($params);
	    return $res==1?"Comite créé !":"Bizarre, on ne sait pas ce qu'il s'est passé...";
    } else {
    	throw new Exception("Il manque des informations pour enregistrer ce nouveau comite en base de données");
    }
	}
	
	public function deleteFromDB() {
		// TODO vérifier que les champs requis ne sont pas NULL dans l'objet
    $sql = "DELETE FROM ".get_class($this)." WHERE nom=:nom";
    $params = array(':nom'			=>$this->nom);
    
    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==True && $query->rowCount()==1?"Comite supprimé avec succès":"ERREUR: Ce comite a sûrement déjà été supprimé";


}
}

