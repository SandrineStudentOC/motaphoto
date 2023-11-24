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
 <!doctype html>
 <html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <?php wp_head(); // Fonction qui permet ...  ?> 
    </head>

    <body <?php body_class(); ?>>

    <?php wp_body_open(); ?>

    <header class="header">
        <nav  id="nav" class="header__navigation">
            <img class="header__navigation__image" src="<?php echo get_template_directory_uri(); ?>/img/logo_nathalie_mota.svg" alt="logo">
                <?php
                wp_nav_menu([
                    'theme_location' => 'header',
                    'container' => 'ul', // afin d'éviter d'avoir une div autour 
                    'menu_class' => 'header__navigation__menu', // ma classe personnalisée 
                    ])
                ?>
                <div id="icons"></div>
        </nav>
    </header>
        
