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


// EFFET HOVER SUR LA BALISE UL

document.addEventListener('DOMContentLoaded', function() {
    const customSelects = document.querySelectorAll('.custom-select');

    customSelects.forEach(select => {
        const selectHeader = select.querySelector('.select__header');
        const options = select.querySelector('.options');

        selectHeader.addEventListener('click', function() {
            // Fermer toutes les listes déroulantes
            customSelects.forEach(otherSelect => {
                if (otherSelect !== select) {
                    otherSelect.classList.remove('open');
                }
            });
            // Ouvrir/fermer la liste déroulante actuelle
            select.classList.toggle('open');
        });

        options.addEventListener('click', function(e) {
            if (e.target.classList.contains('option') && !e.target.classList.contains('disabled')) {
                const value = e.target.getAttribute('data-value');
                selectHeader.textContent = e.target.textContent;
                select.classList.remove('open');
                // Faites ce que vous voulez avec la valeur sélectionnée (par exemple, redirigez vers une autre page)
                // window.location.href = '/votre-page?value=' + value;
            }
        });
    });
});





