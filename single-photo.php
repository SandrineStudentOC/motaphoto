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

        <article class="article">
            
            <div class="article__post">

                <div class="article__post__meta">
                    <h1 class="article__post__meta__title"><?php the_title(); ?></h1>
                    <h2 class="article__post__meta__h2">Référence : <span id="ref-photo"><?php echo get_post_meta( get_the_ID(), 'reference', true );// template tag qui affiche les champs ACF ?></span></h2>
                    <h2 class="article__post__meta__h2">Catégorie : <?php the_terms( get_the_ID() , 'categorie' ); ?></h2>
                    <h2 class="article__post__meta__h2">Format : <?php the_terms( get_the_ID() , 'format' ); ?></h2>
                    <h2 class="article__post__meta__h2">Type : <?php echo get_post_meta( get_the_ID(), 'type', true ); ?></h2>
                    <h2 class="article__post__meta__h2">Année : <?php the_date('Y'); // template tag qui affiche la date avec comme parametre juste l'annee ?></h2>
                </div>

                <div class="article__post__photo">
                    <img class="attachment-post-thumbnail" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" alt="">
                </div>

            </div>

            <div class="article__bandeau">
                <div class="article__bandeau__contact">
                    <p>Cette photo vous intéresse ?<p>
                    <button class="myBtn-contact-single" type="button">Contact</button>
                </div>
                <div class="article__bandeau__nav">
                    <div class="article__bandeau__nav__thumbnail-container">
                        <img class="photo-actuelle" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'); ?>" alt="photo mignature">
                        <img class="photo-suivante" src="<?php echo get_the_post_thumbnail_url(get_next_post(), 'thumbnail'); ?>" alt="photo mignature">
                        <img class="photo-précédente" src="<?php echo get_the_post_thumbnail_url(get_previous_post(), 'thumbnail'); ?>" alt="photo mignature">
                    </div>
                    <div class="article__bandeau__nav__arrow">
                        <?php previous_post_link('%link', '<img class="custom-previous-link" src="' .get_template_directory_uri(). '/img/arrow-left.png" >'); ?> 
                        <?php next_post_link('%link', '<img class="custom-next-link" src="' .get_template_directory_uri(). '/img/arrow-right.png">'); ?>
                    </div> 
                    </div>   
                </div>
            </div>

        </article>    

	<?php endwhile; endif; ?>

 <?php get_footer(); ?>
