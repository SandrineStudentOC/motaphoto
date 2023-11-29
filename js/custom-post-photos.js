// CHARGER PLUS DE MESSAGE AVEC AJAX - Demande d'une requête ajax à admin-ajax.php
// cf. https://weichie.com/blog/load-more-posts-ajax-wordpress/

// Utilisation de jQuery pour éviter l'erreur "$ is not defined"
// script.js
  
  // FILTRER LES POSTS AVEC AJAX /  requête AJAX

(function ($) {
    // Variables pour suivre la page actuelle et les filtres sélectionnés
    let currentPage = 1;
    //stocke les filtres sélectionnés
    let selectedFilters = {
        categorie: '',
        format: '',
        date_order: 'DESC', // Ajout du filtre date_order avec la valeur par défaut DESC
    };

    // Fonction pour charger plus de messages avec AJAX
    function loadMorePhotos() {
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
                categorie: selectedFilters.categorie, // Ajoutez les filtres actuels
                format: selectedFilters.format,
                date_order: selectedFilters.date_order, // Ajout du filtre date_order
            },
            success: function (res) {
                console.log('Res:', res);

                
    // Affiche la valeur de res.max dans la console
    console.log('res.max:', res.max);

                // Cache le bouton s'il n'y a plus de pages à charger
                if (currentPage >= res.max - 1) {
                    $('#load-more').hide();
                } else {
                    $('#load-more').show();
                }

                // Ajoute le HTML de la réponse à la section des blocs de photos
                $('.section-photo-block').append(res.html);

                // Mettez à jour les filtres actuels
                selectedFilters.categorie = res.filters.categorie;
                selectedFilters.format = res.filters.format;
            },
        });
    }

    // Fonction pour filtrer les photos avec AJAX
function filterPhotos() {

       // Réinitialise le numéro de page à 1 pour chaque nouvelle requête
    currentPage = 1;

    // Ajoutez un log ici pour vérifier si la fonction est déclenchée
    console.log('La fonction filterPhotos est déclenchée.');

    // Ajoutez un log pour afficher la valeur de selectedFilters.categorie
    console.log('Filtre catégorie :', selectedFilters.categorie);
    

    $.ajax({
        type: 'POST',
        url: './wp-admin/admin-ajax.php',
        dataType: 'json', // Mettez à jour le type de données attendu en JSON
        data: {
            action: 'filter_photos',
            categorie: selectedFilters.categorie,
            format: selectedFilters.format,
            date_order: selectedFilters.date_order,
            paged: currentPage, // Utilisez la variable currentPage
        },

        beforeSend: function () {
            // Log avant l'envoi de la requête AJAX
            console.log('Avant envoi de la requête AJAX.');
        },

        success: function (res) {

            // Log en cas de succès de la requête AJAX
            console.log('Réponse AJAX réussie:', res);

            $('.section-photo-block').html(res.html);
            // Cache le bouton s'il n'y a plus de pages à charger
            if (res.max <= 1) {
                $('#load-more').hide();
            } else {
                $('#load-more').show();
            }
            

            // Affiche le nombre d'éléments/photos dans la console
            console.log('Nombre d\'éléments/photos récupérés :', $('.section-photo-block').find('.bloc__image').length);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        },

        complete: function () {
            // Log après l'exécution complète de la requête AJAX
            console.log('Requête AJAX complète.');
        },

    });
}


    // Code à exécuter lorsque le document est prêt
    $(document).ready(function () {
        // Lorsque le bouton 'load-more' est cliqué
        $('#load-more').on('click', loadMorePhotos);

        // Lorsqu'une option de catégorie est cliquée
        $('.option.categorie').on('click', function () {
            selectedFilters.categorie = $(this).data('slug');
            filterPhotos();
        });

        // Lorsqu'une option de format est cliquée
        $('.option.format').on('click', function () {
            selectedFilters.format = $(this).data('slug');
            filterPhotos();
        });

        // Lorsqu'une option de tri par date récentes est cliquée
        $('.option.date_recent').on('click', function () {
            selectedFilters.date_order = 'DESC';
            filterPhotos();
        });

        // Lorsqu'une option de tri par date anciennes est cliquée
        $('.option.date_ancien').on('click', function () {
            selectedFilters.date_order = 'ASC';
            filterPhotos();
            
        });
    });
})(jQuery);