<?php
	session_start();
	if(isset($_SESSION['visiteur'])){
		require_once '../data/pdogsbrapports.php';
		//Récupère les information
		$id = $_REQUEST['id'];
		$motif = $_REQUEST['motif'];
		$bilan = $_REQUEST['bilan'];
		
		//Envoie la mise à jour du rapport
		$pdo = PdoGsbRapports::getPdo();
		$majReussi = $pdo->majRapport($id, $motif, $bilan);
		
		//Retourne si la mise à jour à réussi
		echo json_encode($majReussi);
	}else{
		echo 0;
	}
?>