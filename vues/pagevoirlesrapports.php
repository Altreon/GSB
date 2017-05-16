<div data-role = "page" id = "pagevoirlesrapports">
	<?php 
		include "entetepagevoirlesrapports.html"; //inclue l'entete
	?>
	
	<div data-role = "content">
		<!-- Tableau affichant la liste des rapports du médecin -->
		<table data-role="table" id="table" data-mode="columntoggle" class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b">
			<thead>
				<tr>
					<th>Date</th>
					<th data-priority="1">Motif</th>
					<th data-priority="2">Bilan</th>
					<th data-priority="3">Visiteur</th>
				</tr>
			</thead>
			<tbody id="tbody"></tbody> <!-- Le tbody va contenir le html générer -->
		</table>
	</div>
	<?php 
		include "piedPage.html"; //inclue le pied de page
	?>
</div>