<?php
class Lignes_budgetaire extends Model {  
	private $numero;
	private $appel;
	private $organisme;
	private $publication_appel;   
	private $objet;
	private $montant;
	private $type;
	
	
     
	function __construct($numero = NULL,$appel = NULL,$organisme = NULL,$publication_appel = NULL,$objet = NULL,$montant = NULL,$type = NULL) {
		parent::__construct();
		$this->numero						= $numero; 
		$this->appel						= $appel; 
		$this->organisme					= $organisme; 
		$this->publication_appel			= $publication_appel;    
		$this->objet						= $objet;
		$this->montant						= $montant;
		$this->type							= $type;
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
	public function getObjet() {
		return $this->objet;
	}
	public function getMontant() {
		return $this->montant;
	}
	public function getType() {
		return $this->type;
	}

	
	

	public function setNumero($numero) {  
		$this->numero					= $numero;
	}
	public function setAppel($appel) {
		$this->appel					= $appel;
		}
	public function setOrganisme($organisme) {
		$this->organisme				= $organisme;
	}
	public function setPublication_appel($publication_appel) {  
		$this->publication_appel		= $publication_appel;
	}
	public function setObjet($objet) {
		$this->objet				= $objet;
		}
	public function setMontant($montant) {
		$this->montant			= $montant;
	}
	public function setType($type) {
		$this->type			= $type;
	}
	
	public function addToDB() {
		if ($this->numero !== NULL && $this->appel !== NULL && !empty($this->appel) && $this->organisme !== NULL && !empty($this->organisme) && $this->publication_appel !== NULL && $this->objet !== NULL && !empty($this->objet) && $this->montant !== NULL && $this->type !== NULL && !empty($this->type)) {

			 $sql = "INSERT INTO ".get_class($this)." VALUES (:numero, :appel, :organisme, :publication_appel, :objet, :montant, :type)";
			 $params = array(':numero'			 			=>$this->numero,
			 				 ':appel'	       				=>$this->appel,
			 				 ':organisme' 					=>$this->organisme,
			 				 ':publication_appel'			=>$this->publication_appel,
			 				 ':objet'			 			=>$this->objet,
			 				 ':montant'	       				=>$this->montant,
			 				 ':type' 						=>$this->type);
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
    $sql = "DELETE FROM ".get_class($this)." WHERE numero=:numero AND appel=:appel AND organisme=:organisme AND publication_appel=:publication_appel AND objet=:objet";
    $params = array(':numero'			 			=>$this->numero,
			 		':appel'	       				=>$this->appel,
			 		':organisme' 					=>$this->organisme,
			 		':publication_appel'			=>$this->publication_appel,
			 		':objet'			 			=>$this->objet);
    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==True && $query->rowCount()==1?"Donne_label supprimé avec succès":"ERREUR: Ce Donne_label a sûrement déjà été supprimé";


}

}


