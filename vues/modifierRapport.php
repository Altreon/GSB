<div data-role = "page" id = "pagemodifierrapport">
	<?php 
		include "entetepagemodifierrapport.html";
	?>
	
	<div data-role = "content">
		<?php 
			include "vues/logo.html"; //affiche le logo de GSB
		?>
		<h1>Choisir un rapport</h1>
		<div class = "ui-field-contain">
			<h5>Date de la visite</h5>
			<input type="date" data-role="date" id="dateSelect"></input> <!-- Champs de texte pour la date -->
			<h5 id="dateVisite">Visite effectuées le : ????/??/?? chez les médecins :</h5> <!--Retour du champs de texte pour la date -->
			<ul data-role="listview" id="listerapports"></ul> <!-- Contient la liste des rapports -->
		</div>
	</div>
	<?php 
		include "piedPage.html";
	?>
</div>