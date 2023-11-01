<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage motaphoto
 * @since motaphoto 1.0
 */
?>

 <?php get_header(); ?>

	<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

	<div class="hero">
                    <?php 

                        // 1. On définit les arguments pour définir ce que l'on souhaite récupérer
                        $args = array(
                            'post_type' => 'photo',
                            'posts_per_page' => 1,
                            'orderby' => 'rand',
                        );

                        // 2. On exécute la WP Query
                        $my_query = new WP_Query( $args );

                        // 3. On lance la boucle !
                        if( $my_query->have_posts() ) : while( $my_query->have_posts() ) : $my_query->the_post();?>
                                <?php the_post_thumbnail('full',['class' => 'hero__photo']);?>
                        <?php endwhile;
                        endif;

                        // 4. On réinitialise à la requête principale (important)
                        wp_reset_postdata();
                        ?>

						<h1 class="hero__title"><?php the_title(); ?></h1>
    </div>

	<div class="content">
		<div class="section-photo-block">
                    <?php 
                        // 1. On définit les arguments pour définir ce que l'on souhaite récupérer
                        $args = array(
                            'post_type' => 'photo',
                            'posts_per_page' => 12,                    
                        );

                        // 2. On exécute la WP Query
                        $my_query = new WP_Query( $args );

                        // 3. On lance la boucle !
                        if( $my_query->have_posts() ) : while( $my_query->have_posts() ) : $my_query->the_post();?>

                            <?php get_template_part( 'templates_part/photo_block' ); ?>
							
                        <?php endwhile;
                        endif;

                        // 4. On réinitialise à la requête principale (important)
                        wp_reset_postdata();
                        ?>
        </div>
		<button class="section-photo-btn" type="button">Charger plus</button>
    </div>

	<?php endwhile; endif; ?>

 <?php get_footer(); ?>
