<?php
	session_start();
	if(isset($_SESSION['visiteur']['id'])){
		require_once '../data/pdogsbrapports.php';
		//Récupère les information
		$nom = $_REQUEST['nom'];
		
		//Récupère les médecins
		$pdo = PdoGsbRapports::getPdo();
		$lesMedecins = $pdo->getLesMedecins($nom);
		
		//Retourne les médecins
		echo json_encode($lesMedecins);
	}else{
		echo 0;
	}
?>