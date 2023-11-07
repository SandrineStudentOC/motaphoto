// CHARGER PLUS DE MESSAGE AVEC AJAX - Demande d'une requête ajax à admin-ajax.php
// cf. https://weichie.com/blog/load-more-posts-ajax-wordpress/

(function ($) { // use jQuery code inside this to avoid "$ is not defined" error
    $(document).ready(function () {

let currentPage = 1;

$('#load-more').on('click', function() {
    currentPage++; 

    $.ajax({
        type: 'POST',
        url: './wp-admin/admin-ajax.php',
        dataType: 'json',
        data: {
          action: 'motaphoto_load_more',
          paged: currentPage,
        },
        
        success: function (res) {
            if(currentPage >= res.max) {
                $('#load-more').hide();
              }
          $('.section-photo-block').append(res.html);
          
        }
      });
    })

});
})(jQuery);