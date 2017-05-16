<?php
/** 
 * Classe d'accès aux données. 
 
 * Utilise les services de la classe PDO
 * pour l'application Gsb Rapport Mobile
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsbRapports qui contiendra l'unique instance de la classe
 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsbRapports{   		
      	 /*--------------------Version locale---------------------------------------- */
      private static $serveur='mysql:host=localhost';
      private static $bdd='dbname=gsbrapports';   		
      private static $user='root' ;    		
      private static $mdp='' ;
      private static $monPdo;
      private static $monPdoGsbRapports = null;
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
	private function __construct(){
            self::$monPdo = new PDO(self::$serveur.';'.self::$bdd, self::$user, self::$mdp); 
            self::$monPdo->query("SET CHARACTER SET utf8");
	}
        
	public function _destruct(){
            self::$monPdo = null;
	}
/**
 * Fonction statique qui crée l'unique instance de la classe
 
 * Appel : $instancePdoGsbRapports = PdoGsbRapports::getPdo();
 
 * @return l'unique objet de la classe PdoGsbRapports
 */
	public  static function getPdo(){
		if(self::$monPdoGsbRapports == null){
			self::$monPdoGsbRapports = new PdoGsbRapports();
		}
		return self::$monPdoGsbRapports;  
	}
	
	//Retourne le visiteur concerné par le login et le mot de passe donnés en paramétres, s'il existe.
	public static function getLeVisiteur($login, $mdp){
		$req = self::$monPdo->prepare("SELECT id, nom, prenom, login, mdp FROM visiteur WHERE login='$login' AND mdp='$mdp'"); // Requète cherche le visiteur
		$req->execute();
		if($req->rowCount() > 0){
			$leVisiteur = $req->fetch();
			return ["id"=>$leVisiteur['id'], "nom"=>$leVisiteur['nom'], "prenom"=>$leVisiteur['prenom'],"login"=>$login, "mdp"=>$mdp]; // Créer le tableau d'information
		}else{
			//Si le visiteur n'existe pas, retourne null;
			return null;
		}
	}
	
	//Retourne les rapports associer à une date données en paramètres.
	public static function getLesVisitesUneDate($id, $date){
		$req1 = self::$monPdo->prepare("SELECT id, idMedecin FROM rapport WHERE date='$date' AND idVisiteur='$id'"); // Requète cherche les rapports à une date (récupére aussi l'id du medecin)
		$req1->execute();
		$tab = [];
		$i = 0;
		while($result = $req1->fetch()){
			$idMed = $result['idMedecin'];
			$req2 = self::$monPdo->prepare("SELECT nom, prenom FROM medecin WHERE id='$idMed'"); // Requète cherche le medecin
			$req2->execute();
			$leMedecin = $req2->fetch();
			$tab[$i]=array("id"=>$result['id'], "nom"=>$leMedecin['nom'], "prenom"=>$leMedecin['prenom']); // Créer et ajoute le tableau d'information à la liste de rapport
			$i++;
		}
		return $tab;
	}
	
	//Retourne le rapport associer à l'id donnée en paramètre.
	public static function getLeRapport($id){
		$req = self::$monPdo->prepare("SELECT id, date, motif, bilan, idVisiteur, idMedecin FROM rapport WHERE id='$id'"); // Requète cherche le rapport
		$req->execute();
		if($req->rowCount() > 0){
			$leRapport = $req->fetch();
			return ["date"=>$leRapport['date'], "motif"=>$leRapport['motif'], "bilan"=>$leRapport['bilan'], "idVisiteur"=>$leRapport['idVisiteur'], "isMedecin"=>$leRapport['idMedecin']]; // Créer le tableau d'information
		}else{
			return null;
		}
	}
	
	//Retourne les rapports associer à une id médecin données en paramètres.
	public static function getLesRapports($id){
		$req1 = self::$monPdo->prepare("SELECT id, date, motif, bilan, idVisiteur FROM rapport WHERE idMedecin='$id' ORDER BY date"); // Requète cherche les rapports à un id medecin (récupére aussi l'id du visiteur)
		$req1->execute();
		$tab = [];
		$i = 0;
		while($result = $req1->fetch()){
			$idVis = $result['idVisiteur'];
			$req2 = self::$monPdo->prepare("SELECT nom, prenom FROM visiteur WHERE id='$idVis'"); // Requète cherche le medecin
			$req2->execute();
			$leVisiteur = $req2->fetch();
			$tab[$i]=array("id"=>$result['id'], "date"=>$result['date'], "motif"=>$result['motif'], "bilan"=>$result['bilan'], "visiteur"=>$leVisiteur['nom'] . " " . $leVisiteur['prenom']); // Créer et ajoute le tableau d'information à la listes de rapport
			$i++;
		}
		return $tab;
	}
	
	//Effectue la mise à jour du motif et du bilan du rapport associé à l'id donné en paramètre.
	public static function majRapport($id, $motif, $bilan){
		try {
			self::$monPdo->query("UPDATE rapport SET motif = '$motif', bilan = '$bilan' WHERE id='$id'"); // Requète mise à jour du rapport
			return true;
		} catch (Exception $e) {
			//Si la mise à jour échoue, retourne false;
			return false;
		}
	}
	
	//Recherche les médecins associer à un nom données en paramètres.
	public static function getLesMedecins($nom){
		$req1 = self::$monPdo->prepare("SELECT * FROM medecin WHERE nom LIKE '$nom%' ORDER BY nom"); // Requète cherche les medecin
		$req1->execute();
		$tab = [];
		$i = 0;
		while($result = $req1->fetch()){
			$tab[$i]=array("id"=>$result['id'],"nom"=>$result['nom'], "prenom"=>$result['prenom'], "adresse"=>$result['adresse'], "tel"=>$result['tel']); // Créer et ajoute le tableau d'information à la liste des médecins
			$i++;
		}
		return $tab;
	}

	//Retourne le medecin associer à l'id donnée en paramètre.
	public static function getLeMedecin($id){
		$req = self::$monPdo->prepare("SELECT nom, prenom, adresse, tel, specialitecomplementaire FROM medecin WHERE id='$id'"); // Requète cherche le medecin
		$req->execute();
		if($req->rowCount() > 0){
			$leMedecin = $req->fetch();
			return ["nomPrenom"=>$leMedecin['nom'] . " " . $leMedecin['prenom'], "adresse"=>$leMedecin['adresse'], "tel"=>$leMedecin['tel'], "specialitecomplementaire"=>$leMedecin['specialitecomplementaire']]; // Créer le tableau d'information
		}else{
			return null;
		}
	}
	
	//Effectue la mise à jour de m'adresse, du téléphone et de la spécialité complémentaire du medecin associé à l'id donné en paramètre.
	public static function majMedecin($id, $adresse, $tel, $specialitecomplementaire){
		try {
			self::$monPdo->query("UPDATE medecin SET adresse = '$adresse', tel = '$tel', specialitecomplementaire = '$specialitecomplementaire' WHERE id='$id'"); // Requète mise à jour du médecin
			return true;
		} catch (Exception $e) {
			//Si la mise à jour échoue, retourne false;
			return false;
		}
	}
	
	//Recherche les médicaments associer à un nom données en paramètres.
	public static function getLesMedicaments($nom){
		$req1 = self::$monPdo->prepare("SELECT id, nomCommercial FROM medicament WHERE nomCommercial LIKE '$nom%' ORDER BY nomCommercial"); // Requète cherche les médicaments
		$req1->execute();
		$tab = [];
		$i = 0;
		while($result = $req1->fetch()){
			$tab[$i]=array("id"=>$result['id'],"nom"=>$result['nomCommercial']); // Créer et ajoute le tableau d'information à la liste de médicamentq
			$i++;
		}
		return $tab;
	}
	
	//Ajoute un rapport
	public static function ajoutRapport($motif, $bilan, $date, $idVisiteur, $idMedecin, $lesMedicaments){
		try {
			self::$monPdo->query("INSERT INTO rapport VALUES (DEFAULT, '$date', '$motif', '$bilan', '$idVisiteur', '$idMedecin')"); // Requète majout du rapport
			//Pour chaque médicaments, on ajoute une occurence dans la table "offrir"
			$idRapport = self::$monPdo->lastInsertId(); //récupère l'id du rapport tout juste ajouter
			foreach($lesMedicaments as $medicament){
				self::$monPdo->query("INSERT INTO offrir VALUES ('$idRapport', '$medicament[id]', '$medicament[qte]')"); // Requète ajout de l'offre
			}
			return true;
		} catch (Exception $e) {
			//Si la mise à jour échoue, retourne false;
			return false;
		}
	}
        
}   // fin classe
?>


