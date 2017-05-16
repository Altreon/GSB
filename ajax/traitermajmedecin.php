<?php
	session_start();
	if(isset($_SESSION['visiteur'])){
		require_once '../data/pdogsbrapports.php';
		//Récupère les information
		$id = $_REQUEST['id'];
		$adresse = $_REQUEST['adresse'];
		$tel = $_REQUEST['tel'];
		$specialitecomplementaire = $_REQUEST['specialitecomplementaire'];
		
		//Envoie la mise à jour du médecin
		$pdo = PdoGsbRapports::getPdo();
		$majReussi = $pdo->majMedecin($id, $adresse, $tel, $specialitecomplementaire);
		
		//Retourne si la mise à jour à réussi
		echo json_encode($majReussi);
	}else{
		echo 0;
	}
?>