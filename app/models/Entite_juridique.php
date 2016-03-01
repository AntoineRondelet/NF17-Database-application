<?php
class Entite_juridique extends Model {
	protected $id;
	protected $nom;
	protected $type;

	
	public function __construct($id = null, $nom = null, $type = null) {
		parent::__construct();
		$this->id					= $id;  
		$this->nom   				= $nom;
		$this->type					= $type; 
	}



	public function getId() {
		return $this->id;
	}
	public function getNom() {
		return $this->nom;
	}
	public function getType() {
		return $this->type;
	}
	
	
	

	public function setId($id) {  
		$this->id				= $id;
	}
	public function setNom($nom) {
		$this->nom				= $nom;
	}
	public function setType($type) {
		$this->type			= $type;
	}

	public function addToDB() {
		if ($this->nom !== NULL && !empty($this->nom) && $this->type !== NULL && !empty($this->type)) {

			 $sql = "INSERT INTO ".__CLASS__."(nom,type) VALUES (:nom, :type) RETURNING id";
			 $params = array(':nom'			 	=>$this->nom,
			 				 ':type'	        =>$this->type);
			// TODO METTRE A TRUE statut dans proposition
	    $query = $this->db->prepare($sql);
	    $res = $query->execute($params);
	    if ($res==1&&$query->rowCount()==1)
	    	return current($query->fetchAll())['id'];
	    else
	    	throw new Exception("Impossible de créer l'entité juridique");
    } else {
    	throw new Exception("Il manque des informations pour enregistrer ce nouveau entite_juridique en base de données");
    }
	}

public function deleteFromDB() {
		// TODO vérifier que les champs requis ne sont pas NULL dans l'objet
    $sql = "DELETE FROM ".get_class($this)." WHERE id=:id ";
    $params = array(':id'			=>$this->id);
    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==True && $query->rowCount()==1?"Entite Juridique supprimée avec succès":"ERREUR: Ce Entite Juridique a sûrement déjà été supprimé";


}

	
}













