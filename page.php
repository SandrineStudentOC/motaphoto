<?php get_header(); ?>

<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
        
        <div class="container__page">
    
            <?php the_content(); ?>
            
        </div>
    
        <?php endwhile; endif; ?>

<?php get_footer(); ?>
