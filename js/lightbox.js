// Get the button that opens the modal
var btnOpenLightbox = document.querySelectorAll(".picto-fullscreen");

// Get the button close the modal
var btnCloseLightbox = document.querySelector(".lightbox__close");

// Get the lightbox
var lightbox = document.getElementById('myLightbox');
var lightboxReference = document.querySelector(".lightbox__container__info p:first-child");
var lightboxCategorie = document.querySelector(".lightbox__container__info p:last-child");
var lightboxImage = document.querySelector(".lightbox__container img");

// Variable pour stocker les images à afficher dans la lightbox
var imagesInLightbox = [];
var currentImageIndex = 0;

// Utilisation de jQuery pour s'assurer que le script ne s'exécute qu'une fois que le document est prêt
jQuery(document).ready(function ($) {
    // Sélectionnez tous les éléments .picto-fullscreen, même ceux ajoutés dynamiquement
    $(document).on('click', '.picto-fullscreen', function (event) {
        // Empêcher le comportement par défaut du lien
        event.preventDefault();

        // Mettez à jour les images à afficher dans la lightbox
        imagesInLightbox = $(".picto-fullscreen").toArray();
        // Trouvez l'index de l'image actuellement cliquée
        currentImageIndex = imagesInLightbox.indexOf(this);

        // Récupérer les attributs de données du bouton cliqué
        var reference = $(this).data('reference');
        var categorie = $(this).data('categorie');
        var imageUrl = $(this).data('image-url');

        // Update the information in the lightbox
        $(".lightbox__container__info p:first-child").text(reference);
        $(".lightbox__container__info p:last-child").text(categorie);
        $(".lightbox__container img").attr('src', imageUrl);

        // Display the lightbox
        $("#myLightbox").css('display', 'flex');
    });

    // Ajouter un gestionnaire d'événements pour le bouton de fermeture de la lightbox
    $(".lightbox__close").on('click', function () {
        $("#myLightbox").css('display', 'none');
    });

    // Ajouter un gestionnaire d'événements pour le bouton suivant
    $(".lightbox__next").on('click', function () {
        // Passe à l'image suivante
        currentImageIndex = (currentImageIndex + 1) % imagesInLightbox.length;
        updateLightboxContent();
    });

    // Ajouter un gestionnaire d'événements pour le bouton précédent
    $(".lightbox__prev").on('click', function () {
        // Passe à l'image précédente
        currentImageIndex = (currentImageIndex - 1 + imagesInLightbox.length) % imagesInLightbox.length;
        updateLightboxContent();
    });

    // Fonction pour mettre à jour le contenu de la lightbox en fonction de l'index actuel
    function updateLightboxContent() {
        var currentImage = imagesInLightbox[currentImageIndex];
        var reference = $(currentImage).data('reference');
        var categorie = $(currentImage).data('categorie');
        var imageUrl = $(currentImage).data('image-url');

        // Mettez à jour les informations dans la lightbox
        $(".lightbox__container__info p:first-child").text(reference);
        $(".lightbox__container__info p:last-child").text(categorie);
        $(".lightbox__container img").attr('src', imageUrl);
    }
});
