<?php
	session_start();
	if(isset($_SESSION['visiteur']['id'])){
		require_once '../data/pdogsbrapports.php';
		//Récupère les information
		$motif = $_REQUEST['motif'];
		$bilan = $_REQUEST['bilan'];
		$date = $_REQUEST['date'];
		$idVisiteur = $_SESSION['visiteur']['id'];
		$idMedecin = $_REQUEST['idMedecin'];
		if(isset($_REQUEST['lesMedicaments'])){
			$lesMedicaments = $_REQUEST['lesMedicaments'];
		}else{
			$lesMedicaments = [];
		}
	
		//Envoie la mise à jour du rapport
		$pdo = PdoGsbRapports::getPdo();
		$ajoutReussi = $pdo->ajoutRapport($motif, $bilan, $date, $idVisiteur, $idMedecin, $lesMedicaments);
	
		//Retourne si la mise à jour à réussi
		echo json_encode($ajoutReussi);
	}else{
		echo 0;
	}
?>