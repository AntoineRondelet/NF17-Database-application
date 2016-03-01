<?php
class Organisme_projet extends Model {
	protected $nom;
	private $date_creation;
	private $duree;

	function __construct($nom = null,$date_creation = null,$duree = null) {
		parent::__construct();
		$this->nom								= $nom;
		$this->date_creation			= $date_creation!==NULL?$date_creation:'now()';
		$this->duree							= $duree;
	}

	public function getNom() {
		return $this->nom;
	}
	public function getDate_creation() {
		return $this->date_creation;
	}
	public function getDuree() {
		return $this->duree;
	}

	public function setNom($nom) {
		$this->nom				= $nom;
	}
	public function setDate_creation($date_creation) {
		$this->date_creation	= $date_creation;
		}
	public function setDuree($duree) {
		$this->duree			= $duree;
	}

	public function addToDB() {
		if ($this->nom !== NULL && !empty($this->nom) && $this->date_creation !== NULL && !empty($this->date_creation) && $this->duree !== NULL) {

			 $sql = "INSERT INTO ".get_class($this)." VALUES (:nom, :date_creation, :duree) RETURNING nom";
			 $params = array(':nom'					=>$this->nom,
			 				 ':date_creation'		=>$this->date_creation,
			 				 ':duree'	        	=>$this->duree);
			// TODO METTRE A TRUE statut dans proposition
	    $query = $this->db->prepare($sql);
	    $res = $query->execute($params);
	    if ($res===True&&$query->rowCount()===1)
	    	return ($query->fetchAll());
		 else
	    	throw new Exception("Impossible de créer l'organisme projet");
    } else {
    	throw new Exception("Il manque des informations pour enregistrer ce nouvel organisme projet en base de données");
	}
	}

	public function deleteFromDB() {
		// TODO vérifier que les champs requis ne sont pas NULL dans l'objet
    $sql = "DELETE FROM ".get_class($this)." WHERE nom=:nom ";
    $params = array(':nom'			=>$this->nom);

    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==True && $query->rowCount()==1?"Organisme projet supprimé avec succès":"ERREUR: Cet organisme projet a sûrement déjà été supprimé";


}

}
