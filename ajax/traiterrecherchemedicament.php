<?php
	session_start();
	if(isset($_SESSION['visiteur'])){
		require_once '../data/pdogsbrapports.php';
		//Récupère les information
		$nommedicament = $_REQUEST['nommedicament'];
		
		//Récupère les médicaments
		$pdo = PdoGsbRapports::getPdo();
		$lesMedicaments = $pdo->getLesMedicaments($nommedicament);
		
		//Retourne les médicaments
		echo json_encode($lesMedicaments);
	}else{
		echo 0;
	}
?>