// Récupérer la fenêtre modale
var modal = document.getElementById('myModal');

// Récupérer le bouton qui ouvre la fenêtre modale
var btn = document.querySelector(".myBtn-contact");

// Lorsque l'utilisateur clique sur le bouton, ouvrir la fenêtre modale
btn.onclick = function() {
    modal.style.display = "flex";
}

// Lorsque l'utilisateur clique n'importe où en dehors de la fenêtre modale, la fermer
window.onclick = function(event) {
    if (event.target == modal) {
        modal.classList.add('fade-out');
        setTimeout(function() {
            modal.style.display = "none";
            modal.classList.remove('fade-out'); 
        }, 1000); 
    }
}


// EFFET HOVER SUR LA BALISE UL

document.addEventListener('DOMContentLoaded', function() {
    const customSelects = document.querySelectorAll('.custom-select');

    customSelects.forEach(select => {
        const selectHeader = select.querySelector('.select__header');
        const options = select.querySelector('.options');
        const btnArrow = select.querySelector('.btn-arrow');

        selectHeader.addEventListener('click', function() {
            // Fermer toutes les listes déroulantes
            customSelects.forEach(otherSelect => {
                if (otherSelect !== select) {
                    otherSelect.classList.remove('open');
                    const otherBtnArrow = otherSelect.querySelector('.btn-arrow');
                    if (otherBtnArrow) {
                        otherBtnArrow.classList.remove('arrow-rotated');
                    }
                }
            });

                     // Ouvrir/fermer la liste déroulante actuelle
                     const isOpen = select.classList.toggle('open');

                     // Ajouter/retirer la classe .arrow-rotated au div btn-arrow en fonction de l'état du select
                     if (btnArrow) {
                         btnArrow.classList.toggle('arrow-rotated', isOpen);
                     }
                 });
         
                 select.addEventListener('mouseleave', function() {
                      // Fermer le select lorsque le curseur quitte le select
                    select.classList.remove('open');
                     // Retirer la classe .arrow-rotated lorsque le curseur quitte le select
                     if (btnArrow) {
                         btnArrow.classList.remove('arrow-rotated');
                     }
                 });

        options.addEventListener('click', function(e) {
            if (e.target.classList.contains('option') && !e.target.classList.contains('disabled')) {
                const value = e.target.getAttribute('data-value');
                selectHeader.textContent = e.target.textContent;
                select.classList.remove('open');
            }
        });
    });
});


// GESTION DU MENU BURGER

icons.addEventListener("click", () => {
    nav.classList.toggle("active");
}); 