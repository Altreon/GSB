<?php
	session_start();
	if(isset($_SESSION['visiteur'])){
		require_once '../data/pdogsbrapports.php';
		//Récupère les information
		$date = $_REQUEST['date'];
		$id = $_SESSION['visiteur']['id'];
		
		//Récupère les visites à une date
		$pdo = PdoGsbRapports::getPdo();
		$lesVisites = $pdo->getLesVisitesUneDate($id, $date);
		
		//Retourne les visites à une date
		echo json_encode($lesVisites);
	}else{
		echo 0;
	}
?>