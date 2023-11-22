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

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div class="hero">
        <?php

        // 1. On définit les arguments pour définir ce que l'on souhaite récupérer
        $args = array(
            'post_type' => 'photo',
            'posts_per_page' => 1,
            'orderby' => 'rand',
        );

        // 2. On exécute la WP Query
        $my_query = new WP_Query($args);

        // 3. On lance la boucle !
        if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post(); ?>
                <?php the_post_thumbnail('full', ['class' => 'hero__photo']); ?>
        <?php endwhile;
        endif;

        // 4. On réinitialise à la requête principale (important)
        wp_reset_postdata();
        ?>

        <h1 class="hero__title"><?php the_title(); ?></h1>
    </div>

    <div class="content">

        <div class="select">
            <div class="select__taxonomy">

                <div class="select__taxonomy__categorie">
                    <?php $categories = get_categories(array('taxonomy' => 'categorie')); ?>
                    <div class="custom-select">
                        <div class="select__header">Catégories</div>
                        <div class="btn-arrow"><img src="<?php echo get_template_directory_uri(); ?>/img/btn_arrow.svg" alt="bouton flèche"></div>

                        <ul class="options">
                            <li data-slug="" class="option categorie all">Toutes les catégories</li>

                            <?php foreach ($categories as $category) : ?>
                                <li data-slug="<?= $category->slug; ?>" class="option categorie"><?= $category->name; ?></li>
                            <?php endforeach; ?>
                        </ul>

                    </div>
                </div>

                <div class="select__taxonomy__formats">
                    <?php $formats = get_categories(array('taxonomy' => 'format')); ?>
                    <div class="custom-select">
                        <div class="select__header">Formats</div>
                        <div class="btn-arrow"><img src="<?php echo get_template_directory_uri(); ?>/img/btn_arrow.svg" alt="bouton flèche"></div>
                        <ul class="options">
                            <li data-slug="" class="option format active">Tous les formats</li>

                            <?php foreach ($formats as $format) : ?>
                                <li data-slug="<?= $format->slug; ?>" class="option format"><?= $format->name; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="select__date">
                <div class="custom-select custom-select-date ">
                    <div class="select__header">Trier par</div>
                    <div class="btn-arrow"><img src="<?php echo get_template_directory_uri(); ?>/img/btn_arrow.svg" alt="bouton flèche"></div>
                    <ul class="options">
                        <li data-slug="" class="option disabled">Trier par</li>
                        <li data-slug="date-recent" class="option date_recent">des plus récentes aux plus anciennes</li>
                        <li data-slug="date-ancien" class="option date_ancien">des plus anciennes au plus récentes</li>
                    </ul>
                </div>
            </div>

        </div>

        <?php
        // Utilisez cette partie de code pour récupérer les 12 premières photos sans filtrage
        $args = array(
            'post_type' => 'photo',
            'posts_per_page' => 12,
            'paged' => 1,
        );

        $projects = new WP_Query($args);

        if ($projects->have_posts()) : ?>
            <div class="section-photo-block">
                <?php while ($projects->have_posts()) : $projects->the_post();
                    get_template_part('templates_part/photo_block');
                endwhile; ?>
            </div>
        <?php endif;
        wp_reset_postdata(); ?>

<?php
// Vérifie s'il y a plus de pages à charger
        if ($projects->max_num_pages > 1) : ?>
        <button class="section-photo-btn" id="load-more" type="button">Charger plus</button>
    </div>
    <?php endif; ?>

<?php endwhile;
endif; ?>

<?php get_footer(); ?>
