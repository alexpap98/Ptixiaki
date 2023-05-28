<?php
// Include custom taxonomy walker
require_once( get_stylesheet_directory() . '/custom-walkers/custom-taxonomy-menu-walker.php' );

// Enqueue parent theme styles
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

// Add livereload script
add_action('wp_head', 'live_reload_script');
function live_reload_script() {
    echo '<script src="//localhost:35729/livereload.js"></script>';
}

// Use custom walker for "Subjects" custom taxonomy
function my_custom_nav_menu_args($args) {
  // Get the current menu location
  $current_menu_location = $args['theme_location'];

  // Check if the menu location is the "Subjects" custom taxonomy
  if ( 'subjects' === $current_menu_location ) {
    // Set the walker to be the custom taxonomy menu walker
    $args['walker'] = new Custom_Taxonomy_Menu_Walker();
  }
  
  return $args;
}



//test

add_filter( 'wp_nav_menu_args', 'my_custom_nav_menu_args' );
