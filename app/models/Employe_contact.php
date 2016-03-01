<?php
class Employe_contact extends Model {
	private $id;
	private $financeur;
	private $nom;
	private $password;
	private $mail;
	private $telephone;
	private $titre;

	
	function __construct($id = null,$financeur = null, $nom = null, $password = null, $mail = null,$telephone = null,$titre = null) {
		parent::__construct();
		$this->id					= $id; 
		$this->financeur			= $financeur; 
		$this->nom   				= $nom;
		$this->password 			= $password;
		$this->mail					= $mail; 
		$this->telephone			= $telephone;
		$this->titre				= $titre;
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
	public function getFinanceur() {
		return $this->financeur;
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
	public function getTitre() {
		return $this->titre;
	}

	
	

	public function setId($id) {  
		$this->id				= $id;
	}
	public function setFinanceur($financeur) {
		$this->financeur		= $financeur;
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
	public function setTitre($titre) {
		$this->titre			= $titre;
	}
	
	public function __toString() {
        return "Nom : ".$this->nom."<br />Email : ".$this->mail."<br />Titre : ".$this->titre;
  }

	public function addToDB() {
		if ($this->financeur !== NULL && $this->nom !== NULL && !empty($this->nom) && $this->password !== NULL && !empty($this->password) && $this->mail !== NULL && !empty($this->mail) && $this->telephone !== NULL && !empty($this->telephone) && $this->titre !== NULL && !empty($this->titre)) {

			 $sql = "INSERT INTO ".get_class($this)." VALUES (
			 	(SELECT 1+coalesce((SELECT id FROM ".get_class($this)." WHERE financeur = :financeur ORDER BY id DESC LIMIT 1),0)),
			 	:financeur, :nom, :password, :mail, :telephone, :titre)";
			 $params = array(':financeur'		=>$this->financeur,
			 				 ':nom'	        	=>$this->nom,
			 				 ':password'						=>$this->password,
			 				 ':mail' 			=>$this->mail,
			 				 ':telephone'		=>$this->telephone,
			 				 ':titre'			=>$this->titre);
			// TODO METTRE A TRUE statut dans proposition
	    $query = $this->db->prepare($sql);
	    $res = $query->execute($params);
	    return $res==1?"Employé contact créé !":"Bizarre, on ne sait pas ce qu'il s'est passé...";
    } else {
    	throw new Exception("Il manque des informations pour enregistrer ce nouvel employé contact en base de données");
    }
	}
	
	public function deleteFromDB() {
		// TODO vérifier que les champs requis ne sont pas NULL dans l'objet
    $sql = "DELETE FROM ".get_class($this)." WHERE id=:id AND financeur=:financeur";
    $params = array(':id'			=>$this->id,
    				':financeur'	=>$this->financeur);
    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==True && $query->rowCount()==1?"Employé supprimé avec succès":"ERREUR: Cet employé a sûrement déjà été supprimé";
	}

	public function getOne($email,$pwd) {
		if ($email !== NULL && !empty($email) && $pwd !== NULL && !empty($pwd)) {
			$sql = "SELECT * from ".get_called_class()." WHERE mail = :mail and password = :password";
			$params = array(
			 				 ':mail'			 	=>$email,
			 				 ':password'		=>$pwd);
			$query = $this->db->prepare($sql);
	    $res = $query->execute($params);	    
    	$rows = $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, get_called_class());			
	    return !empty($rows)?current($rows):NULL;
    } else {
    	throw new Exception("Il manque des informations pour vous authentifier. Merci de remplir le login et le mot de passe.");
    }
	}
}

