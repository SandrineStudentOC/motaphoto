
// Ouverture modale bouton contact dans page single-photo.php avec un gestionnaire d'évènement

// Récupére le bouton qui ouvre la fenêtre modale
var btnContact = document.querySelector(".myBtn-contact-single");

// Lorsque l'utilisateur clique sur le bouton, ouvrir la fenêtre modale 
btnContact.onclick = function() {
    modal.style.display = "flex";
}

// Ouverture de la modale avec la ref photo préremplie
jQuery(function($){
    $(document).ready(function(){
        $("#wpforms-24-field_3").val($('#ref-photo').text()); //Sélectionne l'élément HTML avec l'ID "wpforms-24-field_3" (champ de formulaire) et sélectionne l'élément HTML avec l'ID "ref-photo" et récupère son contenu textuel (le texte à l'intérieur de cet élément).
      });
    });

// SINGLE-PHOTO.php
// Affiche la photo miniature du lien précédent ou suivant au survol

// Récupère les liens "précédent" et "suivant" par leurs classes personnalisées
var linkPrevious = document.querySelector(".custom-previous-link");
var linkNext = document.querySelector(".custom-next-link");

// Récupère l'élément qui contient l'image miniature
var thumbnailContainer = document.querySelector(".article__bandeau__nav__thumbnail-container");

// Récupère les 3 vignettes/images dans le HTML
var imageActuelle = document.querySelector(".photo-actuelle");
var imageSuivante = document.querySelector(".photo-suivante");
var imagePrecedente = document.querySelector(".photo-precedente");


// Fonction pour gérer l'affichage des images
function toggleImages(showImage, hideImage1, hideImage2) {
    showImage.style.display = "flex";
    hideImage1.style.display = "none";
    hideImage2.style.display = "none";
}

// Écoute l'événement "mouseover" sur le lien suivant et précédent
if (linkNext) {
    linkNext.addEventListener("mouseover", function() {
    toggleImages(imageSuivante, imageActuelle, imagePrecedente);
    });
}

if (linkPrevious) {
    linkPrevious.addEventListener("mouseover", function() {
    toggleImages(imagePrecedente, imageActuelle, imageSuivante);
    });
}

// Écoutez l'événement "mouseout" sur le lien suivant et précédent
if (linkPrevious) {
    linkPrevious.addEventListener("mouseout", function() {
    toggleImages(imageActuelle, imageSuivante, imagePrecedente);
    });
}

if (linkNext) {
    linkNext.addEventListener("mouseout", function() {
    toggleImages(imageActuelle, imageSuivante, imagePrecedente);
    });
}