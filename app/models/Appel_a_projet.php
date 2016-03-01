<?php
class Appel_a_projet extends Model {
	private $nom;
	private $organisme;
	private $publication;
	private $duree;
	private $theme;
	private $description;
	private $comite;
	
	function __construct($nom = null, $organisme = null, $publication = 'now()',$duree = null,$theme = null, $description = null, $comite = null) {
		parent::__construct();
		$this->nom						= $nom; 
		$this->organisme				= $organisme; 
		$this->publication				= $publication==null?'now()':$publication; 
		$this->duree					= $duree;
		$this->theme					= $theme;
		$this->description				= $description;
		$this->comite					= $comite;
	}

	public function getNom() {
		return $this->nom;
	}
	public function getOrganisme() {
		return $this->organisme;
	}
	public function getPublication() {
		return $this->publication;
	}
	public function getDuree() {
		return $this->duree;
	}
	public function getTheme() {
		return $this->theme;
	}
	public function getDescription() {
		return $this->description;
	}
	public function getComite() {
		return $this->comite;
	}
	
	public function setNom($nom) {  
		$this->nom				= $nom;
	}
	public function setOrganisme($organisme) {
		$this->organisme		= $organisme;
		}
	public function setPublication($publication) {
		$this->publication		= $publication;
	}
	public function setDuree($duree) {  
		$this->duree			= $duree;
	}
	public function setTheme($theme) {
		$this->theme			= $theme;
		}
	public function setDescription($description) {
		$this->description		= $description;
	}
	public function setComite($comite) {
		$this->comite			= $comite;
	}

	public function addToDB() {
		// TODO vérifier que les champs NOT NULL ne sont pas NULL dans l'objet
    $sql = "INSERT INTO ".get_class($this)." VALUES (:nom, :organisme, :publication, :duree, :theme, :description, :comite)";
    $params = array(':nom'							=>$this->nom,
    				':organisme'	 				=>$this->organisme,
    				':publication'					=>$this->publication,
    				':duree'						=>$this->duree,
    				':theme'						=>$this->theme,
    				':description'					=>$this->description,
    				':comite'		 				=>$this->comite);
    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==True?"Appel à projet soumis avec succès":"Erreur inconnue...";
  }

  public function deleteFromDB() {
		// TODO vérifier que les champs requis ne sont pas NULL dans l'objet
    $sql = "DELETE FROM ".get_class($this)." WHERE nom=:nom AND organisme=:organisme AND publication=:publication";
    $params = array(':nom'						=>$this->nom,
    								':organisme'	 		=>$this->organisme,
    								':publication'		=>$this->publication);
    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==True && $query->rowCount()==1?"Appel à projet supprimé avec succès":"ERREUR: Cet appel à projet a sûrement déjà été supprimé";
  }
}


