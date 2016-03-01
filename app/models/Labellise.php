<?php
class Labellise extends Model {
	private $nom_du_label;
	private $numero;
	private $appel;
	private $organisme;
	private $publication_appel;
	

	
	function __construct($nom_du_label = null,$numero = null,$appel = null,$organisme = null,$publication_appel = null) {
		parent::__construct();
		$this->nom_du_label			= $nom_du_label;
		$this->numero				= $numero; 
		$this->appel				= $appel; 
		$this->organisme   			= $organisme;
		$this->publication_appel	= $publication_appel; 
	}

	public function getNom_du_label() {
		return $this->nom_du_label;
	}
	public function getNumero() {
		return $this->numero;
	}
	public function getAppel() {
		return $this->appel;
	}
	public function getOrganisme() {
		return $this->organisme;
	}
	public function getPublication_appel() {
		return $this->publication_appel;
	}

	public function setNom_du_label($nom_du_label) {  
		$this->nom_du_label		= $nom_du_label;
	}
	public function setNumero($numero) {  
		$this->numero			= $numero;
	}
	public function setAppel($appel) {
		$this->appel			= $appel;
		}
	public function setOrganisme($organisme) {
		$this->organisme		= $organisme;
	}
	public function setPublication_appel($publication_appel) {
		$this->publication_appel= $publication_appel;
	}
	
	public function addToDB() {
		if ($this->nom_du_label !== NULL && !empty($this->nom_du_label) && $this->numero !== NULL && $this->appel !== NULL && !empty($this->appel) && $this->organisme !== NULL && !empty($this->organisme) && $this->publication_appel !== NULL) {

			 $sql = "INSERT INTO ".get_class($this)." VALUES (:nom_du_label, :numero, :appel, :organisme, :publication_appel)";
			 $params = array(':nom_du_label'				=>$this->nom_du_label,
			 				 ':numero'			 			=>$this->numero,
			 				 ':appel'	       				=>$this->appel,
			 				 ':organisme' 					=>$this->organisme,
			 				 ':publication_appel'			=>$this->publication_appel);
			// TODO METTRE A TRUE statut dans proposition
	    $query = $this->db->prepare($sql);
	    $res = $query->execute($params);
	    return $res==1?"Labellise créé !":"Bizarre, on ne sait pas ce qu'il s'est passé...";
    } else {
    	throw new Exception("Il manque des informations pour enregistrer ce nouveau labellise en base de données");
    }
	}

	public function deleteFromDB() {
		// TODO vérifier que les champs requis ne sont pas NULL dans l'objet
    $sql = "DELETE FROM ".get_class($this)." WHERE nom_du_label=:nom_du_label AND numero=:numero AND appel=:appel AND organisme =:organisme AND publication_appel=:publication_appel";
    $params = array(':nom_du_label'					=>$this->nom_du_label,
			 		':numero'			 			=>$this->numero,
			 		':appel'	       				=>$this->appel,
			 		':organisme' 					=>$this->organisme,
			 		':publication_appel'			=>$this->publication_appel);
    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==True && $query->rowCount()==1?"labellise supprimé avec succès":"ERREUR: Ce labellise a sûrement déjà été supprimé";


}

	
}

