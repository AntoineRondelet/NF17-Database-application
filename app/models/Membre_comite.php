<?php
class Membre_comite extends Model {
	private $id;
	private $comite;
	private $nom;
	private $password;
	private $mail;
	private $telephone;

	
	function __construct($id = null,$comite = null,$nom = null, $password = null, $mail = null,$telephone = null) {
		parent::__construct();
		$this->id					= $id; 
		$this->comite				= $comite; 
		$this->nom   				= $nom;
		$this->password 			= $password;
		$this->mail					= $mail; 
		$this->telephone			= $telephone;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($pwd) {
		$this->password = $pwd;
	}

	public function getId() {
		return $this->id;
	}
	public function getComite() {
		return $this->comite;
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
	

	
	

	public function setId($id) {  
		$this->id				= $id;
	}
	public function setComite($comite) {
		$this->comite			= $comite;
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
	
	public function addToDB() {
		if ($this->id !== NULL && $this->comite !== NULL && !empty($this->comite) && $this->nom !== NULL && !empty($this->nom) && $this->password !== NULL && !empty($this->password) && $this->mail !== NULL && !empty($this->mail) && $this->telephone !== NULL && !empty($this->telephone)) {

			 $sql = "INSERT INTO ".get_class($this)." VALUES (
			 	(SELECT 1+coalesce((SELECT id FROM ".get_class($this)." WHERE comite = :comite ORDER BY id DESC LIMIT 1),0)),
			 	:id, :comite, :nom, :password, :mail, :telephone)";
			 $params = array(':id'						=>$this->id,
			 				 ':comite'			 		=>$this->comite,
			 				 ':nom'	       				=>$this->nom,
			 				 ':password'						=>$this->password,
			 				 ':mail' 					=>$this->mail,
			 				 ':telephone'				=>$this->telephone);
			// TODO METTRE A TRUE statut dans proposition
	    $query = $this->db->prepare($sql);
	    $res = $query->execute($params);
	    return $res==1?"Membre Comite créé !":"Bizarre, on ne sait pas ce qu'il s'est passé...";
    } else {
    	throw new Exception("Il manque des informations pour enregistrer ce nouveau membre_comite en base de données");
    }
	}
	
	
	public function deleteFromDB() {
		// TODO vérifier que les champs requis ne sont pas NULL dans l'objet
    $sql = "DELETE FROM ".get_class($this)." WHERE id=:id AND comite=:comite";
    $params = array(':id'			=>$this->id,
    				':comite'		=>$this->comite);
    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==True && $query->rowCount()==1?"Membre_comite supprimé avec succès":"ERREUR: Ce Membre_comite a sûrement déjà été supprimé";


}

	
}
