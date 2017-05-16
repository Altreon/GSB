$(function(){
	/*----------------------------------toutes les pages---------------------------*/
	$(document).on("pageinit", function(e){
		var page = window.location.hash.substr(1); //récupère la partie après #
		if(page != ""){
			$.get("ajax/traiterdemandepage.php",
					foncRetourConnecte);
		}
	});

	function foncRetourConnecte(data){
		if(data != 1){
			$.mobile.changePage("#");
		}
	}
	
	/*----------------------------------page connexion---------------------------*/
	//Quand le bouton de connexion est cliqué :
	$('#pageconnexion #btnconnexion').bind("click", function(e) {
		e.preventDefault();
		// récupère les valeurs du formulaire de connexion
		var mdp = $("#pageconnexion #mdp").val();
		var login = $("#pageconnexion #login").val();
		// Traitements
		$.post("ajax/traiterconnexion.php",{
			"mdp" : mdp,
			"login" : login },
			foncRetourConnexion,"json");
	});
	
	function foncRetourConnexion(data){
		if(data != null){
			// Si connexion, redirection vers la page d'accueil
			$.mobile.changePage("#pageaccueil");
		}
		else{
			// Sinon, affiche une erreur
			$("#pageconnexion #message").css({color:'red'});
			$("#pageconnexion #message").html("erreur de login et/ou mdp");
		}
	}
	
	
	/*----------------------------------page liste rapport---------------------------*/
	//Quand la date est modifiée :
	$('#pagemodifierrapport #dateSelect').bind("change", function(e) {
		e.preventDefault();
		//Mise à jour de la date dans le texte
		$("#pagemodifierrapport #dateVisite").html("Visite effectuées le : " + $('#pagemodifierrapport #dateSelect').val() + " chez les médecins :");
		//Traitement
		$.post("ajax/traiterlesvisiteaunedate.php",{
			"date" : $('#pagemodifierrapport #dateSelect').val() },
			foncRetourListeRapports,"json");
	});
	
	function foncRetourListeRapports(lesVisit){
		$("#pagemodifierrapport #listerapports").empty(); //Vide la liste de rapport précédent
		var lesVisites = [];
		lesVisites = lesVisit;
		var html = "";
		//Créer la nouvelle liste de rapport
		for(var i=0; i<lesVisites.length; i++){
			var unRapport = lesVisites[i];
			var id = unRapport['id'];
			var nom = unRapport['nom'];
			var prenom = unRapport['prenom'];
			html = html + "<li id="+id+">"+nom+" "+prenom+"</li>";
		}
		// Mise a jour de la liste de rapport
		$("#pagemodifierrapport #listerapports").append(html);
		$("#pagemodifierrapport #listerapports").listview('refresh');
	}
	
	
	/*----------------------------------page modifier un rapport---------------------------*/
	//Quand un rapport est selectionné :
	$('#pagemodifierrapport').on("click", "li", function(e) {
		if($(this).attr("id") != "liBasPage"){ // Empèche l'activation en cliquand sur le li du menu de bas-de-page
			$("#pagerapportamodifier #medecin").empty();
			// récupère les valeurs du rapport
			var idRapport = $(this).attr("id");
			var medecin = $(this).text();
			window.idRapport = idRapport;
			window.medecin = medecin;
			// Traitement
			$.post("ajax/traiterchoixrapport.php",{
				"id" : idRapport },
				foncRetourChoixRapport,"json");
		}
	});
	
	function foncRetourChoixRapport(leRapport){
		// Ajoute les valeurs correspondant aux rapport dans le formulaire de mise à jour de rapport
		$.mobile.changePage("#pagerapportamodifier");
		$("#pagerapportamodifier #motif").val(leRapport['motif']);
		$("#pagerapportamodifier #bilan").val(leRapport['bilan']);
		$("#pagerapportamodifier #medecin").html("Médecin : " + window.medecin);
	}
	
	
	/*----------------------------------page mettre a jour le rapport---------------------------*/
	//Quand le bouton de d'envoie de la mise à jour cliqué :
	$('#pagerapportamodifier #submit').on("click", function(e) {
		var idRapport = window.idRapport;
		// Récupère les valeurs du formualire de mise à jour de rapport
		var motif = $("#pagerapportamodifier #motif").val();
		var bilan = $("#pagerapportamodifier #bilan").val();
		// Traitement
		$.post("ajax/traitermajrapport.php",{
			"id" : idRapport ,
			"motif" : motif ,
			"bilan" : bilan },
			foncConfirmationRapport);
	});
	
	function foncConfirmationRapport (majReussi) {
		//Affiche le popup de confirmation de mise à jours
		$('#pagerapportamodifier #myPopupDialog').popup('open');
	}
	
	
	/*----------------------------------page rechercher un médecin (médecin et ajouter un rapport)---------------------------*/
	//Quand le nom de medecin recherché est ajouter/modifié :
	$('#pagemedecins #autocomplete, #pageajouterrapport #autocomplete2').on( "filterablebeforefilter", function ( e, data ) {
		var nom = $(data.input).val();
		if (nom && nom.length > 2) { // N'affiche les résultat que quand la longueur du nom entré dépasse 2
			// Traitement
			$.post("ajax/traiterrecherchemedecins.php",{
				"nom" : nom },
				foncRetourRecherchePageMedecins, "json");
		}else{
			$("#pagemedecins #autocomplete, #pageajouterrapport #autocomplete2").empty(); // supprime la liste existante dans le cas contraire
		}
	});
	
	function foncRetourRecherchePageMedecins (data) {
		$("#pagemedecins #autocomplete, #pageajouterrapport #autocomplete2").empty(); //Vide la liste de médecins précédent
		var html = "";
		//Créer la nouvelle liste de médecin
		for(var i=0; i<data.length; i++){
			var unMedecin = data[i];
			var id = unMedecin['id'];
			var nom = unMedecin['nom'];
			var prenom = unMedecin['prenom'];
			var adresse = unMedecin['adresse'];
			var tel = unMedecin['tel'];
			html = html + "<li id="+id+" class=\"ui-btn ui-icon-carat-r ui-btn-icon-right\">"+nom+" "+prenom+" "+adresse+"<input type=\"hidden\" value="+tel+"></li>";
		}
		// Mise a jour de la liste de médecins
		$("#pagemedecins #autocomplete, #pageajouterrapport #autocomplete2").append(html);
		if($.mobile.activePage.attr('id') == "pagemedecins"){
			$("#pagemedecins #autocomplete").listview('refresh');
		}else if($.mobile.activePage.attr('id') == "pageajouterrapport"){
			$("#pageajouterrapport #autocomplete2").listview('refresh');
		}
	}
	
	//Quand un médecin est selectionné :
	$('#pagemedecins, #pageajouterrapport #autocomplete2').on("click", "li", function(e) {
		if($(this).attr("id") != "liBasPage"){ // Empèche l'activation en cliquand sur le li du menu de bas-de-page
			// Récupère les valeurs du médecin
			var idMedecin = $(this).attr("id");
			var numeroTel = $(this).find("input:hidden").val();
			window.idMedecin = idMedecin;
			
			// Modifie les inputs d'information
			$("#pagemedecins #info, #pageajouterrapport #info").val($(this).text());
			$("#pagemedecins #autocomplete, #pageajouterrapport #autocomplete2").empty();
		
			//Ajoute le numéro du médecin sur les boutons d'appel
			$("#pagemajmedecin #btnAppel").attr("href", numeroTel)
			$("#pagevoirlesrapports #btnAppel").attr("href",  numeroTel)
		}
	});
	
	//Quand le bouton de page de mise à jour du médecin dans le panel menu est cliqué :
	$('#pagemedecins #btnMajMedecin, #pagevoirlesrapports #btnMajMedecin').on("click", function(e) {
		if($("#pagemedecins #info").val() != ""){ // Vérifie qu'un médecin à bien été choisi 
			// Traitement
			$.post("ajax/traitergetmedecin.php", {
				"id" : window.idMedecin
			}, foncRetourGetMedecin, "json" );
			
			$("#pagemedecins #panel").panel( "open" );
		}else{
			//Sinon ne rien faire et prévenir l'utilisateur qu'il faut choisir un médecin
			e.preventDefault();
			alert("Un médecin doit être choisi pour utiliser cette fonctionnalité");
		}
	});
	
	function foncRetourGetMedecin (data) {
		//Récupère les information du médecin
		var nomPrenom = data["nomPrenom"];
		var adresse = data["adresse"];
		var tel = data["tel"];
		var specialitecomplementaire = data["specialitecomplementaire"];
		
		// Modifie les inputs d'information
		$("#pagemajmedecin #medecin").html("Médecin : " + nomPrenom);
		$("#pagemajmedecin #adresse").val(adresse);
		$("#pagemajmedecin #tel").val(tel);
		$("#pagemajmedecin #specialitecomplementaire").val(specialitecomplementaire);
	}
	
	//Quand le bouton de page de voir les rapports du médecin dans le panel menu est cliqué :
	$('#pagemedecins #btnVoirRapports, #pagemajmedecin #btnVoirRapports').on("click", function(e) {
		if($("#pagemedecins #info").val() != ""){ // Vérifie qu'un médecin à bien été choisi 
			// Traitement
			$.post("ajax/traitergetlesrapports.php", {
				"id" : window.idMedecin
			}, foncRetourGetLesRapports, "json" );
		}else{
			//Sinon ne rien faire et prévenir l'utilisateur qu'il faut choisir un médecin
			e.preventDefault();
			alert("Un médecin doit être choisi pour utiliser cette fonctionnalité");
		}
	});
	
	function foncRetourGetLesRapports (data) {
		$("#pagevoirlesrapports #tbody").empty(); //Vide la liste de rapport précédent
		var html = "";
		//Créer la nouvelle liste de rapport
		for(var i=0; i<data.length; i++){
			var unRapport = data[i];
			var id = unRapport['id'];
			var date = unRapport['date'];
			var motif = unRapport['motif'];
			var bilan = unRapport['bilan'];
			var visiteur = unRapport['visiteur'];
			html = html + "<tr id="+id+"><td>"+date+"</td><td>"+motif+"</td><td>"+bilan+"</td><td>"+visiteur+"</td></tr>";
		}
		// Mise a jour du tableau des rapports
		$("#pagevoirlesrapports #tbody").append(html);
		$("#pagevoirlesrapports #table").table('refresh');
	}
	
	
	/*----------------------------------page mettre à jour le médecin---------------------------*/
	//Quand le bouton de d'envoie de la mise à jour du médecin est cliqué :
	$('#pagemajmedecin #submit').on("click", function(e) {
		var idMedecin = window.idMedecin;
		// Récupère les valeurs du formualire de mise à jour de médecin
		var adresse = $("#pagemajmedecin #adresse").val();
		var tel = $("#pagemajmedecin #tel").val();
		var specialitecomplementaire = $("#pagemajmedecin #specialitecomplementaire").val();
		// Traitement
		$.post("ajax/traitermajmedecin.php",{
			"id" : idMedecin ,
			"adresse" : adresse ,
			"tel" : tel ,
			"specialitecomplementaire" : specialitecomplementaire },
			foncConfirmationMedecin);
	});
	
	function foncConfirmationMedecin (majReussi) {
		//Affiche le popup de confirmation de mise à jours
		$('#pagemajmedecin #myPopupDialog').popup('open');
	}
	
	/*----------------------------------page ajouter un rapport---------------------------*/
	window.nbMedicament = 0; // sauvegarde le nombre de médicament ajouté
	//Quand le bouton de d'ajout d'un médicament est cliqué :
	$('#pageajouterrapport #btnajoutmedicament').bind("click", function(e){
		var i = window.nbMedicament;
		var html = "<div class=\"ui-field-contain\">";
		html + "<form class=\"ui-filterable\">";
		html += "<input id=\"autocomplete-inputMedic" + i + "\" data-type=\"search\" placeholder=\"Nom médicament...\">";
		html + "</form>"
		html += "<ul id=\"listMedicaments" + i + "\" data-role=\"listview\" data-inset=\"true\" data-filter=\"true\" data-input=\"#autocomplete-inputMedic" + i + "\" data-filter-theme=\"a\"></ul>";
		html += "<form>";
		html += "<input id=\"listMedicaments" + i + "Input\" type=\"text\" readonly=\"readonly\"/>";
		html += "<input id=\"listMedicaments" + i + "Hidden\" type=\"hidden\"/>";
		html += "<label for=\"nb\">Indiquer le nombre d'exemplaires offerts :</label>";
		html += "<input type=\"range\" name=\"slider\" id=\"slider" + i + "\" data-highlight=\"true\" min=\"0\" max=\"10\" value=\"1\"></form></div>"
		$("#pageajouterrapport #lesListesMedicaments").append(html);
		$("#pageajouterrapport #lesListesMedicaments").trigger("create");
		window.nbMedicament ++;
	});
	
	//Quand le nom du médicament recherché est ajouter/modifié :
	$("#pageajouterrapport #lesListesMedicaments").on( "filterablebeforefilter", "ul", function ( e, data ) {
		var idul = e.currentTarget.id; 	// on récupère l'id de l'ul grâce à la classe event (e)
		window.ul = idul;				// on stocke cet id pour être utilisé dans la fonction de retour
		var nommedicament = data.input.val();// on récupère la saisie
		if(nommedicament && nommedicament.length >=1){
			$.post("ajax/traiterrecherchemedicament.php", {
				"nommedicament" : nommedicament
			}, foncRetourRechercheMedicaments, "json" );
		}else{
			$("#pageajouterrapport #" + idul).empty(); // supprime la liste existante dans le cas contraire
		}
	});
	
	function foncRetourRechercheMedicaments (data) {
		$("#pageajouterrapport #" + window.ul).empty(); //Vide la liste de médicaments
		var html = "";
		//Créer la nouvelle liste de médicaments
		for(var i=0; i<data.length; i++){
			var unMedicament = data[i];
			var id = unMedicament['id'];
			var nom = unMedicament['nom'];
			html = html + "<li id="+id+" class=\"ui-btn ui-icon-carat-r ui-btn-icon-right\">"+nom+"</li>";
		}
		// Mise a jour de la liste de médicaments
		$("#pageajouterrapport #" + window.ul).append(html);
		$("#pageajouterrapport #" + window.ul).listview('refresh');
	}
	
	//Quand un médicament est selectionné :
	$('#pageajouterrapport #lesListesMedicaments').on("click", "li", function(e) {
		// Modifie l'input d'information
		$("#pageajouterrapport #" + window.ul + "Input").val($(this).text());
		$("#pageajouterrapport #" + window.ul + "Hidden").val($(this).attr("id")); //permet de conserver l'id du médicament
		$("#pageajouterrapport #" + window.ul).empty();
	});
	
	//Quand le bouton de d'envoie d'ajout du rapport est cliqué :
	$("#pageajouterrapport #submit").bind("click", function () {
		// Récupère les valeurs du formulaire de d'ajout de rapport
		var motif = $("#pageajouterrapport #motif").val();
		var bilan = $("#pageajouterrapport #bilan").val();
		var date = $("#pageajouterrapport #dateSelect").val();
		var lesMedicaments = [];
		for(i=0; i<window.nbMedicament; i++){
			lesMedicaments.push({id : $("#pageajouterrapport #listMedicaments" + i + "Hidden").val(), qte : $("#pageajouterrapport #slider" + i).val()})
		}
		
		var idMedecin = window.idMedecin;
		
		if(motif && bilan && date && idMedecin){
		
			// Traitement
			$.post("ajax/traiterajoutrapport.php",{
				"motif" : motif ,
				"bilan" : bilan ,
				"date" : date ,
				"idMedecin" : idMedecin ,
				"lesMedicaments" : lesMedicaments },
				foncConfirmationAjoutRapport);
		}
	});
	
	function foncConfirmationAjoutRapport (ajoutReussi) {
		//Affiche le popup de confirmation de mise à jours
		$('#pageajouterrapport #myPopupDialog').popup('open');
	}
	
	/*-------------------------------------------------------------------------------*/
	//fin fonction principale
	
	
});