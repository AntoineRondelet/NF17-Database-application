<?php
class Financeur_cree_organisme_projet extends Model {
	 protected $financeur;
	 protected $organisme;


	 public function __construct($financeur = null, $organisme = null) {
	 	parent::__construct();
	 	$this->financeur				= $financeur;
	 	$this->organisme   			= $organisme;
	 }



	 public function getFinanceur() {
	 	return $this->financeur;
	 }
	 public function getOrganisme() {
	 	return $this->organisme;
	 }

	public function setFinanceur($financeur) {
	 	$this->financeur=$financeur;
	 }
	 public function setOrganisme($organisme) {
	 	$this->organisme=$organisme;
	 }

	public function addToDB() {
		if ($this->financeur !== NULL && !empty($this->financeur) && $this->organisme !== NULL && !empty($this->organisme)) {
	 		 $sql = "INSERT INTO ".get_class($this)." VALUES (:financeur, :organisme)";
	 		 $params = array(':financeur'			 	  =>$this->financeur,
									':organisme'	        =>$this->organisme);
	    $query = $this->db->prepare($sql);
	    $res = $query->execute($params);
	    return ($res==1&&$query->rowCount()==1)?"Organisme créé et linké avec un financeur avec succès":"Erreur lors du linkage du financeur et de l'organisme";
	} else {
    	throw new Exception("Il manque des informations pour lier cet organisme à un financeur en base de données");
    }
	}

 public function deleteFromDB() {
 		// TODO vérifier que les champs requis ne sont pas NULL dans l'objet
     $sql = "DELETE FROM ".get_class($this)." WHERE organisme=:organisme AND financeur=:financeur ";
     $params = array(':organisme'			=>$this->organisme,
							':financeur'			=>$this->financeur);
     $query = $this->db->prepare($sql);
     $res = $query->execute($params);
     return $res==True && $query->rowCount()==1?"Lien organisme supprimée avec succès":"ERREUR: Ce lien a sûrement déjà été supprimé";
	}
}
