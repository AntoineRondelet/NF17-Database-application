<?php
class Depense extends Model {
	private $depense_id;
	private $numero;
	private $appel;
	private $organisme;
	private $publication_appel;
	private $date_depense;
	private $montant;
	private $type;
	private $status;
	private $demandeurext;
	private $demandeurlab;
	private $validateurext;
	private $validateurlab;
	

	function __construct($depense_id = NULL, $numero = NULL,$appel = NULL,$organisme = NULL,$publication_appel = NULL,$date_depense = NULL,$montant = NULL,$type = NULL,$status = NULL,$demandeurext = NULL,$demandeurlab = NULL,$validateurext = NULL,$validateurlab = NULL) {
		parent::__construct();
		$this->depense_id				= $depense_id;
		$this->numero					= $numero; 
		$this->appel					= $appel; 
		$this->organisme   				= $organisme;
		$this->publication_appel		= $publication_appel; 
		$this->date_depense				= $date_depense;
		$this->montant					= $montant;
		$this->type						= $type;
		$this->status					= $status;
		$this->demandeurext				= $demandeurext;
		$this->demandeurlab				= $demandeurlab;
		$this->validateurext			= $validateurext;
		$this->validateurlab			= $validateurlab;
	}

  public function __toString() {
    return "=============<br />une depense<br/ >=============<br />DEMANDEUR EXT: ".$this->getDemandeurext()."<br />DEMANDEUR LAB: ".$this->getDemandeurlab()."<br />VALIDATEUR EXT: ".$this->getValidateurext()."<br />VALIDATEUR LAB: ".$this->getValidateurlab()."<br />";
  }

	public function getDepense_id() {
		return $this->depense_id;
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
	public function getDate_depense() {
		return $this->date_depense;
	}
	public function getMontant() {
		return $this->montant;
	}
	public function getType() {
		return $this->type;
	}
	public function getStatus() {
		return $this->status;
	}
	public function getDemandeurext() {
		return $this->demandeurext;
	}
	public function getDemandeurlab() {
		return $this->demandeurlab;
	}
	public function getValidateurext() {
		return $this->validateurext;
	}
	public function getValidateurlab() {
		return $this->validateurlab;
	}
	
	public function setDepense_id($depense_id) {  
		$this->depense_id			= $depense_id;
	}
	public function setNumero($numero) {  
		$this->numero				= $numero;
	}
	public function setAppel($appel) {
		$this->appel				= $appel;
		}
	public function setOrganisme($organisme) {
		$this->organisme			= $organisme;
	}
	public function setPublication_appel($publication_appel) {
		$this->publication_appel	= $publication_appel;
	}
	public function setDate_depense($date_depense) {  
		$this->date_depense			= $date_depense;
	}
	public function setMontant($montant) {
		$this->montant				= $montant;
		}
	public function setDescription($type) {
		$this->type					= $type;
	}
	public function setStatus($status) {
		$this->status				= $status;
	}
	public function setDemandeurext($demandeurext) {
		$this->demandeurext			= $demandeurext;
	}
	public function setDemandeurlab($demandeurlab) {
		$this->demandeurlab			= $demandeurlab;
	}
	public function setValidateurext($validateurext) {
		$this->validateurext		= $validateurext;
	}
	public function setValidateurlab($validateurlab) {
		$this->validateurlab		= $validateurlab;
	}
	
	public function addToDB() {
		if ($this->numero !== NULL && $this->appel !== NULL && !empty($this->appel) && $this->organisme !== NULL && !empty($this->organisme) && $this->publication_appel !== NULL && $this->date_depense !== NULL  && $this->montant !== NULL && $this->type !== NULL && !empty($this->type) && $this->status !== NULL  && $this->demandeurext !== NULL xor $this->demandeurlab !== NULL && $this->validateurext !== NULL && $this->validateurlab !== NULL) {

			 $sql = "INSERT INTO ".get_class($this)." VALUES(
			 	(SELECT 1+coalesce((SELECT depense_id FROM ".get_class($this)." WHERE numero = :numero AND appel = :appel AND organisme = :organisme AND publication_appel = :publication_appel ORDER BY depense_id DESC LIMIT 1),0)),
			 	:numero, :appel, :organisme, :publication_appel, :date_depense, :montant, :type, :status, :demandeurext, :demandeurlab, :validateurext, :validateurlab)";
			 $params = array(
			 				 ':numero'					=>(float)$this->numero,
			 				 ':appel'			 		=>$this->appel,
			 				 ':organisme'	        	=>$this->organisme,
			 				 ':publication_appel' 		=>$this->publication_appel,
			 				 ':date_depense'			=>$this->date_depense,
			 				 ':montant'					=>$this->montant,
			 				 ':type'					=>$this->type,
			 				 ':status'					=>$this->status,
			 				 ':demandeurext'			=>(int)$this->demandeurext?:NULL,
			 				 ':demandeurlab'			=>(int)$this->demandeurlab?:NULL,
			 				 ':validateurext'			=>(int)$this->validateurext?:NULL,
			 				 ':validateurlab'			=>(int)$this->validateurlab)?:NULL;
			// TODO METTRE A TRUE statut dans proposition
	    $query = $this->db->prepare($sql);
	    $res = $query->execute($params);
	    return $res==True?"Depense créé !":"Bizarre, on ne sait pas ce qu'il s'est passé...";
    } else {
    	throw new Exception("Il manque des informations pour enregistrer ce nouveau depense en base de données");
    }
	}
	
  public function getAll($filter = '') {
    $rows = parent::getAll($filter = '');
    $membres_labo = array();
    $externes = array();

    $m = new Membre_labo();
    $e = new Externe();

    foreach($rows as $row) {
      if (is_int($row->demandeurext)) {
        if (!isset($externes[$row->demandeurext]))
          $externes[$row->demandeurext] = current($e->getAll('WHERE id = '.$row->demandeurext));
        $row->demandeurext = $externes[$row->demandeurext];
      }
      if (is_int($row->validateurext)) {
        if (!isset($externes[$row->validateurext]))
          $externes[$row->validateurext] = current($e->getAll('WHERE id = '.$row->validateurext));
        $row->validateurext = $externes[$row->validateurext];
      }
      if (is_int($row->demandeurlab)) {
        if (!isset($membres_labo[$row->demandeurlab])) {
          $membres_labo[$row->demandeurlab] = current($m->getAll('WHERE id = '.$row->demandeurlab));
        }
        $row->demandeurlab = $membres_labo[$row->demandeurlab];
      }
      if (is_int($row->validateurlab)) {
        if (!isset($membres_labo[$row->validateurlab])) {
          $membres_labo[$row->validateurlab] = current($m->getAll('WHERE id = '.$row->validateurlab));
        }
        $row->validateurlab = $membres_labo[$row->validateurlab];
      }
    }
    return $rows;
  }
	
	public function deleteFromDB() {
		// TODO vérifier que les champs requis ne sont pas NULL dans l'objet
    $sql = "DELETE FROM ".get_class($this)." WHERE depense_id = :depense_id AND numero=:numero AND appel=:appel AND organisme=:organisme AND publication_appel=:publication_appel";
    $params = array(		 ':depense_id'				=>$this->depense_id,
			 				 ':numero'					=>$this->numero,
			 				 ':appel'			 		=>$this->appel,
			 				 ':organisme'	        	=>$this->organisme,
			 				 ':publication_appel' 		=>$this->publication_appel);
    $query = $this->db->prepare($sql);
    $res = $query->execute($params);
    return $res==True && $query->rowCount()==1?"Depense supprimée avec succès":"ERREUR: Cette depense a sûrement déjà été supprimé";
	}

	public function deleteOne($depense_id,$numero,$appel,$organisme,$publication_appel){
		$sql = "DELETE FROM depense WHERE depense_id = :depense_id AND numero=:numero AND appel=:appel AND organisme=:organisme AND publication_appel=:publication_appel";
        $params= array(		 ':depense_id'				=>$depense_id,
			 				 ':numero'					=>$numero,
			 				 ':appel'			 		=>$appel,
			 				 ':organisme'	        	=>$organisme,
			 				 ':publication_appel' 		=>$publication_appel);
        $query = $this->db->prepare($sql);
        $res = $query->execute($params);
        return $res==True && $query->rowCount()==1?"Depense supprimée avec succès":"ERREUR: Cette depense a sûrement déjà été supprimé";
	}
}

