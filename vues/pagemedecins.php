<div data-role = "page" id = "pagemedecins">
	<?php 
		include "entetepagemedecins.html"; //inclue l'entete
	?>
	
	<div data-role = "content">
		<div class = "ui-field-contain">
			<label>Rechercher un médecin</label>
			<br/><br/>
			<form class="ui-filterable">
   		 		<input id="autocomplete-input" data-type="search" placeholder="Nom...">
			</form>
			<ul id="autocomplete" data-role="listview" data-inset="true" data-filter="true" data-input="#autocomplete-input"></ul>
			<br/><br/><br/><br/><br/>
			<label> Nom médecin</label>
			<br/><br/>
			
			<!-- Input non modifiable affichant le médecin selectionné -->
			<input type = "text" name = "info" id = "info" value = "" readonly="readonly"/>
		</div>
	</div>
	<?php 
		include "piedPage.html";  //inclue le pied de page
	?>
</div>