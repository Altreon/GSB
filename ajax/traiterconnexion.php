<?php
	session_start();
	require_once '../data/pdogsbrapports.php';
	//Récupère les information
	$mdp = $_REQUEST['mdp'];
	$login = $_REQUEST['login'];
	
	//Récupère le visiteur (s'il existe)
	$pdo = PdoGsbRapports::getPdo();
	$visiteur = $pdo->getLeVisiteur($login, $mdp);
	
	if($visiteur != null){
		//Sauvegarde le visiteur dans la session actuelle
		$_SESSION['visiteur'] = $visiteur;
	}
	//Retourne le visiteur (ou null s'il n'existe pas)
	echo json_encode($visiteur);
?>