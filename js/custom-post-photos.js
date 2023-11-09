// CHARGER PLUS DE MESSAGE AVEC AJAX - Demande d'une requête ajax à admin-ajax.php
// cf. https://weichie.com/blog/load-more-posts-ajax-wordpress/

// Utilisation de jQuery pour éviter l'erreur "$ is not defined"
(function ($) { 
  // Code à exécuter lorsque le document est prêt
    $(document).ready(function () {

      // Variable pour suivre la page actuelle
      let currentPage = 1;

      // Lorsque le bouton 'load-more' est cliqué
      $('#load-more').on('click', function() {
        // Augmente le numéro de page
          currentPage++; 
        // Effectue une requête AJAX vers admin-ajax.php
          $.ajax({
              type: 'POST',
              url: './wp-admin/admin-ajax.php',
              dataType: 'json',
              data: {
                action: 'motaphoto_load_more', // Action WordPress à exécuter
                paged: currentPage, // Numéro de page à charger
              },
               // En cas de succès de la requête AJAX
              success: function (res) {
                // Cache le bouton s'il n'y a plus de pages à charger
                  if(currentPage >= res.max) {
                      $('#load-more').hide();
                    }
                    // Ajoute le HTML de la réponse à la section des blocs de photos
                  $('.section-photo-block').append(res.html);
                
              }
            });
          })

});
})(jQuery);

// FILTRER LES POSTS AVEC AJAX 