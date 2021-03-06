<?php
/**
 * Cardio functions and definitions
 *
 * @package Cardio
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */

if ( ! function_exists( 'cardio_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function cardio_setup() {

	if ( ! isset( $content_width ) )
		$content_width = 640; /* pixels */

	load_theme_textdomain( 'cardio', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'title-tag' );
	add_image_size('cardio-homepage-thumb',240,145,true);
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'cardio' ),
		'footer'	=> __('Footer Menu', 'cardio'),
	) );
	add_theme_support( 'custom-background', array(
		'default-color' => 'ffffff'
	) );
	add_editor_style( 'editor-style.css' );
}
endif; // cardio_setup
add_action( 'after_setup_theme', 'cardio_setup' );

function cardio_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'cardio' ),
		'description'   => __( 'Appears on blog page sidebar', 'cardio' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Page Sidebar', 'cardio' ),
		'description'   => __( 'Appears on page sidebar', 'cardio' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

}
add_action( 'widgets_init', 'cardio_widgets_init' );

function cardio_font_url(){
		$font_url = '';
		
		/* Translators: If there are any character that are
		* not supported by Oswald, translate this to off, do not
		* translate into your own language.
		*/
		$oswald = _x('on', 'Oswald font:on or off','cardio');
		
		/* Translators: If there are any character that are
		* not supported by Roboto, translate this to off, do not
		* translate into your own language.
		*/
		$roboto = _x('on', 'Roboto font:on or off','cardio');
		
		/* Translators: If there are any character that are
		* not supported by Roboto Condensed, translate this to off, do not
		* translate into your own language.
		*/
		$roboto_cond = _x('on', 'Roboto Condensed font:on or off','cardio');
		
		if('off' !== $oswald || 'off' !==  $roboto || 'off' !== $roboto_cond){
			$font_family = array();
			
			if('off' !== $oswald){
				$font_family[] = 'Oswald:300,400,600,700,800,900';
			}
			
			if('off' !== $roboto){
				$font_family[] = 'Roboto:400,700';
			}
			
			if('off' !== $roboto_cond){
				$font_family[] = 'Roboto Condensed:400,700';
			}
			
			$query_args = array(
				'family'	=> urlencode(implode('|',$font_family)),
			);
			
			$font_url = add_query_arg($query_args,'//fonts.googleapis.com/css');
		}
		
	return $font_url;
	}

function cardio_scripts() {
	wp_enqueue_style( 'cardio-font', cardio_font_url(), array() );
	wp_enqueue_style( 'cardio-basic-style', get_stylesheet_uri() );
	wp_enqueue_style( 'cardio-editor-style', get_template_directory_uri().'/editor-style.css' );
	wp_enqueue_style( 'cardio-base-style', get_template_directory_uri().'/css/style_base.css' );
	wp_enqueue_style( 'cardio-responsive-style', get_template_directory_uri().'/css/theme-responsive.css' );
	wp_enqueue_style( 'cardio-nivo-style', get_template_directory_uri().'/css/nivo-slider.css' );
	wp_enqueue_script( 'cardio-nivo-slider', get_template_directory_uri() . '/js/jquery.nivo.slider.js', array('jquery') );
	wp_enqueue_script( 'cardio-customscripts', get_template_directory_uri() . '/js/custom.js', array('jquery') );
	wp_enqueue_style( 'cardio-font-awesome-style', get_template_directory_uri().'/css/font-awesome.css' );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'cardio_scripts' );

function cardio_pagination() {
	global $wp_query;
	$big = 12345678;
	$page_format = paginate_links( array(
	    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	    'format' => '?paged=%#%',
	    'current' => max( 1, get_query_var('paged') ),
	    'total' => $wp_query->max_num_pages,
	    'type'  => 'array'
	) );
	if( is_array($page_format) ) {
		$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
		echo '<div class="pagination"><div><ul>';
		echo '<li><span>'. $paged . ' of ' . $wp_query->max_num_pages .'</span></li>';
		foreach ( $page_format as $page ) {
			echo "<li>$page</li>";
		}
		echo '</ul></div></div>';
	}
}
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

// URL DEFINES
define('cardio_pro_theme_url','http://flythemes.net/wordpress-themes/cardio-wordpress-theme/');
define('cardio_theme_doc','http://flythemesdemo.net/documentation/cardio-doc/');
define('cardio_site_url','http://flythemes.net/');


function cardio_custom_blogpost_pagination( $wp_query ){
	$big = 999999999; // need an unlikely integer
	if ( get_query_var('paged') ) { $pageVar = 'paged'; }
	elseif ( get_query_var('page') ) { $pageVar = 'page'; }
	else { $pageVar = 'paged'; }
	$pagin = paginate_links( array(
		'base' 			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' 		=> '?'.$pageVar.'=%#%',
		'current' 		=> max( 1, get_query_var($pageVar) ),
		'total' 		=> $wp_query->max_num_pages,
		'prev_text'		=> '&laquo; Prev',
		'next_text' 	=> 'Next &raquo;',
		'type'  => 'array'
	) ); 
	if( is_array($pagin) ) {
		$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
		echo '<div class="pagination"><div><ul>';
		echo '<li><span>'. $paged . ' of ' . $wp_query->max_num_pages .'</span></li>';
		foreach ( $pagin as $page ) {
			echo "<li>$page</li>";
		}
		echo '</ul></div></div>';
	} 
}

// get slug by id
function cardio_get_slug_by_id($id) {
	$post_data = get_post($id, ARRAY_A);
	$slug = $post_data['post_name'];
	return $slug; 
}

function cardio_credit_link(){
		return __('Cardio theme by','cardio'). "<a href=".esc_url(cardio_site_url)." target='_blank'> Flythemes</a>";
	}