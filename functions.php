<?php

// IMPORTER FEUILLE CSS ET JS

function motaphoto_register_assets() {
    
    // Déclarer jQuery
    wp_enqueue_script('jquery' );
    
    // Déclarer le JS
	wp_enqueue_script( 'motaphoto', get_template_directory_uri() . '/js/script.js', array( 'jquery' ), '1.0', true);
    if (is_single()) {wp_enqueue_script( 'single_photo', get_template_directory_uri() . '/js/single-photo.js', array( 'jquery' ), '1.0', true);}
    wp_enqueue_script( 'custom-post-photos', get_template_directory_uri() . '/js/custom-post-photos.js', array( 'jquery' ), '1.0', true);

    // Déclarer le fichier style.css à la racine du thème
    wp_enqueue_style( 'motaphoto',get_template_directory_uri(). '/style.css' , array(), '1.0');
  	
}
add_action( 'wp_enqueue_scripts', 'motaphoto_register_assets' );


// AFFICHE LES MENUS 

function motaphoto_supports()
{
    add_theme_support('title-tag'); // Permet d'afficher dynamiquement le title du site
    add_theme_support('menus'); // affiche l'onglet menu dans apparence de WP
    register_nav_menu('header', 'En tête du menu');
    register_nav_menu('footer', 'Pied de page');
}

add_action('after_setup_theme', 'motaphoto_supports'); // hook


// FONCTION POUR CHARGER PLUS DE PHOTOS

function motaphoto_load_more() {
    $ajaxposts = new WP_Query([
      'post_type' => 'photo',
      'posts_per_page' => 12,
      'paged' => $_POST['paged'],
    ]);
  
    $response = '';
    $max_pages = $ajaxposts->max_num_pages;
  
    if($ajaxposts->have_posts()) {
        ob_start();
        while($ajaxposts->have_posts()) : $ajaxposts->the_post();
        $response .= get_template_part( 'templates_part/photo_block' );
      endwhile;
      $output = ob_get_contents();
    ob_end_clean();
    } else {
      $response = '';
    }
  
    $result = [
        'max' => $max_pages,
        'html' => $output,
      ];
    
      echo json_encode($result);
      exit;
    }
    add_action('wp_ajax_motaphoto_load_more', 'motaphoto_load_more');
    add_action('wp_ajax_nopriv_motaphoto_load_more', 'motaphoto_load_more');