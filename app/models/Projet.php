<?php
class Projet extends Model {  
	private $numero;
	private $appel;
	private $organisme;
	private $publication_appel;   
	private $date_debut;
	private $date_fin;
	
	
     
	function __construct($numero = NULL,$appel = NULL,$organisme = NULL,$publication_appel = NULL,$date_debut = NULL,$date_fin = NULL) {
		parent::__construct();
		$this->numero						= $numero; 
		$this->appel						= $appel; 
		$this->organisme					= $organisme; 
		$this->publication_appel			= $publication_appel;    
		$this->date_debut					= $date_debut;
		$this->date_fin						= $date_fin;
		if (strtotime($date_debut) > strtotime($date_fin))
			throw new Exception("Le date de début doit être avant la date de fin.");
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
	public function getDate_debut() {
		return $this->date_debut;
	}
	public function getDate_fin() {
		return $this->date_fin;
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
	public function setDate_debut($date_debut) {
		$this->date_debut				= $date_debut;
		}
	public function setDate_fin($date_fin) {
		$this->date_fin			= $date_fin;
	}

	public function addToDB() {
		if ($this->numero !== NULL && !empty($this->numero) && $this->appel !== NULL && !empty($this->appel) && $this->organisme !== NULL && !empty($this->organisme) && $this->publication_appel !== NULL && !empty($this->publication_appel) && $this->date_debut !== NULL && !empty($this->date_debut) && $this->date_fin !== NULL && !empty($this->date_fin)) {

			 $sql = "INSERT INTO ".get_class($this)." VALUES (:numero, :appel, :organisme, :publication_appel, :date_debut, :date_fin)";
			 $params = array(':numero'				=>$this->numero,
			 				 ':appel'			 	=>$this->appel,
			 				 ':organisme'	        =>$this->organisme,
			 				 ':publication_appel' 	=>$this->publication_appel,
			 				 ':date_debut'			=>$this->date_debut,
			 				 ':date_fin'			=>$this->date_fin);
			// TODO METTRE A TRUE statut dans proposition
	    $query = $this->db->prepare($sql);
	    $res = $query->execute($params);
	    return $res==1?"Projet créé !":"Bizarre, on ne sait pas ce qu'il s'est passé...";
    } else {
    	throw new Exception("Il manque des informations pour enregistrer ce nouveau projet en base de données");
    	}
	}
	
	
	public function deleteFromDB() {
		// TODO vérifier que les champs requis ne sont pas NULL dans l'objet
    $sql = "DELETE FROM ".get_class($this)." WHERE numero=:numero AND appel=:appel AND organisme=:organisme AND publication_appel=:publication_appel";
    $params = array(':numero'							=>$this->numero,
    								':appel'	 						=>$this->appel,
    								':organisme'	 				=>$this->organisme,
    								':publication_appel'	=>$this->publication_appel);
    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==True && $query->rowCount()==1?"Projet supprimé avec succès":"ERREUR: Ce projet a sûrement déjà été supprimé";
  }
	
}


