// code pour la barre de recherche
(function($){
  // évènement keyup prend en compte lorsque l'on lâche la touche du clavier
  // évènement focus permet à l'utilisateur d'être automatiquement sur la barre de recherche
  $('#userFilter').focus().keyup(function(event){
    let input = $(this);
    // enregistre la valeur de la variable input
    let val = input.val();
    // Si la valeur du champ recherche est vide, alors on va tout afficher, et supprimer la classe highlighted
    if (val == '') {
      $('#filter div').show('');
      $('#filter span').removeClass('highlighted');
      return true;
    }

    let regexp = '\\b(.*)';
    // Parcourir chaque lettre qui se trouve dans ma barre de recherche
    for (let i in val) {
      regexp += '('+val[i]+')(.*)';
    } 
    regexp += '\\b';
    // Permet de revenir en arrière dans la barre de recherche afin de montrer de nouveau les infos
    $('#filter div').show();
    // Parcourir tous les balises span dans la balise h2
    $('#filter').find('h2>span').each(function(){
      let span = $(this);
      // text récupère le texte, et pas le code html
      // match permet de correspondre l'epression régulière avec le texte
      let results = span.text().match(new RegExp(regexp,'i'));
      // On va créer un surlignement. 
      // Dans le tableau de la variable results, les mots lettres recherchées sont placés à un index pair
      // On va donc chercher tous les éléments à un index pair, sauf 0 puisqu'il s'agit du mot complet.
      if (results) {
        let string = '';
        for (let i in results) {
          if (i > 0) {
            if (i%2 == 0) {
              // J'entoure la lettre d'une balise span avec classe highlighted
              string +='<span class="highlighted">' + results[i]+'</span>';
            } else {
              string += results[i];
            }
          }
        }
        // 
        span.empty().append(string);
      } else {
        // Cacher tous les autres éléments qui ne sont pas inclus dans la recherche
        span.parent().parent().parent().parent().hide();
      }
    })
  })
})(jQuery);

// code pour les filtres
window.onload = () => {
  // Récupère le formulaire avec l'identifiant filters
  const FiltersForm = document.querySelector('#filters');
  // On boucle sur les inputs
  document.querySelectorAll('#filters input').forEach(input => {
    input.addEventListener('change', () => {
      // On récupère les données du formulaire 
      const Form = new FormData(FiltersForm);
      // On fabrique l'url pour faire la requête ajax
      const Params = new URLSearchParams();

      Form.forEach((value, key) => {
        // On ajout les paramètres au fur et à mesure qu'on les reçoit
        Params.append(key, value);
      });
      // On récupère l'url active
      const Url = new URL(window.location.href);
      // On lance la requête ajax
      // fetch retourne une promesse 
      fetch(Url.pathname + '?' + Params.toString() + '&ajax=1', {
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      }).then(response => 
        response.json()
      ).then(data => {
        const content = document.querySelector('.content');
        content.innerHTML = data.content;
        history.pushState({}, null, Url.pathname + '?' + Params.toString());
      }).catch(e => alert(e));
    })
  })
}