<?php
	session_start();
	if(isset($_SESSION['visiteur'])){
		require_once '../data/pdogsbrapports.php';
		//Récupère les information
		$id = $_REQUEST['id'];
		
		//Récupère le rapport
		$pdo = PdoGsbRapports::getPdo();
		$leRapport = $pdo->getLeRapport($id);
		
		//Retourne le rapport;
		echo json_encode($leRapport);
	}else{
		echo 0;
	}
?>