<?php
class Budget extends Model {  
	private $numero;
	private $appel;
	private $organisme;
	private $publication_appel;   
	private $budget_total;
	
	
     
	function __construct($numero = null,$appel = null,$organisme = null,$publication_appel = null,$budget_total = null) {
		parent::__construct();
		$this->numero						= $numero; 
		$this->appel						= $appel; 
		$this->organisme					= $organisme; 
		$this->publication_appel			= $publication_appel;    
		$this->budget_total					= $budget_total;
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
	public function getBudget_total() {
		return $this->budget_total;
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
	public function setBudget_total($budget_total) {
		$this->budget_total				= $budget_total;
	}
	
	public function addToDB() {
		if ($this->numero !== NULL && $this->appel !== NULL && !empty($this->appel) && $this->organisme !== NULL && !empty($this->organisme) && $this->publication_appel !== NULL && $this->budget_total !== NULL) {

			 $sql = "INSERT INTO ".get_class($this)." VALUES (:numero, :appel, :organisme, :publication_appel, :budget_total)";
			 $params = array('numero'				=>$this->numero,
			 				 ':appel'			 	=>$this->appel,
			 				 ':organisme'	        =>$this->organisme,
			 				 ':publication_appel' 	=>$this->publication_appel,
			 				 ':budget_total'			=>$this->budget_total);
			// TODO METTRE A TRUE statut dans proposition
	    $query = $this->db->prepare($sql);
	    $res = $query->execute($params);
	    return $res==1?"Budget créé !":"Bizarre, on ne sait pas ce qu'il s'est passé...";
    } else {
    	throw new Exception("Il manque des informations pour enregistrer ce nouveau budget en base de données");
    }
	}

	public function deleteFromDB() {
		// TODO vérifier que les champs requis ne sont pas NULL dans l'objet
    $sql = "DELETE FROM ".get_class($this)." WHERE numero=:numero AND appel=:appel AND organisme=:organisme AND publication_appel=:publication_appel AND budget_total=:budget_total";
    $params = array(':numero'					=>$this->numero,
    				':appel'	 				=>$this->appel,
    				':organisme'	 			=>$this->organisme,
    				':publication_appel'		=>$this->publication_appel);
    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==True && $query->rowCount()==1?"Budget supprimé avec succès":"ERREUR: Ce budget a sûrement déjà été supprimé";
  }

	
}

