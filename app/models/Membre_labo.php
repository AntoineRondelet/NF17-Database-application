<?php
class Membre_labo extends Model {
	private $id;
	private $nom;
	private $password;
	private $mail;
	private $telephone;
	private $date_debut;
	private $date_fin;
	private $quotite;
	private $etablissement;
	private $specialite;
	private $validateur;
	private $type; // I, C ou D
	private $sujet;
	private $labo;
	

	function __construct($id = null,$nom = null, $password = null, $mail = null,$telephone = null,$date_debut = null,$date_fin = null,$quotite = null,$etablissement = null,$specialite = null,$validateur = null,$type = null,$sujet = null,$labo = null) {
		parent::__construct();
		$this->id					= $id; 
		$this->nom					= $nom;
		$this->password 			= $password;
		$this->mail   				= $mail;
		$this->telephone			= $telephone; 
		$this->date_debut			= $date_debut;
		$this->date_fin				= $date_fin;
		$this->quotite				= $quotite;
		$this->etablissement		= $etablissement;
		$this->specialite			= $specialite;
		$this->validateur			= $validateur;
		$this->type					= $type;
		$this->sujet				= $sujet;
		$this->labo					= $labo;

		if (strtotime($date_debut) > strtotime($date_fin))
			throw new Exception("Le date de début doit être avant la date de fin.");
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
	public function getDate_debut() {
		return $this->date_debut;
	}
	public function getDate_fin() {
		return $this->date_fin;
	}
	public function getQuotite() {
		return $this->quotite;
	}
	public function getEtablissement() {
		return $this->etablissement;
	}
	public function getSpecialite() {
		return $this->specialite;
	}
	public function getValidateur() {
		return $this->validateur;
	}
	public function getType() {
		return $this->type;
	}
	public function getSujet() {
		return $this->sujet;
	}
	public function getLabo() {
		return $this->labo;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($pwd) {
		$this->password = $pwd;
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
	public function setDate_debut($date_debut) {  
		$this->date_debut		= $date_debut;
	}
	public function setDate_fin($date_fin) {
		$this->date_fin			= $date_fin;
		}
	public function setQuotite($quotite) {
		$this->quotite			= $quotite;
	}
	public function setEtablissement($etablissement) {
		$this->etablissement	= $etablissement;
	}
	public function setSpecialite($specialite) {
		$this->specialite		= $specialite;
	}
	public function setValidateur($validateur) {
		$this->validateur		= $validateur;
	}
	public function setType($type) {
		$this->type				= $type;
	}
	public function setSujet($sujet) {
		$this->sujet			= $sujet;
	}
	public function setLabo($labo) {
		$this->labo				= $labo;
	}
	
	public function __toString() {
		$ret = "Nom : ".$this->nom."<br />Email : ".$this->mail."<br />";
		if (strtoupper($this->type) == 'I') {
			$ret .= "INGÉNIEUR<br />";
		} else if (strtoupper($this->type) == 'D') {
			$ret .= "CHERCHEUR";
		} else if (strtoupper($this->type) == 'C') {
			$ret .= "ENSEIGNANT";
		}
		return $ret;
	}

	public function addToDB() {
		if ($this->nom !== NULL && !empty($this->nom) && $this->password !== NULL && !empty($this->password) && $this->validateur !== NULL && $this->type !== NULL && !empty($this->type) && $this->labo !== NULL && !empty($this->labo)) {

			 $sql = "INSERT INTO ".get_class($this)."(nom,password,mail,telephone,date_debut,date_fin,quotite,etablissement,specialite,validateur,type,sujet,labo) VALUES (:nom, :password, :mail, :telephone, :date_debut, :date_fin, :quotite, :etablissement, :specialite, :validateur, :type, :sujet, :labo)";
			 $params = array(
			 				 ':nom'			 					=>$this->nom,
			 				 ':password'						=>$this->password,
			 				 ':mail'	       			=>$this->mail,
			 				 ':telephone' 				=>$this->telephone,
			 				 ':date_debut'				=>$this->date_debut!==""?$this->date_debut:NULL,
			 				 ':date_fin'					=>$this->date_fin!==""?$this->date_fin:NULL,
			 				 ':quotite'			 			=>$this->quotite!==""?(float)$this->quotite:NULL,
			 				 ':etablissement'	    =>$this->etablissement!==""?$this->etablissement:NULL,
			 				 ':specialite' 				=>$this->specialite!==""?$this->specialite:NULL,
			 				 ':validateur'				=>$this->validateur,
			 				 ':type'							=>strtoupper($this->type),
			 				 ':sujet'			 				=>$this->sujet!==""?$this->sujet:NULL,
			 				 ':labo'	       			=>$this->labo);
	    $query = $this->db->prepare($sql);
	    $res = $query->execute($params);
	    return $res==1?"Membre Labo créé !":"Bizarre, on ne sait pas ce qu'il s'est passé...";
    } else {
    	throw new Exception("Il manque des informations pour enregistrer ce nouveau membre en base de données");
    }
	}
	
	public function deleteFromDB() {
		// TODO vérifier que les champs requis ne sont pas NULL dans l'objet
    $sql = "DELETE FROM ".get_class($this)." WHERE id=:id ";
    $params = array(':id'			=>$this->id);
    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==True && $query->rowCount()==1?"Membre supprimé avec succès":"ERREUR: Ce membre a sûrement déjà été supprimé";
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
