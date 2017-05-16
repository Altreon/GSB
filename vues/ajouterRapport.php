<div data-role = "page" id = "pageajouterrapport">
	<?php 
		include "entetepageajouterrapport.html"; //inclue l'entete
	?>
	
	<div data-role = "content">
		<h1>Ajouter un rapport</h1>
		<div class = "ui-field-contain">
			<label>Rechercher un médecin</label>
			<br/><br/>
			<form class="ui-filterable">
   		 		<input id="autocomplete-input2" data-type="search" placeholder="Nom...">
			</form>
			<ul id="autocomplete2" data-role="listview" data-inset="true" data-filter="true" data-input="#autocomplete-input2"></ul>
			<br/><br/><br/><br/><br/>
			<label> Nom médecin</label>
			
			<!-- Input non modifiable affichant le médecin selectionné -->
			<input type = "text" name = "info" id = "info" value = "" readonly="readonly" required/>
			
			<label>Motif</label>
			<input type="text" name="text-basic" id="motif" value="" required/>
			<label>Bilan</label>
			<input type="text" name="text-basic" id="bilan" value="" required/>
			<label>Date</label>
			<input type="date" data-role="date" id="dateSelect" required></input> <!-- Champs de texte pour la date -->
			
			<label for="lblmedicament">Médicaments offets</label>
			<a href="#" data-role="button" id="btnajoutmedicament" data-inline="true"> Nouveau médicament</a>
			<div id="lesListesMedicaments" class="ui-field-contain">
			
			</div> <!-- /fin ui-field-containt les listes médicaments -->
			
			<button type="submit" id="submit">Valider</button>
			
			<!-- Dialogue de confirmation de l'ajout -->
			<div data-role="popup" id="myPopupDialog">
  				<div data-role="header"><h1>localhost</h1></div>
			  	<div data-role="main" class="ui-content"><p>Votre ajout a bien été enregistrée</p>
			  	<button onclick="$('#pageajouterrapport #myPopupDialog').popup('close');" class="ui-btn ui-btn-b" id = "ok">OK</button></div>
			</div>
			
		</div>
	</div>
	
	<?php 
		include "piedPage.html"; //inclue le pied de page
	?>
</div>