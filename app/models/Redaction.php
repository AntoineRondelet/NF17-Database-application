<?php
class Redaction extends Model {
	private $id;
	private $appel;
	private $organisme;
	private $publication_appel;
	private $numero;


	function __construct($id = null,$appel = null,$organisme = null,$publication_appel = null,$numero = null) {
		parent::__construct();
		$this->id					= $id;
		$this->appel				= $appel;
		$this->organisme   			= $organisme;
		$this->publication_appel	= $publication_appel;
		$this->numero				= $numero;
	}



	public function getId() {
		return $this->id;
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
	public function getNumero() {
		return $this->numero;
	}





	public function setId($id) {
		$this->id				= $id;
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
	public function setNumero($numero) {
		$this->numero			= $numero;
	}


	public function addToDB() {
		if ($this->id !== NULL && $this->appel !== NULL && !empty($this->appel) && $this->organisme !== NULL && !empty($this->organisme) && $this->publication_appel !== NULL && !empty($this->publication_appel) && $this->numero !== NULL) {

			 $sql = "INSERT INTO ".get_class($this)." VALUES (:id, :appel, :organisme, :publication_appel, :numero)";
			 $params = array(':id'					=>$this->id,
			 				 ':appel'			 	=>$this->appel,
			 				 ':organisme'	        =>$this->organisme,
			 				 ':publication_appel' 	=>$this->publication_appel,
			 				 ':numero'				=>$this->numero);
			// TODO METTRE A TRUE statut dans proposition
	    $query = $this->db->prepare($sql);
	    $res = $query->execute($params);
	    return $res==1?"Redaction créé !":"Bizarre, on ne sait pas ce qu'il s'est passé...";
    } else {
    	throw new Exception("Il manque des informations pour enregistrer ce nouveau redaction en base de données");
    }
	}


	public function deleteFromDB() {
		// TODO vérifier que les champs requis ne sont pas NULL dans l'objet
    $sql = "DELETE FROM ".get_class($this)." WHERE id=:id AND appel=:appel AND organisme=:organisme AND publication_appel=:publication_appel AND numero=:numero";
    $params = array(':id'					=>$this->id,
    				':appel'	 			=>$this->appel,
    				':organisme'	 		=>$this->organisme,
    				':publication_appel'	=>$this->publication_appel,
    				':numero'	 			=>$this->numero);
    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==True && $query->rowCount()==1?"Redaction supprimé avec succès":"ERREUR: Cette redaction a sûrement déjà été supprimé";
  }


}
