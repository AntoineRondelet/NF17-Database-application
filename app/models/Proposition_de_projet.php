<?php
class Proposition_de_projet extends Model {
	private $numero;
	private $appel;
	private $organisme;
	private $publication_appel;
	private $date_reponse;
	private $date_emission;
	private $statut;



	function __construct($numero = NULL,$appel = NULL,$organisme = NULL,$publication_appel = NULL,$date_reponse = NULL,$date_emission = NULL,$statut = NULL) {
		parent::__construct();
		$this->numero						= $numero;
		$this->appel						= $appel;
		$this->organisme					= $organisme;
		$this->publication_appel			= $publication_appel;
		$this->date_reponse					= $date_reponse;
		$this->date_emission				= $date_emission;
		$this->statut						= $statut;
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
	public function getDate_reponse() {
		return $this->date_reponse;
	}
	public function getDate_emission() {
		return $this->date_emission;
	}
	public function getStatut() {
		return $this->statut;
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
	public function setDate_reponse($date_reponse) {
		$this->date_reponse				= $date_reponse;
	}
	public function setDate_emission($date_emission) {
		$this->date_emission			= $date_emission;
	}
	public function setStatut($statut) {
		$this->statut					= $statut;
	}

	public function getNew(){
		if ($this->appel !== NULL && !empty($this->appel) && $this->organisme !== NULL && !empty($this->organisme) && $this->publication_appel !== NULL && !empty($this->publication_appel)) {

			$sql = "SELECT 1+coalesce((SELECT numero FROM ".get_class($this)." WHERE appel=:appel AND organisme=:organisme AND publication_appel=:publication_appel ORDER BY numero DESC LIMIT 1),0) AS num";
		$params = array(':appel'			 =>$this->appel,
									':organisme'	 =>$this->organisme,
									':publication_appel'=>$this->publication_appel);
		$query = $this->db->prepare($sql);
		$res = $query->execute($params);
		$retour = $query->fetch(PDO::FETCH_ASSOC);
		return $retour;
		} else {
		throw new Exception("Il manque des informations pour identifier le numéro de proposition");
		}
	}
	public function addToDB() {
		if ($this->appel !== NULL && !empty($this->appel) && $this->organisme !== NULL && !empty($this->organisme) && $this->publication_appel !== NULL && !empty($this->publication_appel)) {

			$sql = "INSERT INTO ".get_class($this)." VALUES (
				(SELECT 1+coalesce((SELECT numero FROM ".get_class($this)." WHERE appel=:appel AND organisme=:organisme AND publication_appel=:publication_appel ORDER BY numero DESC LIMIT 1),0)),
				:appel, :organisme, :publication_appel, NULL, now(), False)";
	    $params = array(':appel'			 =>$this->appel,
	    							 ':organisme'	 =>$this->organisme,
	    							 ':publication_appel'=>$this->publication_appel);
	    $query = $this->db->prepare($sql);
	    $res = $query->execute($params);
	    return $res==1?"Proposition soumise avec succès\n":"Bizarre, on ne sait pas ce qu'il s'est passé...";
    } else {
    	throw new Exception("Il manque des informations pour enregistrer cette nouvelle proposition en base de données");
    }
	}

	public function deleteFromDB() {
		// TODO vérifier que les champs requis ne sont pas NULL dans l'objet
    $sql = "DELETE FROM ".get_class($this)." WHERE numero=:numero AND appel=:appel AND organisme=:organisme AND publication_appel=:publication_appel";
    $params = array(':numero'						=>$this->numero,
    								':appel'	 		=>$this->appel,
    								':organisme'	 		=>$this->organisme,
    								':publication_appel'		=>$this->publication_appel);
    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==True && $query->rowCount()==1?"Proposition de projet supprimé avec succès":"ERREUR: Cet appel à projet a sûrement déjà été supprimé";
  }

}
