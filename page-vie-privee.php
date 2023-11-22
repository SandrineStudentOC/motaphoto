<?php get_header(); ?>

    <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

        <div class="container_vie-privee">
            
            <h1><?php the_title(); ?></h1>

            <div class="container_vie-privee__p">

                <?php the_content(); ?>

            </div>

        </div>

    <?php endwhile; endif; ?>


<?php get_footer(); ?>