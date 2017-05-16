<div data-role = "page" id = "pageconnexion">
<?php
include_once "vues/entetepage.html"; //inclue l'entete
?>
	<div data-role = "content" id = "divconnexion">
		<?php 
			include_once "vues/logo.html"; //affiche le logo de GSB
		?>
		<div class = "ui-field-contain"> <!-- Formulaire de connexion -->
			<label for = "login" > Login </label>
			<input type = "text" name = "login" id = "login" value = "" />
			<label for = "mdp" > Mot de passe </label>
			<input type = "password" name = "mdp" id = "mdp" value = "" />
		</div>
		<div id = "message" ></div> <!-- Permet d'afficher une erreur en cas d'echec de l'authentification -->
		<p>
			<a href = "#" data-role = "button" id = "btnconnexion" data-inline="true" > Connexion </a> <!-- Bouton de connexion -->
		</p>
	</div>
	<?php 
		include "piedPage.html"; //inclue le pied de page
	?>
</div>