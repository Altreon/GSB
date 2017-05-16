<?php
	session_start();
	echo isset($_SESSION['visiteur']); //retourne si le visisteur est connecté ou non
?>