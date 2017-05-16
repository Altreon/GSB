<?php
	session_start();
	if(isset($_SESSION['visiteur'])){
		require_once '../data/pdogsbrapports.php';
		//Récupère les information
		$idMedecin = $_REQUEST['id'];
		
		//Récupère les rapports
		$pdo = PdoGsbRapports::getPdo();
		$lesRapports = $pdo->getLesRapports($idMedecin);
		
		//Returne les rapports
		echo json_encode($lesRapports);
	}else{
		echo 0;
	}
?>