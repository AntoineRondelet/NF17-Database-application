<?php
class Participant_externe extends Model {
	private $id;
	private $numero;
	private $appel;
	private $organisme;
	private $publication_appel;
	

	
	function __construct($id = null,$numero = null,$appel = null,$organisme = null,$publication_appel = null) {
		parent::__construct();
		$this->id					= $id;
		$this->numero				= $numero; 
		$this->appel				= $appel; 
		$this->organisme   			= $organisme;
		$this->publication_appel	= $publication_appel; 
		
	}



	public function getId() {
		return $this->id;
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
	
	

	
	

	public function setId($id) {  
		$this->id				= $id;
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
		if ($this->id !== NULL && $this->numero !== NULL && !empty($this->numero) && $this->appel !== NULL && !empty($this->appel) && $this->organisme !== NULL && !empty($this->organisme) && $this->publication_appel !== NULL && !empty($this->publication_appel)) {

			 $sql = "INSERT INTO ".get_class($this)." VALUES (:id, :numero, :appel, :organisme, :publication_appel)";
			 $params = array(':id'						=>$this->id,
			 				 ':numero'			 		=>$this->numero,
			 				 ':appel'	       			=>$this->appel,
			 				 ':organisme' 				=>$this->organisme,
			 				 ':publication_appel'		=>$this->publication_appel);
			// TODO METTRE A TRUE statut dans proposition
	    $query = $this->db->prepare($sql);
	    $res = $query->execute($params);
	    return $res==1?"Participant externe créé !":"Bizarre, on ne sait pas ce qu'il s'est passé...";
    } else {
    	throw new Exception("Il manque des informations pour enregistrer ce nouveau participant externe en base de données");
    }
	}

public function deleteFromDB() {
		// TODO vérifier que les champs requis ne sont pas NULL dans l'objet
    $sql = "DELETE FROM ".get_class($this)." WHERE id=:id AND numero=:numero AND appel=:appel AND organisme=:organisme AND publication_appel=:publication_appel";
    $params = array(':id'						=>$this->id,
			 		':numero'			 		=>$this->numero,
			 		':appel'	       			=>$this->appel,
			 		':organisme' 				=>$this->organisme,
			 		':publication_appel'		=>$this->publication_appel);
    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==True && $query->rowCount()==1?"Participant externe supprimé avec succès":"ERREUR: Ce Participant externe a sûrement déjà été supprimé";


}
	
	
}


