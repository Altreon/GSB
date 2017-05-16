<?php
	session_start();
	if(isset($_SESSION['visiteur'])){
		require_once '../data/pdogsbrapports.php';
		//Récupère les information
		$id = $_REQUEST['id'];
		
		//Récupère le médecin
		$pdo = PdoGsbRapports::getPdo();
		$leMedecin = $pdo->getLeMedecin($id);
		
		//Retourne le médecin
		echo json_encode($leMedecin);
	}else{
		echo 0;
	}
?>