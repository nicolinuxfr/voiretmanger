var createursIndex = null;
var acteursIndex = null;
var anneesIndex = null;
var paysIndex = null;
var results = [];

jQuery(document).ready(function($) {
	SearchCreateurs.getCreateursIndex();
	SearchActeurs.getActeursIndex();
	SearchAnnees.getAnneesIndex();
	SearchPays.getPaysIndex();
	$('#createur').keyup(function() {
			// get search term
			var search_term = jQuery(this).val().toLowerCase();
			// run the search
			SearchCreateurs.doSearch(search_term);
	})
	$('#acteur').keyup(function() {
			// get search term
			var search_term = jQuery(this).val().toLowerCase();
			// run the search
			SearchActeurs.doSearch(search_term);
	})
	$('#annee').keyup(function() {
			// get search term
			var search_term = jQuery(this).val().toLowerCase();
			// run the search
			SearchAnnees.doSearch(search_term);
	})
	$('#pays').keyup(function() {
			// get search term
			var search_term = jQuery(this).val().toLowerCase();
			// run the search
			SearchPays.doSearch(search_term);
	})
});


var SearchCreateurs = {
	// Load the index file for later use
	getCreateursIndex: function() {
		jQuery.getJSON("/createurs.json", function(data) {
				console.log('[Search index successfully loaded - createurs]');
				jQuery('.createurs_results').html(''); // on vide la liste, au cas où
				createursIndex = data;
		});
	},
	
	
	doSearch : function(search_term) {
		results = [];
		if(search_term.length > 0) { // si la recherche est plus longue que 3 caractères
			jQuery.each(createursIndex, function(id, article) {
				var titleLowerCase = article.title.toLowerCase().replace(/é/g, "e").replace(/è/g, "e").replace(/ê/g, "e").replace(/â/g, "a").replace(/à/g, "a").replace(/ä/g, "a").replace(/ü/g, "u").replace(/û/g, "u").replace(/ù/g, "u").replace(/î/g, "i").replace(/ï/g, "i").replace(/ô/g, "o").replace(/ö/g, "o").replace(/ç/g, "c"); // on convertit tout en bas-de-casse et on supprime les accents et caractères spéciaux
				var term = search_term.replace(/é/g, "e").replace(/è/g, "e").replace(/ê/g, "e").replace(/â/g, "a").replace(/à/g, "a").replace(/ä/g, "a").replace(/ü/g, "u").replace(/û/g, "u").replace(/ù/g, "u").replace(/î/g, "i").replace(/ï/g, "i").replace(/ô/g, "o").replace(/ö/g, "o").replace(/ç/g, "c");;
				if (titleLowerCase.indexOf(term) !== -1) {
					results.push(article); // si la recherche est contenue dans le titre de l'article en cours, on l'ajoute aux resultats
				};
			});
			SearchCreateurs.printResults(); // le tableau des resultats est construit, on lance l'affichage
		}
		else {
			$('.createurs_results').fadeOut(100); // on masque le menu
			$('.createurs_results').html(); // on vide le menu
			results = [];
		}
	},

	printResults: function() {
		
		var search_results_box = jQuery('.createurs_results'); // on selectionne l'objet HTML qui contiendra les resultats
		search_results_box.html('');

		search_results_box.html(function() {
			results = results.slice(0, 40); // on garde les 10 premiers resultats
			jQuery.each(results, function(index, obj) {
				search_results_box.append( // on ajoute un élément de liste au menu
					'<a href="'+obj.url+'"><li>'+obj.title+'</li></a>'
				);
			});
		});
		$('.createurs_results').fadeIn(100); // on affiche le menu
	}

}



var SearchActeurs = {
	// Load the index file for later use

	getActeursIndex: function() {
		jQuery.getJSON("/acteurs.json", function(data) {
				console.log('[Search index successfully loaded - acteurs]');
				jQuery('.acteurs_results').html(''); // on vide la liste, au cas où
				acteursIndex = data;
		});
	},

	doSearch : function(search_term) {
		results = [];
		if(search_term.length > 0) { // si la recherche est plus longue que 3 caractères
			jQuery.each(acteursIndex, function(id, article) {
				var titleLowerCase = article.title.toLowerCase().replace(/é/g, "e").replace(/è/g, "e").replace(/ê/g, "e").replace(/â/g, "a").replace(/à/g, "a").replace(/ä/g, "a").replace(/ü/g, "u").replace(/û/g, "u").replace(/ù/g, "u").replace(/î/g, "i").replace(/ï/g, "i").replace(/ô/g, "o").replace(/ö/g, "o").replace(/ç/g, "c"); // on convertit tout en bas-de-casse et on supprime les accents et caractères spéciaux
				var term = search_term.replace(/é/g, "e").replace(/è/g, "e").replace(/ê/g, "e").replace(/â/g, "a").replace(/à/g, "a").replace(/ä/g, "a").replace(/ü/g, "u").replace(/û/g, "u").replace(/ù/g, "u").replace(/î/g, "i").replace(/ï/g, "i").replace(/ô/g, "o").replace(/ö/g, "o").replace(/ç/g, "c");;
				if (titleLowerCase.indexOf(term) !== -1) {
					results.push(article); // si la recherche est contenue dans le titre de l'article en cours, on l'ajoute aux resultats
				};
			});
			SearchActeurs.printResults(); // le tableau des resultats est construit, on lance l'affichage
		}
		else {
			$('.acteurs_results').fadeOut(100); // on masque le menu
			$('.acteurs_results').html(); // on vide le menu
			results = [];
		}
	},

	printResults: function() {
		
		var search_results_box = jQuery('.acteurs_results'); // on selectionne l'objet HTML qui contiendra les resultats
		search_results_box.html('');

		search_results_box.html(function() {
			results = results.slice(0, 40); // on garde les 10 premiers resultats
			jQuery.each(results, function(index, obj) {
				search_results_box.append( // on ajoute un élément de liste au menu
					'<a href="'+obj.url+'"><li>'+obj.title+'</li></a>'
				);
			});
		});
		$('.acteurs_results').fadeIn(100); // on affiche le menu
	}

}

var SearchAnnees = {
	// Load the index file for later use

	getAnneesIndex: function() {
		jQuery.getJSON("/annees.json", function(data) {
				console.log('[Search index successfully loaded - annees]');
				jQuery('.annees_results').html(''); // on vide la liste, au cas où
				anneesIndex = data;
		});
	},

	doSearch : function(search_term) {
		results = [];
		if(search_term.length > 0) { // si la recherche est plus longue que 3 caractères
			jQuery.each(anneesIndex, function(id, article) {
				var titleLowerCase = article.title.toLowerCase().replace(/é/g, "e").replace(/è/g, "e").replace(/ê/g, "e").replace(/â/g, "a").replace(/à/g, "a").replace(/ä/g, "a").replace(/ü/g, "u").replace(/û/g, "u").replace(/ù/g, "u").replace(/î/g, "i").replace(/ï/g, "i").replace(/ô/g, "o").replace(/ö/g, "o").replace(/ç/g, "c"); // on convertit tout en bas-de-casse et on supprime les accents et caractères spéciaux
				var term = search_term.replace(/é/g, "e").replace(/è/g, "e").replace(/ê/g, "e").replace(/â/g, "a").replace(/à/g, "a").replace(/ä/g, "a").replace(/ü/g, "u").replace(/û/g, "u").replace(/ù/g, "u").replace(/î/g, "i").replace(/ï/g, "i").replace(/ô/g, "o").replace(/ö/g, "o").replace(/ç/g, "c");;
				if (titleLowerCase.indexOf(term) !== -1) {
					results.push(article); // si la recherche est contenue dans le titre de l'article en cours, on l'ajoute aux resultats
				};
			});
			SearchAnnees.printResults(); // le tableau des resultats est construit, on lance l'affichage
		}
		else {
			$('.annees_results').fadeOut(100); // on masque le menu
			$('.annees_results').html(); // on vide le menu
			results = [];
		}
	},

	printResults: function() {
		
		var search_results_box = jQuery('.annees_results'); // on selectionne l'objet HTML qui contiendra les resultats
		search_results_box.html('');

		search_results_box.html(function() {
			results = results.slice(0, 40); // on garde les 10 premiers resultats
			jQuery.each(results, function(index, obj) {
				search_results_box.append( // on ajoute un élément de liste au menu
					'<a href="'+obj.url+'"><li>'+obj.title+'</li></a>'
				);
			});
		});
		$('.annees_results').fadeIn(100); // on affiche le menu
	}
}



var SearchPays = {
	// Load the index file for later use

	getPaysIndex: function() {
		jQuery.getJSON("/pays.json", function(data) {
				console.log('[Search index successfully loaded - pays]');
				jQuery('.pays_results').html(''); // on vide la liste, au cas où
				paysIndex = data;
		});
	},

	doSearch : function(search_term) {
		results = [];
		if(search_term.length > 0) { // si la recherche est plus longue que 3 caractères
			jQuery.each(paysIndex, function(id, article) {
				var titleLowerCase = article.title.toLowerCase().replace(/é/g, "e").replace(/è/g, "e").replace(/ê/g, "e").replace(/â/g, "a").replace(/à/g, "a").replace(/ä/g, "a").replace(/ü/g, "u").replace(/û/g, "u").replace(/ù/g, "u").replace(/î/g, "i").replace(/ï/g, "i").replace(/ô/g, "o").replace(/ö/g, "o").replace(/ç/g, "c"); // on convertit tout en bas-de-casse et on supprime les accents et caractères spéciaux
				var term = search_term.replace(/é/g, "e").replace(/è/g, "e").replace(/ê/g, "e").replace(/â/g, "a").replace(/à/g, "a").replace(/ä/g, "a").replace(/ü/g, "u").replace(/û/g, "u").replace(/ù/g, "u").replace(/î/g, "i").replace(/ï/g, "i").replace(/ô/g, "o").replace(/ö/g, "o").replace(/ç/g, "c");;
				if (titleLowerCase.indexOf(term) !== -1) {
					results.push(article); // si la recherche est contenue dans le titre de l'article en cours, on l'ajoute aux resultats
				};
			});
			SearchPays.printResults(); // le tableau des resultats est construit, on lance l'affichage
		}
		else {
			$('.pays_results').fadeOut(100); // on masque le menu
			$('.pays_results').html(); // on vide le menu
			results = [];
		}
	},

	printResults: function() {
		
		var search_results_box = jQuery('.pays_results'); // on selectionne l'objet HTML qui contiendra les resultats
		search_results_box.html('');

		search_results_box.html(function() {
			results = results.slice(0, 40); // on garde les 10 premiers resultats
			jQuery.each(results, function(index, obj) {
				search_results_box.append( // on ajoute un élément de liste au menu
					'<a href="'+obj.url+'"><li>'+obj.title+'</li></a>'
				);
			});
		});
		$('.pays_results').fadeIn(100); // on affiche le menu
	}
}