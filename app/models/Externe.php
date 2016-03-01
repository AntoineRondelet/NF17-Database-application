<?php
class Externe extends Model {
	private $id;
	private $nom;
	private $password;
	private $mail;
	private $telephone;
	private $validateur;
	private $entite;

	
	function __construct($id = null,$nom = null, $password = null, $mail = null,$telephone = null,$validateur = null,$entite = null) {
		parent::__construct();
		$this->id					= $id;  
		$this->nom   				= $nom;
		$this->password 			= $password;
		$this->mail					= $mail; 
		$this->telephone			= $telephone;
		$this->validateur			= $validateur;
		$this->entite				= $entite;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($pwd) {
		$this->password = $pwd;
	}

	public function __toString() {
		return "Externe ".$this->nom;
	}

	public function getId() {
		return $this->id;
	}
	public function getNom() {
		return $this->nom;
	}
	public function getMail() {
		return $this->mail;
	}
	public function getTelephone() {
		return $this->telephone;
	}
	public function getValidateur() {
		return $this->validateur;
	}
	public function getEntite() {
		return $this->entite;
	}
	

	
	

	public function setId($id) {  
		$this->id				= $id;
	}
	public function setNom($nom) {
		$this->nom				= $nom;
	}
	public function setMail($mail) {
		$this->mail				= $mail;
	}
	public function setTelephone($telephone) {  
		$this->telephone		= $telephone;
	}
	public function setValidateur($validateur) {  
		$this->validateur		= $validateur;
	}
	public function setEntite($entite) {  
		$this->entite			= $entite;
	}
	
	public function addToDB() {
		if ($this->id !== NULL && $this->nom !== NULL && !empty($this->nom) && $this->password !== NULL && !empty($this->password) && $this->mail !== NULL && !empty($this->mail) && $this->telephone !== NULL && !empty($this->telephone) && $this->validateur !== NULL && !empty($this->validateur) && $this->entite !== NULL) {

			 $sql = "INSERT INTO ".get_class($this)." VALUES (:id, :nom, :password, :mail, :telephone, :validateur, :entite)";
			 $params = array(':id'				=>$this->id,
			 				 ':nom'			 	=>$this->nom,
			 				 ':password'						=>$this->password,
			 				 ':mail'	        =>$this->mail,
			 				 ':telephone' 		=>$this->telephone,
			 				 ':validateur'		=>$this->validateur,
			 				 ':entite'			=>$this->entite);
			// TODO METTRE A TRUE statut dans proposition
	    $query = $this->db->prepare($sql);
	    $res = $query->execute($params);
	    return $res==1?"Externe créé !":"Bizarre, on ne sait pas ce qu'il s'est passé...";
    } else {
    	throw new Exception("Il manque des informations pour enregistrer ce nouveau externe en base de données");
    }
	}
	
	
	public function deleteFromDB() {
		// TODO vérifier que les champs requis ne sont pas NULL dans l'objet
    $sql = "DELETE FROM ".get_class($this)." WHERE id=:id";
    $params = array(':id'			=>$this->id);
    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==True && $query->rowCount()==1?"Externe supprimé avec succès":"ERREUR: Ce Externe a sûrement déjà été supprimé";


}


}

