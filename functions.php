<?php

// IMPORTER FEUILLE CSS ET JS

function motaphoto_register_assets() {
    
    // Déclarer jQuery
    wp_enqueue_script('jquery' );
    
    // bibliotheque Select
   // wp_enqueue_style('select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
    //wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), '', true);

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

// Définition de la fonction motaphoto_load_more
function motaphoto_load_more() {
  // Création d'une nouvelle requête WordPress pour récupérer des posts de type 'photo'
    $ajaxposts = new WP_Query([
      'post_type' => 'photo',
      'posts_per_page' => 12,
      'paged' => $_POST['paged'],
    ]);
  // Initialisation de la chaîne de réponse
    $response = '';
    // Récupération du nombre maximum de pages de la requête
    $max_pages = $ajaxposts->max_num_pages;
  
    // Vérification s'il y a des posts dans la requête
    if($ajaxposts->have_posts()) {
      // Mise en tampon de la sortie pour éviter de l'afficher immédiatement
        ob_start();
        // Boucle à travers les posts
        while($ajaxposts->have_posts()) : $ajaxposts->the_post();
        // Ajout du contenu du template 'photo_block' à la réponse
        $response .= get_template_part( 'templates_part/photo_block' );
      endwhile;
      // Récupération du contenu mis en tampon
      $output = ob_get_contents();
    ob_end_clean();
    } else {
      // Aucun post trouvé, la réponse reste vide
      $response = '';
    }
  // Création d'un tableau associatif avec le nombre maximal de pages et le HTML généré
    $result = [
        'max' => $max_pages,
        'html' => $output,
      ];
    // Encodage du tableau en format JSON et envoi de la réponse
      echo json_encode($result);
      exit;
    }
    // Ajout de la fonction aux actions WordPress pour les requêtes AJAX
    add_action('wp_ajax_motaphoto_load_more', 'motaphoto_load_more');
    add_action('wp_ajax_nopriv_motaphoto_load_more', 'motaphoto_load_more');

    // cette fonction effectue une recherche de photos, génère le code HTML associé, et envoie ces données au navigateur de l'utilisateur afin d'être affichées dynamiquement sans recharger toute la page.