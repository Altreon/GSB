<div data-role = "page" id = "pagerapportamodifier">
	<?php 
		include "entetepagerapportamodifier.html"; //inclue l'entete
	?>
	
	<div data-role = "content">
		<div class = "ui-field-contain">
			<!-- Formulaire de modification du rapport -->
			<h5 id = "medecin">Médecin : </h5>
			<h5>Motif : </h5>
			<input type="text" name="text-basic" id="motif" value="">
			<h5>Bilan : </h5>
			<input type="text" name="text-basic" id="bilan" value="">
			<button type="submit" id="submit">Valider</button>
			
			<!-- Dialogue de confirmation de la mise à jour -->
			<div data-role="popup" id="myPopupDialog">
  				<div data-role="header"><h1>localhost</h1></div>
			  	<div data-role="main" class="ui-content"><p>Votre mise à jour a bien été enregistrée</p>
			  	<button onclick="$('#pagerapportamodifier #myPopupDialog').popup('close');" class="ui-btn ui-btn-b" id = "ok">OK</button></div>
			</div>
		</div>
	</div>
	<?php 
		include "piedPage.html"; //inclue le pied de page
	?>
</div>