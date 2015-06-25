var searchIndex = null;
var results = [];

jQuery(document).ready(function($) {
	Search.getSearchIndex();
	$('#search').keyup(function() {
			// get search term
			var search_term = jQuery(this).val().toLowerCase();
			// run the search
			Search.doSearch(search_term);
	})
});


$(document).keyup(function(e) {
  if (e.keyCode == 27) $('#op').prop('checked', false);   // esc
});


var Search = {
	// Load the index file for later use
	getSearchIndex: function() {
		jQuery.getJSON("/search.json", function(data) {
				console.log('[Search index successfully loaded]');
				jQuery('#results').html(''); // on vide la liste, au cas où
				searchIndex = data;
		});
	},

	doSearch : function(search_term) {
		results = [];
		if(search_term.length > 2) { // si la recherche est plus longue que 3 caractères
			jQuery.each(searchIndex, function(id, article) {
				var titleLowerCase = article.title.toLowerCase().replace(/é/g, "e").replace(/è/g, "e").replace(/ê/g, "e").replace(/â/g, "a").replace(/à/g, "a").replace(/ä/g, "a").replace(/ü/g, "u").replace(/û/g, "u").replace(/ù/g, "u").replace(/î/g, "i").replace(/ï/g, "i").replace(/ô/g, "o").replace(/ö/g, "o").replace(/ç/g, "c"); // on convertit tout en bas-de-casse et on supprime les accents et caractères spéciaux
				var term = search_term.replace(/é/g, "e").replace(/è/g, "e").replace(/ê/g, "e").replace(/â/g, "a").replace(/à/g, "a").replace(/ä/g, "a").replace(/ü/g, "u").replace(/û/g, "u").replace(/ù/g, "u").replace(/î/g, "i").replace(/ï/g, "i").replace(/ô/g, "o").replace(/ö/g, "o").replace(/ç/g, "c");;
				if (titleLowerCase.indexOf(term) !== -1) {
					results.push(article); // si la recherche est contenue dans le titre de l'article en cours, on l'ajoute aux resultats
				};
			});
			Search.printResults(); // le tableau des resultats est construit, on lance l'affichage
		}
		else {
			$('#results').fadeOut(100); // on masque le menu
			$('#results').html(); // on vide le menu
			results = [];
		}
	},

	printResults: function() {
		
		var search_results_box = jQuery('#results'); // on selectionne l'objet HTML qui contiendra les resultats
		search_results_box.html('');

		search_results_box.html(function() {
			results = results.slice(0, 10); // on garde les 10 premiers resultats
			jQuery.each(results, function(index, obj) {
				search_results_box.append( // on ajoute un élément de liste au menu
					'<a href="http://voiretmanger.fr/?p='+obj.url+'"><li>'+obj.title+'</li></a>'
				);
			});
		});
		$('#results').fadeIn(100); // on affiche le menu
	}

}