<?php

// IMPORTER FEUILLE CSS ET JS

function motaphoto_register_assets() {
    
    // Déclarer jQuery
    wp_enqueue_script('jquery' );
    
    // Déclarer le JS
	  wp_enqueue_script( 'motaphoto', get_template_directory_uri() . '/js/script.js', array( 'jquery' ), '1.0', true);

    if (is_single()) {wp_enqueue_script( 'single_photo', get_template_directory_uri() . '/js/single-photo.js', array( 'jquery' ), '1.0', true);}

    wp_enqueue_script( 'custom-post-photos', get_template_directory_uri() . '/js/custom-post-photos.js', array( 'jquery' ), '1.0', true);
    
    wp_enqueue_script( 'lightbox', get_template_directory_uri() . '/js/lightbox.js', array( 'jquery' ), '1.0', true);

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


// Fonction pour enregistrer les filtres de photo dans les options de WordPress
//Cette fonction prend un tableau $filters en paramètre et utilise update_option pour enregistrer ces filtres dans les options de WordPress sous le nom 'photo_filters'.
function update_photo_filters($filters) {
  update_option('photo_filters', $filters);
}

// Fonction pour récupérer les filtres de photo depuis les options de WordPress
//Cette fonction utilise get_option pour récupérer les filtres de photo enregistrés dans les options de WordPress. Si les filtres ne sont pas définis, elle renvoie un tableau par défaut.
function get_photo_filters() {
  
  return get_option('photo_filters', [
      'categorie' => '',
      'format' => '',
      'date_order' => 'DESC',
  ]);
}

// Fonction pour charger plus de photos avec AJAX
function motaphoto_load_more() {

  // Création d'une nouvelle requête WordPress pour récupérer des posts de type 'photo'
  $ajaxposts = new WP_Query([
      'post_type' => 'photo',
      'posts_per_page' => 12,
      'paged' => $_POST['paged'],
      'orderby' => 'date', // Tri par date par défaut
      'order' => get_photo_filters()['date_order'], // Utilisation de l'ordre défini dans les filtres
      'tax_query' => [
          'relation' => 'AND',
      ],
  ]);

  // Initialisation de la chaîne de réponse
  $response = '';

  // Récupération du nombre maximum de pages de la requête
  $max_pages = $ajaxposts->max_num_pages;

  // Vérification s'il y a des posts dans la requête
  if ($ajaxposts->have_posts()) {
      // Mise en tampon de la sortie pour éviter de l'afficher immédiatement
      ob_start();

      // Boucle à travers les posts
      while ($ajaxposts->have_posts()) : $ajaxposts->the_post();
          // Ajout du contenu du template 'photo_block' à la réponse
          $response .= get_template_part('templates_part/photo_block');
      endwhile;

      // Récupération du contenu mis en tampon
      $output = ob_get_contents();
      ob_end_clean();
  } else {
      // Aucun post trouvé, la réponse reste vide
      $response = '';
      $output = '';
  }

  // Récupération des filtres actuels
  $filters = get_photo_filters();

  // Création d'un tableau associatif avec le nombre maximal de pages et le HTML généré
  $result = [
      'max' => $max_pages,
      'html' => $output,
      'filters' => $filters,
  ];

  // Encodage du tableau en format JSON et envoi de la réponse
  echo json_encode($result);
  exit;
}

// Ajout de la fonction aux actions WordPress pour les requêtes AJAX
add_action('wp_ajax_motaphoto_load_more', 'motaphoto_load_more');
add_action('wp_ajax_nopriv_motaphoto_load_more', 'motaphoto_load_more');

// FILTRER LES POSTS AVEC AJAX
function filter_photos() {
  // Récupération du numéro de page depuis la requête
  $paged = $_POST['paged'] ?? 1;

  // Récupération des filtres précédemment appliqués
  $filters = get_photo_filters();

  // Met à jour les filtres en fonction de la requête actuelle
  if (isset($_POST['categorie'])) {
      $filters['categorie'] = $_POST['categorie'];
  }

  if (isset($_POST['format'])) {
      $filters['format'] = $_POST['format'];
  }

  // Utilisation de la valeur par défaut 'DESC' si $_POST['date_order'] n'est pas défini
  $filters['date_order'] = $_POST['date_order'] ?? 'DESC';

  // Mise à jour des filtres
  update_photo_filters($filters);

  // Construit la requête en fonction des filtres
  $args = [
      'post_type' => 'photo',
      'posts_per_page' => 12,
      'paged' => $paged,
      'orderby' => 'date', // Tri par date par défaut
      'order' => $filters['date_order'], // Utilisation de l'ordre défini dans les filtres
      'tax_query' => [
          'relation' => 'AND',
      ],
  ];

  if (!empty($filters['categorie'])) {
      $args['tax_query'][] = [
          'taxonomy' => 'categorie',
          'field' => 'slug',
          'terms' => $filters['categorie'],
      ];
  }

  if (!empty($filters['format'])) {
      $args['tax_query'][] = [
          'taxonomy' => 'format',
          'field' => 'slug',
          'terms' => $filters['format'],
      ];
  }


    // Ajoutez un log pour afficher les filtres dans la console PHP
    error_log('Filtre catégorie : ' . $filters['categorie']);
    error_log('Filtre format : ' . $filters['format']);
    error_log('Filtre date_order : ' . $filters['date_order']);

  $ajaxposts = new WP_Query($args);

  // Initialisation de la chaîne de réponse
  $response = '';

  // Récupération du nombre maximum de pages de la requête
  $max_pages = $ajaxposts->max_num_pages;

  // Vérification s'il y a des posts dans la requête
  if ($ajaxposts->have_posts()) {
      // Mise en tampon de la sortie pour éviter de l'afficher immédiatement
      ob_start();

      // Boucle à travers les posts
      while ($ajaxposts->have_posts()) : $ajaxposts->the_post();
          // Ajout du contenu du template 'photo_block' à la réponse
          $response .= get_template_part('templates_part/photo_block');
      endwhile;

      // Récupération du contenu mis en tampon
      $output = ob_get_contents();
      ob_end_clean();
  } else {
      // Aucun post trouvé, la réponse reste vide
      $response = '';
      $output = '';
  }

      // Ajoutez un log pour afficher la sortie dans la console PHP
      error_log('Output of AJAX request: ' . $output);

  // Récupération des filtres actuels
  $filters = get_photo_filters();

  // Création d'un tableau associatif avec le nombre maximal de pages et le HTML généré
  $result = [
      'max' => $max_pages,
      'html' => $output,
      'filters' => $filters,
  ];

  // Encodage du tableau en format JSON et envoi de la réponse
  echo json_encode($result);
  exit;
}

add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');