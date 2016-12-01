<?php
/*
 * Barcelona. Child Theme Function File
 * You can modify any function here. Simply copy any function from parent and paste here. It will override the parent's version.
 */

load_theme_textdomain( 'barcelona', get_stylesheet_directory() . '/languages' );

//Activar enlaces
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

add_action( 'after_setup_theme', 'barcelona_child_theme_scripts', 99 );

function barcelona_child_theme_scripts() {
	add_action( 'wp_enqueue_scripts', 'barcelona_enqueue_scripts_child', 99 );
}

/*
 * Enqueue Child Scripts & Styles
 */
function barcelona_enqueue_scripts_child() {
	if ( ! is_admin() ) {
		wp_register_style( 'barcelona-main-child', trailingslashit( get_stylesheet_directory_uri() ).'style.css', array(), BARCELONA_THEME_VERSION, 'all' );
		wp_enqueue_style( 'barcelona-main-child' );
	}
}


// Apply filter
add_filter('body_class','add_category_to_single');

function add_category_to_single($classes, $class) {
	if (is_single() ) {
		global $post;
		foreach((get_the_category($post->ID)) as $category) {
			// add category slug to the $classes array
			$classes[] = $category->category_nicename;
		}
	}
	// return the $classes array
	return $classes;
}

add_theme_support( 'post-formats', array( 'aside', 'quote' ) );


/*
 * Custom functionality: ultima hora
 */

function posts_ultima_hora() {
	global $wp_query;

	$ultima_hora_params = array(
		'category_name'  	=> 'ultima-hora',
		'posts_per_page'        => 1,
		'post_type'             => 'post',
		'post_status'           => 'publish',
	);

	// Get the ID of a given category
  $category_id = get_cat_ID( 'Última hora' );
  // Get the URL of this category
  $category_link = get_category_link( $category_id );


   $ultima_hora_q = new WP_Query($ultima_hora_params);

	 echo '<div class="ultima-hora-box">';
	 echo '<h2 class="title"><a href="'. esc_url($category_link) .'" title="Ir a las noticias de Última hora">Última hora</a></h2>';
	 echo '<ul>';

   if($ultima_hora_q->have_posts()) :
      while($ultima_hora_q->have_posts()) : $ultima_hora_q->the_post();
         echo '<li>';
		echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
		echo '</li>';
      endwhile;
   endif;

		echo '</ul>';
	echo '</div>';

	wp_reset_query();
 }



/*
 * Social Sharing
 */
if ( ! function_exists( 'barcelona_social_sharing' ) ) {
	function barcelona_social_sharing() {

		if ( barcelona_get_option( 'show_social_sharing' ) == 'on' ): ?>
		<div class="post-sharing">

			<ul class="list-inline text-center">
				<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_the_permalink() ); ?>" target="_blank" title="<?php printf( esc_html__( 'Share on %s', 'barcelona' ), 'Facebook' ); ?>"><span class="fa fa-facebook"></span></a></li>
				<li><a href="https://twitter.com/home?status=<?php echo urlencode( get_the_title() .' - '. get_the_permalink() ); ?>" target="_blank" title="<?php printf( esc_html__( 'Share on %s', 'barcelona' ), 'Twitter' ); ?>"><span class="fa fa-twitter"></span></a></li>

			</ul>

		</div><!-- .post-sharing -->
		<?php endif;

	}
}
