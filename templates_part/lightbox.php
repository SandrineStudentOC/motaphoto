<div id="myLightbox" class="lightbox">
    <button class="lightbox__close"></button>
    <button class="lightbox__next">Suivant</button>
    <button class="lightbox__prev">Précédent</button>
    <div class="lightbox__container">
        <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" alt="">
        <div class="lightbox__container__info">
            <p>Référence de la photo</p>
            <p>Catégorie</p>
        </div>
    </div> 
</div>