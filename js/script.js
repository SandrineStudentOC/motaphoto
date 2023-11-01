// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.querySelector(".myBtn-contact");

// Get the <span> element that closes the modal
//var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "flex";

}

// When the user clicks on <span> (x), close the modal
//span.onclick = function() {
  //  modal.style.display = "none";
//}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.classList.add('fade-out');
        setTimeout(function() {
            modal.style.display = "none";
            modal.classList.remove('fade-out'); 
        }, 1000); 
    }
}


// Ouverture modale bouton contact dans page single-photo.php avec un gestionnaire d'évènement

// Get the button that opens the modal
var btnContact = document.querySelector(".myBtn-contact-single");

// When the user clicks the button, open the modal 
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

// Écoute l'événement "mouseover" sur le lien suivant
linkNext.addEventListener("mouseover", function() {
    toggleImages(imageSuivante, imageActuelle, imagePrecedente);
});

// Écoute l'événement "mouseover" sur le lien precedent
linkPrevious.addEventListener("mouseover", function() {
    toggleImages(imagePrecedente, imageActuelle, imageSuivante);
});

// Écoutez l'événement "mouseout" pour les deux liens
linkPrevious.addEventListener("mouseout", function() {
    toggleImages(imageActuelle, imageSuivante, imagePrecedente);
});

linkNext.addEventListener("mouseout", function() {
    toggleImages(imageActuelle, imageSuivante, imagePrecedente);
});
