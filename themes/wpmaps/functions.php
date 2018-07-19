<?php
// Let WordPress manage the document title.
add_theme_support( 'title-tag' );;
// Hide admin bar
show_admin_bar(false);
// Add support for thumbnails
add_theme_support( 'post-thumbnails' ); 
// Register menus
function register_my_menus() {
  register_nav_menus(
    array(
      // 'header-menu' => __( 'Header Menu' ),
      'first-menu' => __( 'First Menu' ),
      'footer-menu-1' => __( 'Footer Menu 1' ),
      'footer-menu-2' => __( 'Footer Menu 2' ),
      'footer-menu-3' => __( 'Footer Menu 3' ),
      'footer-menu-4' => __( 'Footer Menu 4' )
    )
  );
}
add_action( 'init', 'register_my_menus' );

// Register ACF fields to REST API
function add_fields_to_api($response, $post) {
  $deslocamento = get_field('deslocamento', $post->ID);
  $thumbnail = get_the_post_thumbnail_url($post->ID, 'thumbnail');
  $medium = get_the_post_thumbnail_url($post->ID, 'medium');
  $large = get_the_post_thumbnail_url($post->ID, 'large');
  $response->data['img_thumbnail'] = $thumbnail;
  $response->data['img_medium'] = $medium;
  $response->data['img_large'] = $large;
  return $response;
}
function add_roteiro_to_api($response, $post) {
  $deslocamento = get_field('deslocamento', $post->ID);
  $categoria = get_field('categoria', $post->ID);
  $cidades = get_the_terms( $post->ID, 'cidade' );
  $cidadeString = "";
  foreach ($cidades as $cidade) {
    $cidadeString .= $cidade->name;
    $cidadeString .= ", ";

    $response->data[$cidade->name] = $cidade->name;
  }
  $cidadeString = substr($cidadeString, 0, -2);
  $response->data['cidades'] = $cidades;
  $response->data['cidadeString'] = $cidadeString;
  $response->data['deslocamento'] = $deslocamento;
  $response->data['categoria'] = $categoria->name;
  return $response;
}
function add_sitio_to_api($response, $post) {
  $endereco = get_field('endereco', $post->ID);
  $lat = get_field('lat', $post->ID);
  $lng = get_field('lng', $post->ID);

  $response->data['endereco'] = $endereco;
  $response->data['lat'] = $lat;
  $response->data['lng'] = $lng;

  return $response;
}
add_filter('rest_prepare_sitio', 'add_fields_to_api', 10, 3);
add_filter('rest_prepare_roteiro', 'add_fields_to_api', 10, 3);
add_filter('rest_prepare_sitio', 'add_sitio_to_api', 10, 3);
add_filter('rest_prepare_roteiro', 'add_roteiro_to_api', 10, 3);

// Create Cidade taxonomy
add_action( 'init', 'create_custom_taxonomies', 0 );
function create_custom_taxonomies() {
	$labels = array(
		'name'              => _x( 'Cidade', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Cidade', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Buscar Cidade', 'textdomain' ),
		'all_items'         => __( 'Todos Cidade', 'textdomain' ),
		'edit_item'         => __( 'Editar Cidade', 'textdomain' ),
		'update_item'       => __( 'Update  Cidade', 'textdomain' ),
		'add_new_item'      => __( 'Adicionar Nova Cidade', 'textdomain' ),
		'new_item_name'     => __( 'Nome da Cidade', 'textdomain' ),
		'menu_name'         => __( 'Cidades', 'textdomain' ),
	);
	$args = array(
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'cidade' ),
		'update_count_callback' => '_update_post_term_count',
		'show_in_rest'			=> true,
	);
	register_taxonomy( 'cidade', array( 'sitio', 'roteiro' ), $args );
}

// Add latitude and longitude notices on post screen
	 function wpc_admin_notices(){
	     global $current_screen;
	     if ( $current_screen->base == 'post' &&  $current_screen->id == 'sitio')
	          echo '<div class="notice notice-info is-dismissible"><p>Deseja atualizar os valores de latitude e longitude desse post? <a target="_blank" href="http://erasmos.local/updatecord?id=' . $_GET['post'] . '">Clique aqui</a><br><small>Esta opção deve ser utilizada para preencher automaticamente os campos latitude e longitude a partir de um <b>endereço</b>.</small></p></div>';
	}
add_action( 'admin_notices', 'wpc_admin_notices' );

// Create Sitio and Roteiro post type
function create_post_type() {
  register_post_type( 'sitio',
    array(
      'labels' => array(
        'name' => __( 'Sítios' ),
        'singular_name' => __( 'Sítio' ),
      	'add_new_item' => 'Cadastrar novo sítio',
      ),
      'public' => true,
      'has_archive' => true,
      'show_in_rest' => true,
      'menu_icon' => 'dashicons-location',
      'taxonomies' => array('cidade', 'category'),
      'supports' => array(
      	'title', 'thumbnail'
      )
    )
  );
  register_post_type( 'roteiro',
    array(
      'labels' => array(
        'name' => __( 'Roteiros' ),
        'singular_name' => __( 'Roteiro' ),
        'add_new_item' => 'Cadastrar novo roteiro',
      ),
      'public' => true,
      'has_archive' => true,
      'show_in_rest' => true,
      'menu_icon' => 'dashicons-location-alt',
      'supports' => array(
        'title', 'thumbnail', 'editor'
      )
    )
  );
  register_post_type( 'evento',
    array(
      'labels' => array(
        'name' => __( 'Apresentações' ),
        'singular_name' => __( 'Apresentação' ),
        'add_new_item' => 'Cadastrar novo apresentação',
      ),
      'public' => true,
      'has_archive' => true,
      'show_in_rest' => true,
      'menu_icon' => 'dashicons-calendar-alt',
      'supports' => array(
        'title', 'custom-fields', 'taxonomy'
      )
    )
  );
}
add_action( 'init', 'create_post_type' );

require_once('inc/bs4navwalker.php');
?>