(function ($) {
    $(document).ready(function () {

let currentPage = 1;

$('#load-more').on('click', function() {
    currentPage++; 

    $.ajax({
        type: 'POST',
        url: './wp-admin/admin-ajax.php',
        dataType: 'html',
        data: {
          action: 'weichie_load_more',
          paged: currentPage,
        },

        
        success: function (res) {
          $('.section-photo-block').append(res);
          
        }
      });
    })

});
})(jQuery);