<?php

// ACF commands
require_once( 'inc/class-acf-commands.php' );

// Logging functions
require_once( 'inc/log.php' );

// CORS handling
require_once( 'inc/cors.php' );

// Admin modifications
require_once( 'inc/admin.php' );

// Add Menus
require_once( 'inc/menus.php' );

// Add Headless Settings area
require_once( 'inc/acf-options.php' );

// Add custom API endpoints here


// DD - Custom setup hook to add post formats support
function dd_hlwp_setup() {

  /*
   * Enable support for Post Formats.
   *
   * See: https://codex.wordpress.org/Post_Formats
   */
  add_theme_support( 'post-formats', array(
    'link',
    'quote',
    'image',
    'video',
    // 'aside',
    // 'gallery',
    // 'audio',
  ) );
}
add_action( 'after_setup_theme', 'dd_hlwp_setup' );


function demaree_get_link_url() {
  $has_content_url = get_url_in_content( get_the_content() );
  $has_custom_url = get_post_meta( get_the_ID(), 'link_url', true);

  if($has_custom_url) {
    return $has_custom_url;
  } elseif ($has_content_url) {
    return $has_content_url;
  } else {
    return apply_filters( 'the_permalink', get_permalink() );
  }
}


add_action( 'rest_api_init', 'register_metas');
function register_metas() {
  register_meta('post', 'link_url', array(
    'show_in_rest' => true,
    'single' => true,
    'type' => 'string',
    'description' => 'External URL for link posts'	
  ));
}

add_action( 'rest_api_init', 'slug_register_link_url' );
function slug_register_link_url() {
  register_rest_field( 'post',
    'link_url',
    array(
      'get_callback'    => 'slug_get_link_url',
      'update_callback' => null,
      'schema'          => null,
    )
  );

  register_rest_field('post',
    'previous_post',
    array(
      'get_callback' => function( $object, $field_name, $request ) {
        if( $prevpost = get_adjacent_post( false, '', true ) ) {
          return array(
            'id' => $prevpost->ID,
            'title' => $prevpost->post_title,
            'excerpt' => $prevpost->post_excerpt,
            'status' => $prevpost->post_status,
            'date' => $prevpost->post_date_gmt,
            'slug' => $prevpost->post_name
          );
        } else {
          return null;
        }
      },
      'schema' => null
    )
  );

  register_rest_field('post',
          'next_post',
          array(
                  'get_callback' => function( $object, $field_name, $request ) {
                          if( $prevpost = get_adjacent_post( false, '', false ) ) {
                                  return array(
                                          'id' => $prevpost->ID,
                                          'title' => $prevpost->post_title,
                                          'excerpt' => $prevpost->post_excerpt,
                                          'status' => $prevpost->post_status,
                                          'date' => $prevpost->post_date_gmt,
                                          'slug' => $prevpost->post_name
                                  );
                          } else {
                                  return null;
                          }
                  },
                  'schema' => null
          )
  );

}

/**
 * Get the value of the "starship" field
 *
 * @param array $object Details of current post.
 * @param string $field_name Name of field.
 * @param WP_REST_Request $request Current request
 *
 * @return mixed
 */
function slug_get_link_url( $object, $field_name, $request ) {
  return get_post_meta( $object[ 'id' ], $field_name, true );
}


