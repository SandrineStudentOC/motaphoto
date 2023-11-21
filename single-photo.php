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
                    <h2 class="article__post__meta__h2">Catégorie : <?php $categories = get_the_terms(get_the_ID(), 'categorie');
                        if ($categories && !is_wp_error($categories)) {
                            echo implode(', ', wp_list_pluck($categories, 'name'));
                        }?>
                    </h2>
                    <h2 class="article__post__meta__h2">Format : <?php $formats = get_the_terms(get_the_ID(), 'format');
                        if ($formats && !is_wp_error($formats)) {
                            echo implode(', ', wp_list_pluck($formats, 'name'));
                        }?>
                    </h2>
                    <h2 class="article__post__meta__h2">Type : <?php echo get_post_meta( get_the_ID(), 'type', true ); ?></h2>
                    <h2 class="article__post__meta__h2">Année : <?php the_date('Y'); // template tag qui affiche la date avec comme parametre juste l'annee ?></h2>
                </div>

                <div class="article__post__photo">
                    <div class="bloc-picto-single">
                        <div class="bloc__image__fullscreen-single">
                            <a href="#" class="picto-fullscreen"
                            data-reference="<?php echo get_post_meta(get_the_ID(), 'reference', true); ?>"
                            data-categorie="<?php
                            $categories = get_the_terms(get_the_ID(), 'categorie');
                            if ($categories && !is_wp_error($categories)) {
                            echo esc_attr(implode(', ', wp_list_pluck($categories, 'name')));
                            }?>"
                            data-image-url="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>"
                            ><img  src="<?php echo get_template_directory_uri(); ?>/img/icon_fullscreen.svg" alt="picto plein ecran"></a>
                        </div>
                    </div>
                    <img class="attachment-post-thumbnail" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large',); ?>" alt="<?php the_title(); ?>">
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
                        <img class="photo-precedente" src="<?php echo get_the_post_thumbnail_url(get_previous_post(), 'thumbnail'); ?>" alt="photo mignature">
                    </div>
                    <div class="article__bandeau__nav__arrow">
                        <?php previous_post_link('%link', '<img class="custom-previous-link" src="' .get_template_directory_uri(). '/img/arrow-left.png" >'); ?> 
                        <?php next_post_link('%link', '<img class="custom-next-link" src="' .get_template_directory_uri(). '/img/arrow-right.png">'); ?>
                    </div> 
                    </div>   
                </div>
            </div>

        </article>    

        <div class="photo-apparentees">
            <p class="photo-apparentees__titre">Vous aimerez aussi</p>
            <div class="photo-apparentees__bloc">
                <div class="section-photo-block">
                    <?php 
                        // 0. Recupère dynamiquement la catégorie de l'article en cours
                        $categories = array_map(function ($term) {
                            return $term->term_id;
                        }, get_the_terms(get_post(), 'categorie'));


                        // 1. On définit les arguments pour définir ce que l'on souhaite récupérer
                        $args = array(
                            'post__not_in' => [get_the_ID()],
                            'post_type' => 'photo',
                            'posts_per_page' => 2,
                            'paged' => 1, //ajout pour ajax
                            'orderby' => 'rand',
                            'tax_query' => [
                                [
                                    'taxonomy' => 'categorie',
                                    'terms' => $categories,
                                ]
                            ]
                            
                        
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
                
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="home-btn">
                    <button class="section-photo-btn" type="button" >Toutes les photos</button>
                </a>
            
            </div>

	<?php endwhile; endif; ?>

 <?php get_footer(); ?>
